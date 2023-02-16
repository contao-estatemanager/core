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

use Contao\Config;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Environment;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\Module;
use Contao\PageModel;
use Contao\Pagination;
use Contao\StringUtil;
use Contao\System;
use Contao\Validator;

/**
 * Parent class for real estate modules.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
abstract class ModuleRealEstate extends Module
{
    /**
     * Force empty list
     * @var bool
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
                return StringUtil::deserialize($this->objModel->realEstateGroups, true);
        }

        return parent::__get($strKey);
    }

    /**
     * Parse a real estate and return it as string
     *
     * @param RealEstateModel $objRealEstate
     * @param integer|null $typeId
     * @param string $strClass
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function parseRealEstate(RealEstateModel $objRealEstate, int $typeId=null, string $strClass=''): string
    {
        $realEstate  = new RealEstateModulePreparation($objRealEstate, $this, $typeId);
        $objTemplate = new FrontendTemplate($this->realEstateTemplate);

        $objTemplate->class         = $strClass;
        $objTemplate->realEstate    = $realEstate;
        $objTemplate->arrExtensions = array();

        $objTemplate->jumpTo        = $this->jumpTo;
        $objTemplate->buttonLabel   = Translator::translateExpose('button_expose');
        $objTemplate->imgSize        = $this->imgSize;

        // Adding item extension: provider
        $objTemplate->addProvider = !!$this->addProvider;

        if($this->addProvider)
        {
            $objTemplate->provider = $this->parseProvider($realEstate);
        }

        // Adding item extension: contact person
        $objTemplate->addContactPerson = !!$this->addContactPerson;

        if($this->addContactPerson)
        {
            $objTemplate->contactPerson = $this->parseContactPerson($realEstate);
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
     * @param integer|null $typeId
     *
     * @throws \Exception
     */
    protected function parseRealEstateList(int $typeId=null): void
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
            $this->Template->empty = sprintf($GLOBALS['TL_LANG']['MSC']['noUniqueRealEstateResult'] ?? '', '<span class="unique">'.$_SESSION['FILTER_DATA']['last_unique'].'</span>');
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
                throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
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
            $objPagination = new Pagination($total, $this->perPage, Config::get('maxPaginationLinks'), $id);
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

                $arrRealEstates[] = $this->parseRealEstate($objRealEstate, $typeId, ((++$count == 1) ? ' first' : '') . (($count == $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'));
            }
        }

        $this->Template->realEstates = $arrRealEstates;
    }

    /**
     * Parse provider
     *
     * @param RealEstate $realEstate
     *
     * @return string: parsed provider template
     *
     * @throws \Exception
     */
    public function parseProvider(RealEstate $realEstate): string
    {
        $objProvider = $realEstate->getProvider();
        $arrProvider = $objProvider->row();

        if($arrProvider === null)
        {
            return '';
        }

        $objTemplate = new FrontendTemplate($this->realEstateProviderTemplate);
        $objTemplate->setData($arrProvider);
        $objTemplate->realEstate = $realEstate;

        if($arrProvider['singleSRC'])
        {
            $objTemplate->addImage = $this->addSingleImageToTemplate($objTemplate, $arrProvider['singleSRC'], $this->providerImgSize);
        }

        return $objTemplate->parse();
    }

    /**
     * Parse contact person
     *
     * @param RealEstate $realEstate
     * @param bool $forceCompleteAddress
     *
     * @return string: parsed contact person template
     *
     * @throws \Exception
     */
    public function parseContactPerson(RealEstate $realEstate, bool $forceCompleteAddress=false): string
    {
        $arrContactPerson = $realEstate->getContactPerson($forceCompleteAddress);

        if($arrContactPerson === null)
        {
            return '';
        }

        $objTemplate = new FrontendTemplate($this->realEstateContactPersonTemplate);
        $objTemplate->setData($arrContactPerson);
        $objTemplate->realEstate = $realEstate;

        if($arrContactPerson['singleSRC'])
        {
            $objTemplate->addImage = $this->addSingleImageToTemplate($objTemplate, $arrContactPerson['singleSRC'], $this->contactPersonImgSize);
        }

        return $objTemplate->parse();
    }

    /**
     * Add image to template
     *
     * @param $objTemplate
     * @param $varSingleSrc
     * @param $imgSize
     *
     * @return bool
     */
    public function addSingleImageToTemplate(FrontendTemplate $objTemplate, $varSingleSrc, $imgSize): bool
    {
        if ($varSingleSrc)
        {
            if (!($varSingleSrc instanceof FilesModel) && Validator::isUuid($varSingleSrc))
            {
                $objModel = FilesModel::findByUuid($varSingleSrc);
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
        if (Input::post('FORM_SUBMIT') == 'sorting')
        {
            $_SESSION['SORTING'] = Input::post('sorting');
            unset($_POST['sorting']);
        }

        if ($this->forceEmpty)
        {
            $this->Template->addSorting = false;
            return;
        }

        if ($this->addSorting)
        {
            System::loadLanguageFile('tl_real_estate_filter');

            $defaultSorting = Config::get('defaultSorting').'_desc';
            $arrOptions = array($defaultSorting => Translator::translateFilter($defaultSorting));

            if (($objCurrentType = $this->objFilterSession->getCurrentRealEstateType()) !== null)
            {
                $sortingOptions = StringUtil::deserialize($objCurrentType->sortingOptions);

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
            $this->Template->selectedSortingOption = $_SESSION['SORTING'] ?? null;
        }
    }

    protected function redirectIfUnique()
    {
        if ($_SESSION['FILTER_DATA']['unique'] ?? null)
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
                $objJumpTo = PageModel::findByPk($this->jumpTo);

                if ($objJumpTo instanceof PageModel)
                {
                    $realEstate = new RealEstate($objRealEstate, null);

                    $this->redirect($realEstate->generateExposeUrl($objJumpTo));
                }
            }
        }
    }

    /**
     * Update visited objects in the current session
     */
    protected function updateVisitedSession($realEstateId)
    {
        $_SESSION['REAL_ESTATE_VISITED'] = isset($_SESSION['REAL_ESTATE_VISITED']) && \is_array($_SESSION['REAL_ESTATE_VISITED']) ? $_SESSION['REAL_ESTATE_VISITED'] : array();

        if (($key = array_search($realEstateId, $_SESSION['REAL_ESTATE_VISITED'])) !== false)
        {
            unset($_SESSION['REAL_ESTATE_VISITED'][$key]);
        }

        array_unshift($_SESSION['REAL_ESTATE_VISITED'], $realEstateId);
    }
}
