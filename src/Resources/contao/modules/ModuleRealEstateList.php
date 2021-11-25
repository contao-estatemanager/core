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

use Contao\BackendTemplate;
use Contao\StringUtil;
use Patchwork\Utf8;

/**
 * Front end module "real estate list".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ModuleRealEstateList extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateList';

    /**
     * Session manager object
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * Do not display the module if there are no real estates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateList'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        //$this->objFilterSession = FilterSession::getInstance();
        $this->sessionManager = SessionManager::getInstance();

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
                $intCount = isset($_SESSION['REAL_ESTATE_VISITED']) ? \count($_SESSION['REAL_ESTATE_VISITED']) : 0;
                break;
            case 'group':
                //list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameterByGroups($this->realEstateGroups, $this->filterMode, true, $this);
                list($arrColumns, $arrValues, $arrOptions) = $this->sessionManager->getParameterByGroups($this->realEstateGroups, $this);

                $intCount = RealEstateModel::countPublishedBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'type':
                //list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameterByTypes(StringUtil::deserialize($this->realEstateTypes, true), $this->filterMode, true, $this);
                list($arrColumns, $arrValues, $arrOptions) = $this->sessionManager->getParameterByTypes(StringUtil::deserialize($this->realEstateTypes, true), $this);

                $intCount = RealEstateModel::countPublishedBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'provider':
                //list($arrColumns, $arrValues, $options) = $this->objFilterSession->getParameterByGroups($this->realEstateGroups, $this->filterMode, true, $this);
                list($arrColumns, $arrValues, $arrOptions) = $this->sessionManager->getParameterByGroups($this->realEstateGroups, $this);

                $arrProvider = StringUtil::deserialize($this->provider, true);

                if (!\count($arrProvider))
                {
                    $intCount = 0;
                    break;
                }

                $arrColumns[] = "tl_real_estate.provider IN (" . implode(',', $arrProvider) . ")";

                $intCount = RealEstateModel::countPublishedBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'vacation':
                // ToDo: Der Filter-Modus wird nicht berücksichtigt. Muss mit dem SessionManager verheiratet werden.
                $arrColumns = array("tl_real_estate.wohnungTyp='ferienwohnung' OR tl_real_estate.hausTyp='ferienhaus' OR tl_real_estate.alsFerien='1'");

                $intCount = RealEstateModel::countPublishedBy($arrColumns, null);
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

        switch ($this->listSorting)
        {
            case 'dateAdded_asc':
                $arrOptions['order'] = "tl_real_estate.dateAdded";
                break;
            case 'dateAdded_desc':
                $arrOptions['order'] = "tl_real_estate.dateAdded DESC";
                break;
            case 'tstamp_asc':
                $arrOptions['order'] = "tl_real_estate.tstamp";
                break;
            case 'tstamp_desc':
                $arrOptions['order'] = "tl_real_estate.tstamp DESC";
                break;
        }

        if ($this->addCustomOrder)
        {
            $arrOptions['order'] = $this->customOrder . (isset($arrOptions['order']) ? ', ' . $arrOptions['order'] : '');
        }

        // HOOK: real estate list fetch items
        if (isset($GLOBALS['TL_HOOKS']['fetchItemsRealEstateList']) && \is_array($GLOBALS['TL_HOOKS']['fetchItemsRealEstateList']))
        {
            foreach ($GLOBALS['TL_HOOKS']['fetchItemsRealEstateList'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objRealEstate, $arrOptions, $this);
            }
        }

        switch ($this->listMode)
        {
            case 'visited':
                if (isset($_SESSION['REAL_ESTATE_VISITED']))
                {
                    $objRealEstate = RealEstateModel::findPublishedByIds($_SESSION['REAL_ESTATE_VISITED'], $arrOptions);
                }
                break;
            case 'group':
                //list($arrColumns, $arrValues, $options) = $this->objFilterSession->getParameterByGroups($this->realEstateGroups, $this->filterMode, true, $this);
                list($arrColumns, $arrValues, $options) = $this->sessionManager->getParameterByGroups($this->realEstateGroups, $this);

                $arrOptions = array_merge($options, $arrOptions);

                $objRealEstate = RealEstateModel::findPublishedBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'type':
                //list($arrColumns, $arrValues, $options) = $this->objFilterSession->getParameterByTypes(StringUtil::deserialize($this->realEstateTypes, true), $this->filterMode, true, $this);
                list($arrColumns, $arrValues, $options) = $this->sessionManager->getParameterByTypes(StringUtil::deserialize($this->realEstateTypes, true), $this);

                $arrOptions = array_merge($options, $arrOptions);

                $objRealEstate = RealEstateModel::findPublishedBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'provider':
                //list($arrColumns, $arrValues, $options) = $this->objFilterSession->getParameterByGroups($this->realEstateGroups, $this->filterMode, true, $this);
                list($arrColumns, $arrValues, $options) = $this->sessionManager->getParameterByGroups($this->realEstateGroups, $this);

                $arrOptions = array_merge($options, $arrOptions);

                $arrProvider = StringUtil::deserialize($this->provider, true);

                if (!\count($arrProvider))
                {
                    $objRealEstate = null;
                    break;
                }

                $arrColumns[] = "tl_real_estate.provider IN (" . implode(',', $arrProvider) . ")";

                $objRealEstate = RealEstateModel::findPublishedBy($arrColumns, $arrValues, $arrOptions);
                break;
            case 'vacation':
                // ToDo: Der Filter-Modus wird nicht berücksichtigt. Muss mit dem SessionManager verheiratet werden.
                $arrColumns[] = "(tl_real_estate.wohnungTyp='ferienwohnung' OR tl_real_estate.hausTyp='ferienhaus' OR tl_real_estate.alsFerien='1') AND nutzungsart!='gewerbe'";

                $objRealEstate = RealEstateModel::findPublishedBy($arrColumns, null, $arrOptions);
                break;
        }

        return $objRealEstate;
    }
}
