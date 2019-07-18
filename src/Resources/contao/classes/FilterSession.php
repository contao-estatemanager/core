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

/**
 * Loads and writes filter information
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class FilterSession extends \System
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
     * Prevent direct instantiation (Singleton)
     */
    protected function __construct() {}

    /**
     * Prevent cloning of the object (Singleton)
     */
    final public function __clone() {}

    /**
     * Return the current object instance (Singleton)
     *
     * @return static The object instance
     */
    public static function getInstance()
    {
        if (static::$objInstance === null)
        {
            static::$objInstance = new static();
            static::$objInstance->initialize();
        }

        return static::$objInstance;
    }

    /**
     * Load all configuration files
     */
    protected function initialize()
    {
        /** @var \PageModel $objPage */
        global $objPage;

        $_SESSION['FILTER_DATA'] = \is_array($_SESSION['FILTER_DATA']) ? $_SESSION['FILTER_DATA'] : array();

        $this->objRealEstateGroups = RealEstateGroupModel::findByPublished(1);
        $this->objRealEstateTypes = RealEstateTypeModel::findByPublished(1);

        $submitted = $this->filterSubmitted();

        if (!$submitted && $objPage->setRealEstateType)
        {
            if (!$objPage->realEstateType && $objPage->setMarketingType)
            {
                $this->strMarketingType = $objPage->marketingType;
                $this->objCurrentType = null;
                return;
            }

            while ($this->objRealEstateTypes->next())
            {
                if ($objPage->realEstateType == $this->objRealEstateTypes->id)
                {
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
        elseif ($_SESSION['FILTER_DATA']['marketing-type'])
        {
            $this->strMarketingType = $_SESSION['FILTER_DATA']['marketing-type'];
        }
        else
        {
            $this->strMarketingType = 'kauf_erbpacht_miete_leasing';
        }

        // Break if no real estate type selected
        if (!$_SESSION['FILTER_DATA']['real-estate-type'])
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
        $submitted = !!$_SESSION['FILTER_DATA']['FILTER_SUBMITTED'];
        unset($_SESSION['FILTER_DATA']['FILTER_SUBMITTED']);

        return $submitted;
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
    public function getParameter($arrGroups, $mode, $addFragments=true)
    {
        if ($this->objCurrentType !== null)
        {
            return $this->getTypeParameter($this->objCurrentType, $mode, $addFragments);
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

        return $this->getTypeParameterByGroups($arrGroups, $mode, $addFragments);
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
    private function getTypeParameter($objRealEstateType, $mode, $addFragments=true)
    {
        $t = static::$strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        if ($objRealEstateType === null)
        {
            // Exception
        }

        if($addFragments)
        {
            $this->addQueryFragmentBasics($objRealEstateType, $arrColumns, $arrValues);
            $this->addQueryFragmentLocation($arrColumns, $arrValues);
            $this->addQueryFragmentPrice($objRealEstateType, $arrColumns, $arrValues);
            $this->addQueryFragmentRoom($arrColumns, $arrValues);
            $this->addQueryFragmentArea($objRealEstateType, $arrColumns, $arrValues);
            $this->addQueryFragmentPeriod($arrColumns, $arrValues);
        }

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getTypeParameter']) && \is_array($GLOBALS['TL_HOOKS']['getTypeParameter']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getTypeParameter'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $this);
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
    private function getTypeParameterByGroups($arrGroups, $mode, $addFragments=true)
    {
        $t = static::$strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        $arrTypeColumns = array();

        if($arrGroups !== null)
        {
            $objRealEstateTypes = RealEstateTypeModel::findPublishedByPids($arrGroups);

            if ($objRealEstateTypes === null)
            {
                // Exception
            }

            if($addFragments)
            {
                while ($objRealEstateTypes->next())
                {
                    $arrColumn = array();

                    $this->addQueryFragmentBasics($objRealEstateTypes->current(), $arrColumn, $arrValues);
                    $this->addQueryFragmentLocation($arrColumn, $arrValues);
                    $this->addQueryFragmentPrice($objRealEstateTypes->current(), $arrColumn, $arrValues);
                    $this->addQueryFragmentRoom($arrColumn, $arrValues);
                    $this->addQueryFragmentArea($objRealEstateTypes->current(), $arrColumn, $arrValues);
                    $this->addQueryFragmentPeriod($arrColumn, $arrValues);

                    // Hook zum ergänzen von neuen Toggle Filtern

                    $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
                }

                $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
            }
        }

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getTypeParameterByGroups']) && \is_array($GLOBALS['TL_HOOKS']['getTypeParameterByGroups']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getTypeParameterByGroups'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $this);
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
    public function getParameterByGroups($arrGroups, $mode, $addFragments=true)
    {
        $t = static::$strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        $arrTypeColumns = array();

        $objRealEstateTypes = RealEstateTypeModel::findPublishedByPids($arrGroups);

        if ($objRealEstateTypes === null)
        {
            // Exception
        }

        if($addFragments)
        {
            while ($objRealEstateTypes->next())
            {
                $arrColumn = array();

                $this->addQueryFragmentBasics($objRealEstateTypes->current(), $arrColumn, $arrValues);

                // Hook zum ergänzen von neuen Toggle Filtern

                $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
            }

            $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        }

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['TL_HOOKS']['getParameterByGroups']) && \is_array($GLOBALS['TL_HOOKS']['getParameterByGroups']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getParameterByGroups'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $mode, $addFragments, $this);
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
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
            if (\Validator::isDate($_SESSION['FILTER_DATA']['period_from']))
            {
                $arrColumn[] = "($t.abdatum<=? OR abdatum='')";

                $date = new \Date($_SESSION['FILTER_DATA']['period_from']);
                $arrValues[] = $date->tstamp;
            }
        }
        if ($_SESSION['FILTER_DATA']['period_to'])
        {
            if (\Validator::isDate($_SESSION['FILTER_DATA']['period_to']))
            {
                $arrColumn[] = "($t.bisdatum>=? OR $t.bisdatum='')";

                $date = new \Date($_SESSION['FILTER_DATA']['period_to']);
                $arrValues[] = $date->tstamp;
            }
        }
    }

    /**
     * Add query fragment for the unique field
     *
     * @param array               $arrColumn
     * @param array               $arrValues
     */
    protected function addQueryFragmentUnique(&$arrColumn, &$arrValues)
    {
        $t = static::$strTable;

        if ($_SESSION['FILTER_DATA']['unique'])
        {
            $arrColumn = array("$t.objektnrExtern=?");
            $arrValues = array($_SESSION['FILTER_DATA']['unique']);

            unset($_SESSION['FILTER_DATA']['unique']);
        }
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

                if ($objRealEstateType->referencePage && ($objJumpTo = \PageModel::findByPk($objRealEstateType->referencePage)) instanceof \PageModel)
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
                    if ($objRealEstateGroup->referencePage && ($objJumpTo = \PageModel::findByPk($objRealEstateGroup->referencePage)) instanceof \PageModel)
                    {
                        return $objJumpTo;
                    }
                    // Stop
                }

                if ($objRealEstateGroup->referencePage && ($objJumpTo = \PageModel::findByPk($objRealEstateGroup->referencePage)) instanceof \PageModel)
                {
                    return $objJumpTo;
                }
            }
        }

        return null;
    }
}
