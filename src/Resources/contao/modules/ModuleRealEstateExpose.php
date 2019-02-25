<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;

use Patchwork\Utf8;

/**
 * Front end module "real estate expose".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ModuleRealEstateExpose extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateExpose';

    /**
     * Real estate object
     * @var RealEstate
     */
    protected $realEstate;

    /**
     * Real estate type model
     * @var RealEstateTypeModel
     */
    protected $objRealEstateType;

    /**
     * Template
     * @var string
     */
    protected $strTable = 'tl_real_estate';

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateExpose'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        // Set the item from the auto_item parameter
        if (!isset($_GET['items']) && \Config::get('useAutoItem') && isset($_GET['auto_item']))
        {
            \Input::setGet('items', \Input::get('auto_item'));
        }

        // Return an empty string if "items" is not set (to combine list and reader on same page)
        if (!\Input::get('items'))
        {
            return '';
        }

        \System::loadLanguageFile('tl_real_estate_expose');

        // HOOK: real estate expose generate
        if (isset($GLOBALS['TL_HOOKS']['generateRealEstateExpose']) && \is_array($GLOBALS['TL_HOOKS']['generateRealEstateExpose']))
        {
            foreach ($GLOBALS['TL_HOOKS']['generateRealEstateExpose'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this);
            }
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        /** @var \PageModel $objPage */
        global $objPage;

        $objRealEstate = RealEstateModel::findPublishedByIdOrAlias(\Input::get('items'));
        $realEstate = new RealEstate($objRealEstate, null);

        $arrCustomSections = array();
        $arrSections = array('header', 'contentTop', 'left', 'right', 'main', 'contentBottom', 'footer');
        $arrModules = \StringUtil::deserialize($this->exposeModules);

        $arrModuleIds = array();

        // Filter the disabled modules
        foreach ($arrModules as $module)
        {
            if ($module['enable'])
            {
                $arrModuleIds[] = $module['mod'];
            }
        }

        // Get all modules in a single DB query
        $objModules = ExposeModuleModel::findMultipleByIds($arrModuleIds);

        if ($objModules !== null || $arrModules[0]['mod'] == 0)
        {
            $arrMapper = array();

            // Create a mapper array in case a module is included more than once
            if ($objModules !== null)
            {
                while ($objModules->next())
                {
                    $arrMapper[$objModules->id] = $objModules->current();
                }
            }

            foreach ($arrModules as $arrModule)
            {
                // Disabled module
                if (!$arrModule['enable'])
                {
                    continue;
                }

                // Replace the module ID with the module model
                if ($arrModule['mod'] > 0 && isset($arrMapper[$arrModule['mod']]))
                {
                    $arrModule['mod'] = $arrMapper[$arrModule['mod']];
                }

                // Generate the modules
                if (\in_array($arrModule['col'], $arrSections))
                {
                    $this->Template->{$arrModule['col']} .= $this->getExposeModule($arrModule['mod'], $realEstate, $arrModule['col']);
                }
                else
                {
                    $arrCustomSections[$arrModule['col']] .= $this->getExposeModule($arrModule['mod'], $realEstate, $arrModule['col']);
                }
            }
        }

        $this->Template->sections = $arrCustomSections;
        $this->Template->realEstateId = $objRealEstate->id;
    }

    /**
     * Generate a expose module and return it as string
     *
     * @param mixed  $intId     A module ID or a Model object
     * @param string $strColumn The name of the column
     *
     * @return string The module HTML markup
     */
    public function getExposeModule($intId, $realEstate, $strColumn='main')
    {
        if (!\is_object($intId) && !\strlen($intId))
        {
            return '';
        }

        if (\is_object($intId))
        {
            $objRow = $intId;
        }
        else
        {
            $objRow = ExposeModuleModel::findByPk($intId);

            if ($objRow === null)
            {
                return '';
            }
        }

        // Check the visibility (see #6311)
        if (!static::isVisibleElement($objRow))
        {
            return '';
        }

        $strClass = ExposeModule::findClass($objRow->type);

        // Return if the class does not exist
        if (!class_exists($strClass))
        {
            \System::log('Module class "'.$strClass.'" (module "'.$objRow->type.'") does not exist', __METHOD__, TL_ERROR);

            return '';
        }

        $objRow->typePrefix = 'expose_mod_';

        /** @var ExposeModule $objModule */
        $objModule = new $strClass($objRow, $realEstate, $strColumn);
        $strBuffer = $objModule->generate();

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['getExposeModule']) && \is_array($GLOBALS['TL_HOOKS']['getExposeModule']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getExposeModule'] as $callback)
            {
                $strBuffer = \System::importStatic($callback[0])->{$callback[1]}($objRow, $strBuffer, $objModule);
            }
        }

        // Disable indexing if protected
        if ($objModule->protected && !preg_match('/^\s*<!-- indexer::stop/', $strBuffer))
        {
            $strBuffer = "\n<!-- indexer::stop -->". $strBuffer ."<!-- indexer::continue -->\n";
        }

        return $strBuffer;
    }

    /**
     * Check whether an element is visible in the front end
     *
     * @param ExposeModuleModel $objElement The element model
     *
     * @return boolean True if the element is visible
     */
    public static function isVisibleElement(ExposeModuleModel $objElement)
    {
        $blnReturn = true;

        // Only apply the restrictions in the front end
        if (TL_MODE == 'FE')
        {
            // Protected element
            if ($objElement->protected)
            {
                if (!FE_USER_LOGGED_IN)
                {
                    $blnReturn = false;
                }
                else
                {
                    $groups = \StringUtil::deserialize($objElement->groups);

                    if (empty($groups) || !\is_array($groups) || !\count(array_intersect($groups, \FrontendUser::getInstance()->groups)))
                    {
                        $blnReturn = false;
                    }
                }
            }

            // Show to guests only
            elseif ($objElement->guests && FE_USER_LOGGED_IN)
            {
                $blnReturn = false;
            }
        }

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['isVisibleElement']) && \is_array($GLOBALS['TL_HOOKS']['isVisibleElement']))
        {
            foreach ($GLOBALS['TL_HOOKS']['isVisibleElement'] as $callback)
            {
                $blnReturn = \System::importStatic($callback[0])->{$callback[1]}($objElement, $blnReturn);
            }
        }

        return $blnReturn;
    }


    /**
     * Collect necessary filter parameter for similar real estates and return it as array
     *
     * @return array
     */
    protected function getFilterOptions()
    {
        $t = $this->strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        $arrColumns[] = "$t.id!=?";
        $arrValues[] = $this->realEstate->getId();

        if (!empty($this->objRealEstateType->nutzungsart))
        {
            $arrColumns[] = "$t.nutzungsart=?";
            $arrValues[] = $this->objRealEstateType->nutzungsart;
        }
        if ($this->objRealEstateType->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumns[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        if ($this->objRealEstateType->vermarktungsart === 'miete_leasing')
        {
            $arrColumns[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }
        if (!empty($this->objRealEstateType->objektart))
        {
            $arrColumns[] = "$t.objektart=?";
            $arrValues[] = $this->objRealEstateType->objektart;
        }

        if ($_SESSION['FILTER_DATA']['price_from'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->price.">=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
        }
        if ($_SESSION['FILTER_DATA']['price_to'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->price."<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
        }
        if ($_SESSION['FILTER_DATA']['room_from'])
        {
            $arrColumns[] = "$t.anzahlZimmer>=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_from'];
        }
        if ($_SESSION['FILTER_DATA']['room_to'])
        {
            $arrColumns[] = "$t.anzahlZimmer<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_to'];
        }
        if ($_SESSION['FILTER_DATA']['area_from'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->area.">=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_from'];
        }
        if ($_SESSION['FILTER_DATA']['area_to'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->area."<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_to'];
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }
}