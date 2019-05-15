<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;

use Contao\CoreBundle\Exception\PageNotFoundException;

/**
 * Parent class for real estate modules.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
abstract class ModuleRealEstate extends \Module
{
    /**
     * Return an object property
     *
     * @param string $strKey The property name
     *
     * @return string The property value
     */
    public function __get($strKey)
    {
        switch ($strKey)
        {
            case 'realEstateGroups':
                return \StringUtil::deserialize($this->objModel->realEstateGroups, true);
                break;
        }

        return parent::__get($strKey);
    }

    /**
     * Parse a real estate and return it as string
     *
     * @param RealEstateModel $objRealEstate
     * @param integer|null    $typeId
     * @param string          $strClass
     *
     * @return string
     */
    protected function parseRealEstate($objRealEstate, $typeId=null, $strClass='')
    {
        // create real estate object
        $realEstate = new RealEstate($objRealEstate, $typeId);

        // create template
        $objTemplate = new \FrontendTemplate($this->realEstateTemplate);

        $objTemplate->class = $strClass;
        $objTemplate->realEstateId = $objRealEstate->id;
        $objTemplate->arrExtensions = array();

        // get template information
        $texts = $realEstate->getTexts(null, $this->maxTextLength);
        $statusTokens = \StringUtil::deserialize($this->statusTokens);

        // set information to template
        $objTemplate->link = $realEstate->generateExposeUrl($this->jumpTo);
        $objTemplate->marketingToken = $realEstate->getMarketingToken();
        $objTemplate->title = $realEstate->getTitle();
        $objTemplate->description = $texts['objektbeschreibung'];
        $objTemplate->linkExpose = $this->generateLink('Expose', $realEstate->generateExposeUrl($this->jumpTo), true);
        $objTemplate->linkHeadline = $this->generateLink($realEstate->getTitle(), $realEstate->generateExposeUrl($this->jumpTo));
        $objTemplate->address = $realEstate->getLocationString();
        $objTemplate->mainDetails = $realEstate->getMainDetails(3);
        $objTemplate->mainAttributes = $realEstate->getMainAttributes(4);
        $objTemplate->mainPrice = $realEstate->getMainPrice();
        $objTemplate->mainArea = $realEstate->getMainArea();
        $objTemplate->details = $realEstate->getDetails(['price'], true);
        $objTemplate->arrStatusTokens = $realEstate->getStatusTokens($statusTokens);

        // set real estate image
        $objModel = \FilesModel::findByUuid($realEstate->getMainImage());

        if($objModel === null)
        {
            // Set default image
            $defaultImage = \Config::get('defaultImage');

            if($defaultImage)
            {
                $objModel = \FilesModel::findByUuid($defaultImage);
            }
        }

        if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
        {
            $arrItem = array
            (
                'size' => $this->imgSize,
                'singleSRC' => $objModel->path
            );

            $this->addImageToTemplate($objTemplate, $arrItem, null, null, $objModel);
        }

        // HOOK: parse real estate
        if (isset($GLOBALS['TL_HOOKS']['parseRealEstate']) && \is_array($GLOBALS['TL_HOOKS']['parseRealEstate']))
        {
            foreach ($GLOBALS['TL_HOOKS']['parseRealEstate'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objTemplate, $realEstate, $this);
            }
        }

        return $objTemplate->parse();
    }

    /**
     * Parse one or more real estates
     *
     * @param integer|null      $typeId
     */
    protected function parseRealEstateList($typeId=null)
    {
        $limit = null;
        $offset = 0;

        // Maximum number of items
        if ($this->numberOfItems > 0)
        {
            $limit = $this->numberOfItems;
        }

        $this->Template->realEstates = array();
        $this->Template->empty = $GLOBALS['TL_LANG']['MSC']['noRealEstateResults'];

        $this->isEmpty = true;

        // Get the total number of items
        $total = $this->countItems();

        if ($total === 0)
        {
            $this->Template->addSorting = $this->addSorting = false;
        }

        // Split the results
        if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
        {
            // Adjust the overall limit
            if (isset($limit))
            {
                $total = min($limit, $total);
            }

            // Get the current page
            $id = 'page_n' . $this->id;
            $page = \Input::get($id) ?? 1;

            // Do not index or cache the page if the page number is outside the range
            if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
            {
                throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
            }

            // Set limit and offset
            $limit = $this->perPage;
            $offset += (max($page, 1) - 1) * $this->perPage;
            $skip = 0;

            // Overall limit
            if ($offset + $limit > $total + $skip)
            {
                $limit = $total + $skip - $offset;
            }

            // Add the pagination menu
            $objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
            $this->Template->pagination = $objPagination->generate("\n  ");
        }

        $objRealEstates = $this->fetchItems(($limit ?: 0), $offset);

        if($objRealEstates)
        {
            $this->isEmpty = false;

            $arrRealEstates = array();
            $count = 0;

            while ($objRealEstates->next()) {
                /** @var RealEstateModel $objRealEstate */
                $objRealEstate = $objRealEstates->current();

                $arrRealEstates[] = $this->parseRealEstate($objRealEstate, $typeId, ((++$count == 1) ? ' first' : '') . (($count == $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'), $count);
            }
        }

        $this->Template->realEstates = $arrRealEstates;
    }

    /**
     * Generate a link and return it as string
     *
     * @param string  $strTitle
     * @param string  $strLink
     *
     * @return string
     */
    protected function generateLink($strTitle, $strLink)
    {
        return sprintf('<a href="%s" title="%s"><span>%s</span></a>',
            $strLink,
            \StringUtil::specialchars(sprintf('Expose aufrufen: %s', $strTitle), true),
            $strTitle);
    }

    /**
     * Initialize the filter in the current session
     */
    protected function initializeFilterSession()
    {
        $_SESSION['FILTER_DATA'] = \is_array($_SESSION['FILTER_DATA']) ? $_SESSION['FILTER_DATA'] : array();
    }

    /**
     * Initialize the sorting in the current session
     */
    protected function initializeSortingSession()
    {
        if (\Input::post('FORM_SUBMIT') == 'sorting')
        {
            $_SESSION['SORTING'] = \Input::post('sorting');
            unset($_POST['sorting']);
        }
        elseif (!$_SESSION['SORTING'])
        {
            $_SESSION['SORTING'] = 'dateAdded_asc';
        }
    }

    /**
     * Update visited objects in the current session
     */
    protected function updateVisitedSession($realEstateId)
    {
        $_SESSION['REAL_ESTATE_VISITED'] = \is_array($_SESSION['REAL_ESTATE_VISITED']) ? $_SESSION['REAL_ESTATE_VISITED'] : array();

        if (($key = \array_search($realEstateId, $_SESSION['REAL_ESTATE_VISITED'])) !== false)
        {
            unset($_SESSION['REAL_ESTATE_VISITED'][$key]);
        }

        array_unshift($_SESSION['REAL_ESTATE_VISITED'], $realEstateId);
    }
}
