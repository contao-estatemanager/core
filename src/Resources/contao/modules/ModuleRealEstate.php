<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */


namespace ContaoEstateManager;

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
        $objTemplate->linkExpose = $this->generateLink(Translator::translateExpose('button_expose'), $realEstate->generateExposeUrl($this->jumpTo), true);
        $objTemplate->linkHeadline = $this->generateLink($realEstate->getTitle(), $realEstate->generateExposeUrl($this->jumpTo));
        $objTemplate->address = $realEstate->getLocationString();
        $objTemplate->mainDetails = $realEstate->getMainDetails(\Config::get('defaultNumberOfMainDetails') ?: 3);
        $objTemplate->mainAttributes = $realEstate->getMainAttributes(\Config::get('defaultNumberOfMainAttr') ?: 3);
        $objTemplate->mainPrice = $realEstate->getMainPrice();
        $objTemplate->mainArea = $realEstate->getMainArea();
        $objTemplate->details = $realEstate->getDetails(['price'], true);
        $objTemplate->arrStatusTokens = $realEstate->getStatusTokens($statusTokens);

        // add provider
        $objTemplate->addProvider = !!$this->addProvider;

        if($this->addProvider)
        {
            $objTemplate->provider = $this->parseProvider($realEstate);
        }

        // add contact person
        $objTemplate->addContactPerson = !!$this->addContactPerson;

        if($this->addContactPerson)
        {
            $objTemplate->contactPerson = $this->parseContactPerson($realEstate);
        }

        // set real estate image
        $objTemplate->addImage = $this->addMainImageToTemplate($objTemplate, $realEstate);

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
        $arrRealEstates = array();

        if($objRealEstates)
        {
            $this->isEmpty = false;

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
     * Parse provider
     *
     * @param $realEstate
     *
     * @return string: parsed provider template
     */
    public function parseProvider($realEstate)
    {
        $arrProvider = $realEstate->getProvider();

        if($arrProvider === null)
        {
            return '';
        }

        $objTemplate = new \FrontendTemplate($this->realEstateProviderTemplate);
        $objTemplate->setData($arrProvider);

        if($arrProvider['singleSRC'])
        {
            $objTemplate->addImage = $this->addSingleImageToTemplate($objTemplate, $arrProvider['singleSRC'], $this->providerImgSize);
        }

        return $objTemplate->parse();
    }

    /**
     * Parse contact person
     *
     * @param $realEstate
     * @param bool $forceCompleteAddress
     *
     * @return string: parsed contact person template
     */
    public function parseContactPerson($realEstate, $forceCompleteAddress=false)
    {
        $arrContactPerson = $realEstate->getContactPerson($forceCompleteAddress);

        if($arrContactPerson === null)
        {
            return '';
        }

        $objTemplate = new \FrontendTemplate($this->realEstateContactPersonTemplate);
        $objTemplate->setData($arrContactPerson);

        if($arrContactPerson['singleSRC'])
        {
            $objTemplate->addImage = $this->addSingleImageToTemplate($objTemplate, $arrContactPerson['singleSRC'], $this->contactPersonImgSize);
        }

        return $objTemplate->parse();
    }

    /**
     * Add main image to template
     *
     * @param $objTemplate
     * @param $realEstate
     *
     * @return boolean
     */
    protected function addMainImageToTemplate($objTemplate, $realEstate)
    {
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

        return $this->addSingleImageToTemplate($objTemplate, $objModel, $this->imgSize);
    }

    /**
     * Add image to template
     *
     * @param $objTemplate
     * @param $varSingleSrc
     * @param $imgSize
     *
     * @return boolean
     */
    public function addSingleImageToTemplate($objTemplate, $varSingleSrc, $imgSize)
    {
        if ($varSingleSrc)
        {
            if (!($varSingleSrc instanceof \FilesModel) && \Validator::isUuid($varSingleSrc))
            {
                $objModel = \FilesModel::findByUuid($varSingleSrc);
            }
            else
            {
                $objModel = $varSingleSrc;
            }

            if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
            {
                $image = array
                (
                    'id'         => $objModel->id,
                    'uuid'       => $objModel->uuid,
                    'name'       => $objModel->basename,
                    'singleSRC'  => $objModel->path,
                    'filesModel' => $objModel->current(),
                    'size'       => $imgSize,
                );

                $this->addImageToTemplate($objTemplate, $image, null, null, $objModel);

                return true;
            }
        }

        return false;
    }

    /**
     * Adding sorting options to a list
     */
    protected function addSorting(){
        if ($this->addSorting)
        {
            $arrOptions = array('dateAdded_asc' => Translator::translateFilter('dateAdded_asc'));

            if (($objCurrentType = $this->objFilterSession->getCurrentRealEstateType()) !== null)
            {
                $sortingOptions = \StringUtil::deserialize($objCurrentType->sortingOptions);

                foreach ($sortingOptions as $option)
                {
                    $asc = $option['field'].'_asc';
                    $desc = $option['field'].'_desc';

                    $arrOptions[$asc] = Translator::translateFilter($asc);
                    $arrOptions[$desc] = Translator::translateFilter($desc);
                }
            }

            $this->Template->sortingOptions = $arrOptions;
            $this->Template->selectedSortingOption = $_SESSION['SORTING'];
        }
    }

    /**
     * Return the order option as string
     *
     * @return string
     */
    protected function getOrderOption()
    {
        $strOrder = $_SESSION['SORTING'];

        if (strpos($strOrder, '_asc'))
        {
            $strOrder = str_replace('_asc', '', $strOrder) . ' ASC';
        }
        elseif (strpos($strOrder, '_desc'))
        {
            $strOrder = str_replace('_desc', '', $strOrder) . ' DESC';
        }

        return $strOrder;
    }

    /**
     * Generate a link and return it as string
     *
     * @param string  $strTitle
     * @param string  $strLink
     *
     * @return string
     */
    public function generateLink($strTitle, $strLink)
    {
        return sprintf('<a href="%s" title="%s"><span>%s</span></a>',
            $strLink,
            \StringUtil::specialchars(sprintf('%s', $strTitle), true),
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
