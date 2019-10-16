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
use Patchwork\Utf8;

/**
 * Front end module "real estate list".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ModuleRealEstateList extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateList';

    /**
     * Do not display the module if there are no real etates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateList'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->objFilterSession = FilterSession::getInstance();

        // HOOK: real estate list generate
        if (isset($GLOBALS['TL_HOOKS']['generateRealEstateList']) && \is_array($GLOBALS['TL_HOOKS']['generateRealEstateList']))
        {
            foreach ($GLOBALS['TL_HOOKS']['generateRealEstateList'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this);
            }
        }

        $strBuffer = parent::generate();

        return (!$this->countItems() && $this->hideOnEmpty) ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->parseRealEstateList();
    }

    /**
     * Count the total matching items
     *
     * @return integer
     */
    protected function countItems()
    {
        $intCount = 0;

        switch ($this->listMode)
        {
            case 'visited':
                $intCount = is_array($_SESSION['REAL_ESTATE_VISITED']) ? count($_SESSION['REAL_ESTATE_VISITED']) : 0;
                break;
            case 'group':
                list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameterByGroups($this->realEstateGroups, $this->filterMode);

                $intCount = RealEstateModel::countBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'vacation':
                $arrColumns = array("tl_real_estate.wohnungTyp='ferienwohnung' OR tl_real_estate.hausTyp='ferienhaus' OR tl_real_estate.alsFerien='1'");

                $intCount = RealEstateModel::countBy($arrColumns, null);
                break;
        }

        // HOOK: real estate list count items
        if (isset($GLOBALS['TL_HOOKS']['countItemsRealEstateList']) && \is_array($GLOBALS['TL_HOOKS']['countItemsRealEstateList']))
        {
            foreach ($GLOBALS['TL_HOOKS']['countItemsRealEstateList'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($intCount, $this);
            }
        }

        return $intCount;
    }

    /**
     * Fetch the matching items
     *
     * @param integer $limit
     * @param integer $offset
     *
     * @return \Model\Collection|RealEstateModel|null
     */
    protected function fetchItems($limit, $offset)
    {
        $objRealEstate = null;
        $arrOptions = array();

        $arrOptions['limit']  = $limit;
        $arrOptions['offset'] = $offset;

        switch ($this->listMode)
        {
            case 'visited':
                if (is_array($_SESSION['REAL_ESTATE_VISITED']))
                {
                    $objRealEstate = RealEstateModel::findMultipleByIds($_SESSION['REAL_ESTATE_VISITED'], $arrOptions);
                }
                break;
            case 'group':
                list($arrColumns, $arrValues, $options) = $this->objFilterSession->getParameterByGroups($this->realEstateGroups, $this->filterMode);

                $arrOptions = array_merge($arrOptions, $options);

                $objRealEstate = RealEstateModel::findBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'vacation':
                $arrColumns[] = "tl_real_estate.wohnungTyp='ferienwohnung' OR tl_real_estate.hausTyp='ferienhaus' OR tl_real_estate.alsFerien='1'";

                $objRealEstate = RealEstateModel::findBy($arrColumns, null);
                break;
        }

        // HOOK: real estate list fetch items
        if (isset($GLOBALS['TL_HOOKS']['fetchItemsRealEstateList']) && \is_array($GLOBALS['TL_HOOKS']['fetchItemsRealEstateList']))
        {
            foreach ($GLOBALS['TL_HOOKS']['fetchItemsRealEstateList'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objRealEstate, $limit, $offset, $this);
            }
        }

        return $objRealEstate;
    }
}
