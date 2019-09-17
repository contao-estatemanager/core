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
     * Force empty list
     * @var boolean
     */
    protected $forceEmpty = false;
    
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

        $texts = $realEstate->getTexts(null, $this->maxTextLength);
        $statusTokens = \StringUtil::deserialize($this->statusTokens);

        // set information to template
        $objTemplate->title        = $realEstate->getTitle();
        $objTemplate->jumpTo       = $this->jumpTo;
        $objTemplate->link         = $realEstate->generateExposeUrl($this->jumpTo);
        $objTemplate->linkExpose   = $this->generateLink(Translator::translateExpose('button_expose'), $realEstate->generateExposeUrl($this->jumpTo), true);
        $objTemplate->linkHeadline = $this->generateLink($realEstate->getTitle(), $realEstate->generateExposeUrl($this->jumpTo));

        $objTemplate->address      = $realEstate->getLocationString();
        $objTemplate->teaser       = $texts['dreizeiler'];
        $objTemplate->description  = $texts['objektbeschreibung'];

        $objTemplate->marketingToken  = $realEstate->getMarketingToken();
        $objTemplate->arrStatusTokens = $realEstate->getStatusTokens($statusTokens);

        $objTemplate->mainDetails    = $realEstate->getMainDetails(\Config::get('defaultNumberOfMainDetails') ?: 3);
        $objTemplate->mainAttributes = $realEstate->getMainAttributes(\Config::get('defaultNumberOfMainAttr') ?: 3);
        $objTemplate->mainPrice      = $realEstate->getMainPrice();
        $objTemplate->mainArea       = $realEstate->getMainArea();

        $objTemplate->details        = $realEstate->getDetails(['price'], true);
        $objTemplate->objektart      = $realEstate->getFields(['objektart'])[0];

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

        if ($this->forceEmpty)
        {
            $this->Template->empty = sprintf($GLOBALS['TL_LANG']['MSC']['noUniqueRealEstateResult'], '<span class="unique">'.$_SESSION['FILTER_DATA']['last_unique'].'</span>');
            return;
        }

        $this->isEmpty = true;

        // Get the total number of items
        $total = $this->Template->totalItems = $this->totalItems = $this->countItems();

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
     * @param null $size
     *
     * @return boolean
     */
    protected function addMainImageToTemplate($objTemplate, $realEstate, $size = null)
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

        if($size !== null)
        {
            $imgSize = $size;
        }
        else
        {
            $imgSize = $this->imgSize;
        }

        return $this->addSingleImageToTemplate($objTemplate, $objModel, $imgSize);
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
    protected function addSorting()
    {
        if (\Input::post('FORM_SUBMIT') == 'sorting')
        {
            $_SESSION['SORTING'] = \Input::post('sorting');
            unset($_POST['sorting']);
        }

        if ($this->forceEmpty)
        {
            $this->Template->addSorting = false;
            return;
        }

        if ($this->addSorting)
        {
            \System::loadLanguageFile('tl_real_estate_filter');

            $defaultSorting = \Config::get('defaultSorting').'_desc';
            $arrOptions = array($defaultSorting => Translator::translateFilter($defaultSorting));

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

            // HOOK: add real estate sorting
            if (isset($GLOBALS['TL_HOOKS']['addRealEstateSorting']) && \is_array($GLOBALS['TL_HOOKS']['addRealEstateSorting']))
            {
                foreach ($GLOBALS['TL_HOOKS']['addRealEstateSorting'] as $callback)
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($arrOptions, $this);
                }
            }

            $this->Template->sortingOptions = $arrOptions;
            $this->Template->selectedSortingOption = $_SESSION['SORTING'];
        }
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
    
    protected function redirectIfUnique()
    {
        if ($_SESSION['FILTER_DATA']['unique'])
        {
            $objRealEstate = RealEstateModel::findOneBy('objektnrExtern', $_SESSION['FILTER_DATA']['unique']);
            $_SESSION['FILTER_DATA']['last_unique'] = $_SESSION['FILTER_DATA']['unique'];
            unset($_SESSION['FILTER_DATA']['unique']);

            if ($objRealEstate === null)
            {
                $this->forceEmpty = true;
            }
            else
            {
                $objJumpTo = \PageModel::findByPk($this->jumpTo);

                if ($objJumpTo instanceof \PageModel)
                {
                    $realEstate = new RealEstate($objRealEstate, null);

                    $this->redirect($realEstate->generateExposeUrl($objJumpTo->id));
                }
            }
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
