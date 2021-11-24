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
use Contao\PageModel;

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

        $this->objPage = $objPage->loadDetails();
        $this->objRootPage = PageModel::findByPk($this->objPage->rootId);

        $this->objGroups = RealEstateGroupModel::findAllPublished();
        $this->objTypes = RealEstateTypeModel::findAllPublished();
    }

    /**
     * Prevent cloning of the object (Singleton)
     */
    final public function __clone()
    {
    }

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

        return $this->getParameterByGroups($arrGroups, $objModule);
    }

    protected function getTypeParameter($objType, $objModule): array
    {
        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentCountry($arrColumns, $arrValues);
        $this->addQueryFragmentBasics($objType, $arrColumns, $arrValues);

        $arrOptions['order'] = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['CEM_HOOKS']['getTypeParameter']) && \is_array($GLOBALS['CEM_HOOKS']['getTypeParameter']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getTypeParameter'] as $callback)
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
    public function getParameterByGroups(array $arrGroups, $objModule): array
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
        $this->addQueryFragmentCountry($arrColumns, $arrValues);

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
        $this->addQueryFragmentCountry($arrColumns, $arrValues);

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