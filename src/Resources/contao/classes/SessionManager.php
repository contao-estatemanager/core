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
use Contao\Frontend;
use Contao\Model\Collection;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\Validator;

class SessionManager extends Frontend
{
    /**
     * Object instance (Singleton)
     * @var SessionManager
     */
    protected static $objInstance;

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_real_estate';

    /**
     * PageModel of the current page
     * @var PageModel
     */
    protected $objPage;

    /**
     * PageModel of the current root page
     * @var PageModel
     */
    protected $objRootPage;

    /**
     * Real estate group object
     * @var Collection|RealEstateGroupModel
     */
    protected $objGroups;

    /**
     * Real estate type object
     * @var Collection|RealEstateTypeModel
     */
    protected $objTypes;

    /**
     * Prevent direct instantiation (Singleton)
     */
    protected function __construct()
    {
        /** @var PageModel $objPage */
        global $objPage;

        if ($objPage !== null)
        {
            $this->objPage = $objPage->loadDetails();
            $this->objRootPage = PageModel::findByPk($this->objPage->rootId);
        }

        $this->objGroups = RealEstateGroupModel::findAllPublished();
        $this->objTypes = RealEstateTypeModel::findAllPublished();
    }

    /**
     * Prevent cloning of the object (Singleton)
     */
    final public function __clone() {}

    /**
     * Return the current object instance (Singleton)
     */
    public static function getInstance(): SessionManager
    {
        if (static::$objInstance === null)
        {
            static::$objInstance = new static();
            static::$objInstance->initialize();
        }

        return static::$objInstance;
    }

    /**
     * Load all needed data
     */
    protected function initialize(): void
    {
        $_SESSION['FILTER_DATA'] = $_SESSION['FILTER_DATA'] ?? [];
    }

    public function getParameter(array $arrGroups, $objModule): array
    {
        $objSelectedType = $this->getSelectedType();

        if ($objSelectedType !== null)
        {
            return $this->getTypeParameter($objSelectedType, $objModule);
        }

        return $this->getParameterByGroups($arrGroups, $objModule, true);
    }

    protected function getTypeParameter($objType, $objModule): array
    {
        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $objModule);

        if ($objType === null)
        {
            // ToDo: Throw Exception
        }

        $this->addQueryFragmentBasics($objType, $arrColumns, $arrValues);
        $this->addQueryFragmentCountry($arrColumns, $arrValues);
        $this->addQueryFragmentLocation($arrColumns, $arrValues);
        $this->addQueryFragmentPrice($objType, $arrColumns, $arrValues);
        $this->addQueryFragmentRoom($arrColumns, $arrValues);
        $this->addQueryFragmentArea($objType, $arrColumns, $arrValues);
        $this->addQueryFragmentPeriod($arrColumns, $arrValues);

        $arrOptions['order']  = $this->getOrderOption();

        // HOOK: get filtered type parameter
        if (isset($GLOBALS['TL_HOOKS']['getFilteredTypeParameter']) && \is_array($GLOBALS['TL_HOOKS']['getFilteredTypeParameter']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getFilteredTypeParameter'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $objModule);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect and return parameter by a given set of groups
     */
    public function getParameterByGroups(array $arrGroups, $objModule, bool $blnFiltered=false): array
    {
        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        $arrTypeColumns = array();

        $objTypes = $this->getTypeCollectionByPids($arrGroups);

        if ($objTypes === null)
        {
            // ToDo: Throw Exception
        }

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $objModule);
        //$this->addQueryFragmentCountry($arrColumns, $arrValues); // ToDo: Sollen normale Immobilienlisten anhand eines Landes filtern? Woher kommt diese Information? (aus dem Modul?)

        foreach ($objTypes as $objType)
        {
            $arrColumn = array();

            $this->addQueryFragmentBasics($objType, $arrColumn, $arrValues);

            if ($blnFiltered)
            {
                $this->addQueryFragmentCountry($arrColumn, $arrValues);
                $this->addQueryFragmentLocation($arrColumn, $arrValues);
                $this->addQueryFragmentPrice($objType, $arrColumn, $arrValues);
                $this->addQueryFragmentRoom($arrColumn, $arrValues);
                $this->addQueryFragmentArea($objType, $arrColumn, $arrValues);
                $this->addQueryFragmentPeriod($arrColumn, $arrValues);
            }

            // ToDo: Hook to add new toggle filter

            $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
        }

        $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        $arrOptions['order'] = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['CEM_HOOKS']['getParameterByGroups']) && \is_array($GLOBALS['CEM_HOOKS']['getParameterByGroups']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getParameterByGroups'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $objModule);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect and return parameter by a given set of types
     */
    public function getParameterByTypes(array $arrTypes, $objModule): array
    {
        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        $arrTypeColumns = array();

        $objTypes = $this->getTypeCollectionByIds($arrTypes);

        if ($objTypes === null)
        {
            // ToDo: Throw Exception
        }

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $objModule);
        //$this->addQueryFragmentCountry($arrColumns, $arrValues); // ToDo: Sollen normale Immobilienlisten anhand eines Landes filtern? Woher kommt diese Information? (aus dem Modul?)

        foreach ($objTypes as $objType)
        {
            $arrColumn = array();

            $this->addQueryFragmentBasics($objType, $arrColumn, $arrValues);

            // ToDo: Hook to add new toggle filter

            $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
        }

        $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        $arrOptions['order'] = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['CEM_HOOKS']['getParameterByTypes']) && \is_array($GLOBALS['CEM_HOOKS']['getParameterByTypes']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getParameterByTypes'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $objModule);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Add language query fragment
     *
     * @param array               $arrColumns
     * @param array               $arrValues
     */
    protected function addQueryFragmentLanguage(&$arrColumns, &$arrValues): void
    {
        $t = static::$strTable;

        if ($this->objRootPage->realEstateQueryLanguage)
        {
            $arrColumns[] = "$t.sprache=?";
            $arrValues[]  = $this->objRootPage->realEstateQueryLanguage;
        }
    }

    /**
     * Add country query fragment
     *
     * @param array               $arrColumns
     * @param array               $arrValues
     */
    protected function addQueryFragmentCountry(&$arrColumns, &$arrValues): void
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['country'] ?? null)
        {
            $arrColumns[] = "$t.land=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['country'];
        }
        elseif ($this->objRootPage->realEstateQueryCountry)
        {
            $arrColumns[] = "$t.land=?";
            $arrValues[] = $this->objRootPage->realEstateQueryCountry;
        }
    }

    /**
     * Add query fragment for the location field
     *
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentLocation(&$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['location'] ?? null)
        {
            $location = $_SESSION['FILTER_DATA']['location'];
            $matches = array();

            if (preg_match('/[0-9]{3,5}/', $location, $matches, PREG_UNMATCHED_AS_NULL))
            {
                $arrColumn[] = "$t.plz LIKE ?";
                $arrValues[] = $matches[0].'%';
                $location = trim(str_replace($matches[0], '', $location));
            }

            if ($location)
            {
                $arrColumn[] = "($t.ort LIKE ? OR $t.regionalerZusatz LIKE ?)";
                $arrValues[] = $location.'%';
                $arrValues[] = $location.'%';
            }
        }
    }

    /**
     * Add query fragment for price fields
     *
     * @param RealEstateTypeModel $objRealEstateType
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentPrice($objRealEstateType, &$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['price_per'] ?? null && $_SESSION['FILTER_DATA']['price_per'] === 'square_meter')
        {
            if ($_SESSION['FILTER_DATA']['price_from'] ?? null)
            {
                if ($objRealEstateType->vermarktungsart === 'miete_leasing')
                {
                    $arrColumn[] = "$t.mietpreisProQm>=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
                }
                else
                {
                    $arrColumn[] = "$t.kaufpreisProQm>=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
                }
            }
            if ($_SESSION['FILTER_DATA']['price_to'] ?? null)
            {
                if ($objRealEstateType->vermarktungsart === 'miete_leasing')
                {
                    $arrColumn[] = "$t.mietpreisProQm<=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
                }
                else
                {
                    $arrColumn[] = "$t.kaufpreisProQm<=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
                }
            }
        }
        else
        {
            if ($_SESSION['FILTER_DATA']['price_from'] ?? null)
            {
                $arrColumn[] = "$t.$objRealEstateType->price>=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
            }
            if ($_SESSION['FILTER_DATA']['price_to'] ?? null)
            {
                $arrColumn[] = "$t.$objRealEstateType->price<=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
            }
        }
    }

    /**
     * Add query fragment for room fields
     *
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentRoom(&$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['room_from'] ?? null)
        {
            $arrColumn[] = "$t.anzahlZimmer>=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_from'];
        }
        if ($_SESSION['FILTER_DATA']['room_to'] ?? null)
        {
            $arrColumn[] = "$t.anzahlZimmer<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_to'];
        }
    }

    /**
     * Add query fragment for area fields
     *
     * @param RealEstateTypeModel $objRealEstateType
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentArea($objRealEstateType, &$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['area_from'] ?? null)
        {
            $arrColumn[] = "$t.$objRealEstateType->area>=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_from'];
        }
        if ($_SESSION['FILTER_DATA']['area_to'] ?? null)
        {
            $arrColumn[] = "$t.$objRealEstateType->area<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_to'];
        }
    }

    /**
     * Add query fragment for period fields
     *
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentPeriod(&$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['period_from'] ?? null)
        {
            if (Validator::isDate($_SESSION['FILTER_DATA']['period_from']))
            {
                $arrColumn[] = "($t.abdatum<=? OR abdatum='')";

                $date = new \Date($_SESSION['FILTER_DATA']['period_from']);
                $arrValues[] = $date->tstamp;
            }
        }
        if ($_SESSION['FILTER_DATA']['period_to'] ?? null)
        {
            if (Validator::isDate($_SESSION['FILTER_DATA']['period_to']))
            {
                $arrColumn[] = "($t.bisdatum>=? OR $t.bisdatum='')";

                $date = new \Date($_SESSION['FILTER_DATA']['period_to']);
                $arrValues[] = $date->tstamp;
            }
        }
    }

    /**
     * Add provider query fragment
     *
     * @param array               $arrColumns
     * @param ModuleModel         $objModule
     */
    protected function addQueryFragmentProvider(&$arrColumns, $objModule=null)
    {
        if ($objModule === null)
        {
            return;
        }

        $t = static::$strTable;

        if ($objModule->filterByProvider)
        {
            $arrProvider = StringUtil::deserialize($objModule->provider, true);

            if (\count($arrProvider))
            {
                $arrColumns[] = "$t.provider IN (" . implode(',', $arrProvider) . ")";
            }
        }
    }

    /**
     * Add basic real estate type query fragment
     *
     * @param RealEstateTypeModel $objType
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentBasics($objType, &$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($objType->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumn[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        elseif ($objType->vermarktungsart === 'miete_leasing')
        {
            $arrColumn[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }

        if ($objType->nutzungsart)
        {
            $arrColumn[] = "$t.nutzungsart=?";
            $arrValues[] = $objType->nutzungsart;
        }

        if ($objType->objektart)
        {
            $arrColumn[] = "$t.objektart=?";
            $arrValues[] = $objType->objektart;
        }
    }

    /**
     * Get a real estate group model by its ID
     */
    public function getGroupById(int $id): ?RealEstateGroupModel
    {
        if ($this->objGroups === null)
        {
            return null;
        }

        foreach ($this->objGroups as $objGroup)
        {
            if ($objGroup->id === $id)
            {
                return $objGroup;
            }
        }

        return null;
    }

    /**
     * Get collection of real estate group models by their IDs
     */
    public function getGroupCollectionByIds(array $arrIds=array()): ?Collection
    {
        if (empty($arrIds) || $this->objGroups === null)
        {
            return null;
        }

        $arrModels = array();

        foreach ($this->objGroups as $objGroup)
        {
            if (in_array($objGroup->id, $arrIds))
            {
                $arrModels[] = $objGroup;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_group');
    }

    /**
     * Get a real estate type model by its ID
     */
    public function getTypeById(int $id): ?RealEstateTypeModel
    {
        if ($this->objTypes === null)
        {
            return null;
        }

        foreach ($this->objTypes as $objType)
        {
            if ($objType->id == $id)
            {
                return $objType;
            }
        }

        return null;
    }

    /**
     * Get collection of real estate type models by their IDs
     */
    public function getTypeCollectionByIds(array $arrIds=array()): ?Collection
    {
        if (empty($arrIds) || $this->objTypes === null)
        {
            return null;
        }

        $arrModels = array();

        foreach ($this->objTypes as $objType)
        {
            if (in_array($objType->id, $arrIds))
            {
                $arrModels[] = $objType;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_type');
    }

    /**
     * Get collection of real estate type models by their parent IDs
     */
    public function getTypeCollectionByPids(array $arrPids=array()): ?Collection
    {
        if (empty($arrPids) || $this->objTypes === null)
        {
            return null;
        }

        $arrModels = array();

        foreach ($this->objTypes as $objType)
        {
            if (in_array($objType->pid, $arrPids))
            {
                $arrModels[] = $objType;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_type');
    }

    public function getSelectedMarketingType()
    {
        $strMarketingType = 'kauf_erbpacht_miete_leasing';

        if ($this->objPage->setMarketingType)
        {
            $strMarketingType = $this->objPage->marketingType;
        }
        elseif ($_SESSION['FILTER_DATA']['marketing-type'] ?? null)
        {
            $strMarketingType = $_SESSION['FILTER_DATA']['marketing-type'];
        }

        return $strMarketingType;
    }

    /**
     * Return the selected real estate type model
     */
    public function getSelectedType(): ?RealEstateTypeModel
    {
        $objType = null;

        if ($this->objPage->setRealEstateType)
        {
            $objType = $this->getTypeById($this->objPage->realEstateType);
        }
        elseif ($_SESSION['FILTER_DATA']['real-estate-type'] ?? null)
        {
            $objType = $this->getTypeById($_SESSION['FILTER_DATA']['real-estate-type']);
        }

        if ($objType !== null && $objType->vermarktungsart !== $this->getSelectedMarketingType())
        {
            $objType = $this->getTypeById($objType->similarType);
        }

        return $objType;
    }

    /**
     * Return the order option as string
     */
    protected function getOrderOption(): string
    {
        $strOrder = $_SESSION['SORTING'] ?? null;

        if ($strOrder === null)
        {
            return (Config::get('defaultSorting') ?: 'tstamp') . ' DESC';
        }

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
}
