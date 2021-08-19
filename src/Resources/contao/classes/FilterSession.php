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

use Contao\Input;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\Validator;

/**
 * Loads and writes filter information
 *
 * @author Fabian Ekert <https://github.com/eki89>
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class FilterSession extends \Frontend
{

    /**
     * Real estate group collection
     * @var \Model\Collection
     */
    protected $objRealEstateGroups;

    /**
     * Real estate type collection
     * @var \Model\Collection
     */
    protected $objRealEstateTypes;

    /**
     * Selected marketing type
     * @var string
     */
    protected $strMarketingType;

    /**
     * Selected real estate type
     * @var RealEstateTypeModel
     */
    protected $objCurrentType;

    /**
     * Object instance (Singleton)
     * @var FilterSession
     */
    protected static $objInstance;

    /**
     * Table
     * @var string
     */
    protected static $strTable = 'tl_real_estate';

    /**
     * @var \PageModel
     */
    protected static $objPage;

    /**
     * @var \PageModel
     */
    protected static $objPageDetails;

    /**
     * @var \PageModel
     */
    protected static $objRootPage;

    /**
     * Prevent cloning of the object (Singleton)
     */
    final public function __clone() {}

    /**
     * Return the current object instance (Singleton)
     *
     * @param $pageId
     *
     * @return static The object instance
     */
    public static function getInstance($pageId=null)
    {
        if (static::$objInstance === null)
        {
            static::$objInstance = new static();
            static::$objInstance->initialize($pageId);
        }

        return static::$objInstance;
    }

    /**
     * Load all configuration files
     *
     * @param $pageId
     */
    protected function initialize($pageId)
    {
        /** @var PageModel $objPage */
        global $objPage;

        if ($objPage === null)
        {
            $objPage = PageModel::findByPk($pageId);
        }

        static::$objPage = $objPage;
        static::$objPageDetails = $objPage !== null ? $objPage->loadDetails() : null;
        static::$objRootPage = static::$objPageDetails !== null ? PageModel::findByPk(static::$objPageDetails->rootId) : null;

        $this->redirectByGetParameter();

        $_SESSION['FILTER_DATA'] = $_SESSION['FILTER_DATA'] ?? [];

        if ((!isset($_SESSION['FILTER_DATA']['country']) || !count($_SESSION['FILTER_DATA'])) && static::$objRootPage)
        {
            $_SESSION['FILTER_DATA']['country'] = static::$objRootPage->realEstateQueryCountry;
        }

        $this->objRealEstateGroups = RealEstateGroupModel::findByPublished(1);
        $this->objRealEstateTypes = RealEstateTypeModel::findByPublished(1);

        $submitted = $this->filterSubmitted();

        if (!$submitted && $objPage->setRealEstateType)
        {
            if (!$objPage->realEstateType && $objPage->setMarketingType)
            {
                $_SESSION['FILTER_DATA']['marketing-type'] = $objPage->marketingType;
                $this->strMarketingType = $objPage->marketingType;
                $this->objCurrentType = null;
                return;
            }

            while ($this->objRealEstateTypes->next())
            {
                if ($objPage->realEstateType == $this->objRealEstateTypes->id)
                {
                    $_SESSION['FILTER_DATA']['marketing-type'] = $objPage->marketingType;
                    $this->strMarketingType = $this->objRealEstateTypes->vermarktungsart;
                    $this->objCurrentType = $this->objRealEstateTypes->current();

                    // Reset collection for further functions
                    $this->objRealEstateTypes->reset();
                    return;
                }
            }
        }

        // Determine current marketing type
        if ($objPage->setMarketingType)
        {
            $this->strMarketingType = $objPage->marketingType;
        }
        elseif (isset($_SESSION['FILTER_DATA']['marketing-type']))
        {
            $this->strMarketingType = $_SESSION['FILTER_DATA']['marketing-type'];
        }
        else
        {
            $this->strMarketingType = 'kauf_erbpacht_miete_leasing';
        }

        if (!$submitted)
        {
            while ($this->objRealEstateTypes->next())
            {
                if ($this->objRealEstateTypes->referencePage === $objPage->id)
                {
                    if ($this->strMarketingType === 'kauf_erbpacht_miete_leasing' || $this->strMarketingType === $this->objRealEstateTypes->vermarktungsart)
                    {
                        $this->objCurrentType = $this->objRealEstateTypes->current();
                        $this->strMarketingType = $this->objRealEstateTypes->vermarktungsart;
                        return;
                    }
                }
            }

            $this->objRealEstateTypes->reset();
        }

        // Break if no real estate type selected
        if (!($_SESSION['FILTER_DATA']['real-estate-type'] ?? null))
        {
            $this->objCurrentType = null;
            return;
        }

        // Determine current real estate type
        while ($this->objRealEstateTypes->next())
        {
            if ($_SESSION['FILTER_DATA']['real-estate-type'])
            {
                if ($_SESSION['FILTER_DATA']['real-estate-type'] == $this->objRealEstateTypes->id)
                {
                    if ($this->strMarketingType === $this->objRealEstateTypes->vermarktungsart || $this->strMarketingType === 'kauf_erbpacht_miete_leasing')
                    {
                        $this->objCurrentType = $this->objRealEstateTypes->current();
                        $this->strMarketingType = $this->objRealEstateTypes->vermarktungsart;
                        break;
                    }
                    else
                    {
                        $this->objCurrentType = $this->objRealEstateTypes->getRelated('similarType');
                        break;
                    }
                }
            }
            elseif ($this->objRealEstateTypes->defaultType)
            {
                $this->objCurrentType = $this->objRealEstateTypes->current();
                break;
            }
        }

        // Reset collection for further functions
        $this->objRealEstateTypes->reset();
    }

    /**
     * Return true if filter submitted during this request and unset session indicator
     *
     * @return boolean
     */
    protected function filterSubmitted()
    {
        if($submitted = $_SESSION['FILTER_DATA']['FILTER_SUBMITTED'] ?? null)
        {
            unset($_SESSION['FILTER_DATA']['FILTER_SUBMITTED']);
        }

        return !!$submitted;
    }

    /**
     * Collect all filter parameter by group and return it as array
     *
     * @param array $arrGroups Array of real estate group ids
     * @param string $mode filter mode
     * @param bool $addFragments
     *
     * @return array
     */
    public function getParameter($arrGroups, $mode, $addFragments=true, $objModule=null)
    {
        if ($this->objCurrentType !== null)
        {
            return $this->getTypeParameter($this->objCurrentType, $mode, $addFragments, $objModule);
        }

        if ($arrGroups !== null && $this->strMarketingType !== 'kauf_erbpacht_miete_leasing')
        {
            // Unset real estate groups if marketing type not apply
            while ($this->objRealEstateGroups->next())
            {
                if (($index = array_search($this->objRealEstateGroups->id, $arrGroups)) !== false)
                {
                    if ($this->objRealEstateGroups->vermarktungsart !== $this->strMarketingType)
                    {
                        unset($arrGroups[$index]);
                    }
                }
            }
        }

        // Reset collection for further functions
        $this->objRealEstateGroups->reset();

        return $this->getTypeParameterByGroups($arrGroups, $mode, $addFragments, $objModule);
    }

    /**
     * Collect type filter parameter and return them as array
     *
     * @param RealEstateTypeModel $objRealEstateType
     * @param string $mode
     * @param bool $addFragments
     *
     * @return array
     */
    private function getTypeParameter($objRealEstateType, $mode, $addFragments=true, $objModule=null)
    {
        $t = static::$strTable;

        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        if ($objModule !== null && $objModule->type === 'realEstateResultList')
        {
            $this->addQueryFragmentUniqueImprecise($arrColumns, $arrValues, $addFragments);
        }

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $arrValues, $objModule);

        if ($objRealEstateType === null)
        {
            // Exception
        }

        if($addFragments)
        {
            $this->addQueryFragmentBasics($objRealEstateType, $arrColumns, $arrValues);
            $this->addQueryFragmentCountry($arrColumns, $arrValues);
            $this->addQueryFragmentLocation($arrColumns, $arrValues);
            $this->addQueryFragmentPrice($objRealEstateType, $arrColumns, $arrValues);
            $this->addQueryFragmentRoom($arrColumns, $arrValues);
            $this->addQueryFragmentArea($objRealEstateType, $arrColumns, $arrValues);
            $this->addQueryFragmentPeriod($arrColumns, $arrValues);

            $arrOptions['order']  = $this->getOrderOption();
        }

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getTypeParameter']) && \is_array($GLOBALS['TL_HOOKS']['getTypeParameter']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getTypeParameter'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $objModule, $this);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect type filter parameter and return them as array
     *
     * @param array $arrGroups
     * @param string $mode
     *
     * @param bool $addFragments
     * @return array
     */
    public function getTypeParameterByGroups($arrGroups, $mode, $addFragments=true, $objModule=null)
    {
        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        if ($objModule !== null && $objModule->type === 'realEstateResultList')
        {
            $this->addQueryFragmentUniqueImprecise($arrColumns, $arrValues, $addFragments);
        }

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $arrValues, $objModule);

        $arrTypeColumns = array();

        if($arrGroups !== null)
        {
            $objRealEstateTypes = RealEstateTypeModel::findPublishedByPids($arrGroups);

            if ($objRealEstateTypes === null)
            {
                // ToDo: Exception
            }

            if($addFragments)
            {
                while ($objRealEstateTypes->next())
                {
                    $arrColumn = array();

                    $this->addQueryFragmentBasics($objRealEstateTypes->current(), $arrColumn, $arrValues);
                    $this->addQueryFragmentCountry($arrColumn, $arrValues);
                    $this->addQueryFragmentLocation($arrColumn, $arrValues);
                    $this->addQueryFragmentPrice($objRealEstateTypes->current(), $arrColumn, $arrValues);
                    $this->addQueryFragmentRoom($arrColumn, $arrValues);
                    $this->addQueryFragmentArea($objRealEstateTypes->current(), $arrColumn, $arrValues);
                    $this->addQueryFragmentPeriod($arrColumn, $arrValues);

                    // ToDo: Hook zum ergänzen von neuen Toggle Filtern

                    $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
                }

                $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';

                $arrOptions['order']  = $this->getOrderOption();
            }
        }

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getTypeParameterByGroups']) && \is_array($GLOBALS['TL_HOOKS']['getTypeParameterByGroups']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getTypeParameterByGroups'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $objModule, $this);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect and return parameter by a given set of groups
     *
     * @param array $arrGroups
     * @param string $mode
     * @param bool $addFragments
     *
     * @return array
     */
    public function getParameterByGroups($arrGroups, $mode, $addFragments=true, $objModule=null)
    {
        $t = static::$strTable;

        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        $arrTypeColumns = array();

        $objRealEstateTypes = RealEstateTypeModel::findPublishedByPids($arrGroups);

        if($objRealEstateTypes === null)
        {
            // ToDo: Exception
        }

        if($addFragments)
        {
            while ($objRealEstateTypes->next())
            {
                $arrColumn = array();

                $this->addQueryFragmentBasics($objRealEstateTypes->current(), $arrColumn, $arrValues);

                // ToDo: Hook zum ergänzen von neuen Toggle Filtern

                $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
            }

            $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        }

        $arrOptions['order']  = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getParameterByGroups']) && \is_array($GLOBALS['TL_HOOKS']['getParameterByGroups']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getParameterByGroups'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $objModule, $this);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect and return parameter by a given set of types
     *
     * @param array $arrTypes
     * @param string $mode
     * @param bool $addFragments
     *
     * @return array
     */
    public function getParameterByTypes($arrTypes, $mode, $addFragments=true, $objModule=null)
    {
        $arrColumns = array();
        $arrValues = array();
        $arrOptions = array();

        $arrTypeColumns = array();
        $objRealEstateTypes = RealEstateTypeModel::findPublishedByIds($arrTypes);

        if($objRealEstateTypes === null)
        {
            // ToDo: Exception
        }

        if($addFragments)
        {
            while ($objRealEstateTypes->next())
            {
                $arrColumn = array();

                $this->addQueryFragmentBasics($objRealEstateTypes->current(), $arrColumn, $arrValues);

                // ToDo: Hook zum ergänzen von neuen Toggle Filtern

                $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
            }

            $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        }

        $arrOptions['order'] = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getParameterByTypes']) && \is_array($GLOBALS['TL_HOOKS']['getParameterByTypes']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getParameterByTypes'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $objModule, $this);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Add real estate language query fragment
     *
     * @param array               $arrColumns
     * @param array               $arrValues
     */
    protected function addQueryFragmentLanguage(&$arrColumns, &$arrValues)
    {
        $t = static::$strTable;

        if (static::$objPage === null)
        {
            $arrColumns[] = "$t.sprache='de-DE'";
            return;
        }

        $pageDetails = static::$objPage->loadDetails();
        $objRootPage = PageModel::findByPk($pageDetails->rootId);

        if ($objRootPage->realEstateQueryLanguage)
        {
            $arrColumns[] = "$t.sprache=?";
            $arrValues[]  = $objRootPage->realEstateQueryLanguage;
        }
    }

    /**
     * Add provider query fragment
     *
     * @param array               $arrColumns
     * @param array               $arrValues
     * @param ModuleModel         $objModule
     */
    protected function addQueryFragmentProvider(&$arrColumns, &$arrValues, $objModule=null)
    {
        if ($objModule === null)
        {
            return;
        }

        $t = static::$strTable;

        if ($objModule->filterByProvider)
        {
            $arrProvider = StringUtil::deserialize($objModule->provider, true);

            if (count($arrProvider))
            {
                $arrColumns[] = "$t.provider IN (" . implode(',', $arrProvider) . ")";
            }
        }
    }

    /**
     * Add basic real estate type query fragment information
     *
     * @param RealEstateTypeModel $objRealEstateType
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentBasics($objRealEstateType, &$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($objRealEstateType->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumn[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        elseif ($objRealEstateType->vermarktungsart === 'miete_leasing')
        {
            $arrColumn[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }

        if ($objRealEstateType->nutzungsart)
        {
            $arrColumn[] = "$t.nutzungsart=?";
            $arrValues[] = $objRealEstateType->nutzungsart;
        }

        if ($objRealEstateType->objektart)
        {
            $arrColumn[] = "$t.objektart=?";
            $arrValues[] = $objRealEstateType->objektart;
        }
    }

    /**
     * Add query fragment for the country field
     *
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentCountry(&$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['country'])
        {
            $arrColumn[] = "$t.land=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['country'];
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

        if ($_SESSION['FILTER_DATA']['location'])
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
                $arrColumn[] = "$t.ort LIKE ? OR $t.regionalerZusatz LIKE ?";
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

        if ($_SESSION['FILTER_DATA']['price_per'] === 'square_meter')
        {
            if ($_SESSION['FILTER_DATA']['price_from'])
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
            if ($_SESSION['FILTER_DATA']['price_to'])
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
            if ($_SESSION['FILTER_DATA']['price_from'])
            {
                $arrColumn[] = "$t.$objRealEstateType->price>=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
            }
            if ($_SESSION['FILTER_DATA']['price_to'])
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

        if ($_SESSION['FILTER_DATA']['room_from'])
        {
            $arrColumn[] = "$t.anzahlZimmer>=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_from'];
        }
        if ($_SESSION['FILTER_DATA']['room_to'])
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

        if ($_SESSION['FILTER_DATA']['area_from'])
        {
            $arrColumn[] = "$t.$objRealEstateType->area>=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_from'];
        }
        if ($_SESSION['FILTER_DATA']['area_to'])
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

        if ($_SESSION['FILTER_DATA']['period_from'])
        {
            if (Validator::isDate($_SESSION['FILTER_DATA']['period_from']))
            {
                $arrColumn[] = "($t.abdatum<=? OR abdatum='')";

                $date = new \Date($_SESSION['FILTER_DATA']['period_from']);
                $arrValues[] = $date->tstamp;
            }
        }
        if ($_SESSION['FILTER_DATA']['period_to'])
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
     * Add query fragment for imprecise unique filter
     *
     * @param array               $arrColumn
     * @param array               $arrValues
     * @param boolean             $addFragments
     */
    protected function addQueryFragmentUniqueImprecise(&$arrColumn, &$arrValues, &$addFragments)
    {
        if ($_SESSION['FILTER_DATA']['unique-imprecise'])
        {
            $uniqueImprecise = $_SESSION['FILTER_DATA']['unique-imprecise'];
            $_SESSION['FILTER_DATA'] = array();
            $_SESSION['FILTER_DATA']['unique-imprecise'] = $uniqueImprecise;

            $t = static::$strTable;

            $arrColumn[] = "$t.objektnrExtern LIKE ?";
            $arrValues[] = '%'.$uniqueImprecise.'%';

            $addFragments = false;
        }
    }

    /**
     * Return the order option as string
     *
     * @return string
     */
    protected function getOrderOption()
    {
        $strOrder = $_SESSION['SORTING'] ?? null;

        if ($strOrder === null)
        {
            return (\Config::get('defaultSorting') ?: 'tstamp') . ' DESC';
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

    /**
     * Get current marketing type
     *
     * @return string
     */
    public function getCurrentMarketingType()
    {
        return $this->strMarketingType;
    }

    /**
     * Get current real estate type
     *
     * @return RealEstateTypeModel|null
     */
    public function getCurrentRealEstateType()
    {
        return $this->objCurrentType;
    }

    /**
     * Determine current reference page
     *
     * @return \PageModel|null
     */
    public function getReferencePage()
    {
        if ($_SESSION['FILTER_DATA']['real-estate-type'])
        {
            if (is_numeric($_SESSION['FILTER_DATA']['real-estate-type']))
            {
                $objRealEstateType = RealEstateTypeModel::findByPk($_SESSION['FILTER_DATA']['real-estate-type']);

                if ($objRealEstateType->referencePage && ($objJumpTo = PageModel::findByPk($objRealEstateType->referencePage)) instanceof PageModel)
                {
                    return $objJumpTo;
                }
            }
            else
            {
                $_SESSION['FILTER_DATA']['marketing-type'] = $_SESSION['FILTER_DATA']['real-estate-type'];
                $_SESSION['FILTER_DATA']['real-estate-type'] = '';
            }
        }

        if ($_SESSION['FILTER_DATA']['marketing-type'])
        {
            $objRealEstateGroup = RealEstateGroupModel::findByVermarktungsart($_SESSION['FILTER_DATA']['marketing-type']);

            if ($objRealEstateGroup !== null)
            {
                if ($objRealEstateGroup->count() > 1)
                {
                    // Start: Hier muss die richtige Referenzseite anhand der gefundenen Gruppen gefunden werden.
                    if ($objRealEstateGroup->referencePage && ($objJumpTo = PageModel::findByPk($objRealEstateGroup->referencePage)) instanceof PageModel)
                    {
                        return $objJumpTo;
                    }
                    // Stop
                }

                if ($objRealEstateGroup->referencePage && ($objJumpTo = PageModel::findByPk($objRealEstateGroup->referencePage)) instanceof PageModel)
                {
                    return $objJumpTo;
                }
            }
        }

        return null;
    }

    protected function redirectByGetParameter()
    {
        if (Input::get('redirect'))
        {
            $validParameter = array('country', 'location', 'location-google', 'country-short', 'city', 'postal', 'district', 'latitude', 'longitude', 'radius-google', 'marketing-type', 'real-estate-type', 'price_to', 'price_from', 'area_to', 'area_from', 'room_to', 'room_from', 'unique');

            $_SESSION['FILTER_DATA'] = array();

            $arrParam = $_GET;

            if (array_key_exists('marketing-type', $arrParam))
            {
                if ($arrParam['marketing-type'] === 'kauf')
                {
                    $arrParam['marketing-type'] = 'kauf_erbpacht';
                }
                else if ($arrParam['marketing-type'] === 'miete')
                {
                    $arrParam['marketing-type'] = 'miete_leasing';
                }
            }

            foreach ($arrParam as $param => $value)
            {
                if (in_array($param, $validParameter))
                {
                    $_SESSION['FILTER_DATA'][$param] = $value;
                }
                else
                {
                    unset($arrParam[$param]);
                }
            }

            $objJumpTo = $this->getReferencePage();

            // Redirect if there is a reference page
            if ($objJumpTo instanceof PageModel)
            {
                $this->jumpToOrReload($objJumpTo->row());
            }
            else
            {
                //$this->jumpToOrReload(static::$objPage->row());
                self::redirect(static::$objPage->getFrontendUrl());
            }
        }
    }

    public function getRootLanguage()
    {
        if (static::$objRootPage === null)
        {
            return '';
        }

        return static::$objRootPage->realEstateQueryCountry;
    }
}
