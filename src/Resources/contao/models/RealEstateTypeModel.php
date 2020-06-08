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

use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes real estate types
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $sorting
 * @property integer $tstamp
 * @property string  $title
 * @property string  $longTitle
 * @property integer $similarType
 * @property integer $referencePage
 * @property integer $jumpTo
 * @property string  $nutzungsart
 * @property string  $vermarktungsart
 * @property string  $objektart
 * @property boolean $excludeTypes
 * @property string  $excludedTypes
 * @property string  $price
 * @property string  $area
 * @property string  $toggleFilter
 * @property string  $sortingOptions
 * @property string  $mainDetails
 * @property string  $mainAttributes
 * @property boolean $orderFields
 * @property string  $orderedFields
 * @property string  $language
 * @property boolean $defaultType
 * @property boolean $published
 *
 * @method static RealEstateTypeModel|null findById($id, array $opt=array())
 * @method static RealEstateTypeModel|null findByPk($id, array $opt=array())
 * @method static RealEstateTypeModel|null findOneBy($col, $val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByPid($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneBySorting($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByTstamp($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByTitle($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByLongTitle($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneBySimilarType($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByReferencePage($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByJumpTo($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByNutzungsart($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByVermarktungsart($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByObjektart($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByExcludeTypes($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByExcludedTypes($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByPrice($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByArea($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByToggleFilter($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneBySortingOptions($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByMainDetails($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByMainAttributes($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByOrderFields($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByOrderedFields($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByLanguage($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByDefaultType($val, array $opt=array())
 * @method static RealEstateTypeModel|null findOneByPublished($val, array $opt=array())
 *
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByPid($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findBySorting($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByTitle($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByLongTitle($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findBySimilarType($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByReferencePage($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByJumpTo($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByNutzungsart($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByVermarktungsart($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByObjektart($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByExcludeTypes($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByExcludedTypes($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByPrice($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByArea($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByToggleFilter($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findBySortingOptions($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByMainDetails($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByMainAttributes($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByOrderFields($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByOrderedFields($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByLanguage($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByDefaultType($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByPublished($val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countBySorting($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countByLongTitle($val, array $opt=array())
 * @method static integer countBySimilarType($val, array $opt=array())
 * @method static integer countByReferencePage($val, array $opt=array())
 * @method static integer countByJumpTo($val, array $opt=array())
 * @method static integer countByNutzungsart($val, array $opt=array())
 * @method static integer countByVermarktungsart($val, array $opt=array())
 * @method static integer countByObjektart($val, array $opt=array())
 * @method static integer countByExcludeTypes($val, array $opt=array())
 * @method static integer countByExcludedTypes($val, array $opt=array())
 * @method static integer countByPrice($val, array $opt=array())
 * @method static integer countByArea($val, array $opt=array())
 * @method static integer countByToggleFilter($val, array $opt=array())
 * @method static integer countBySortingOptions($val, array $opt=array())
 * @method static integer countByMainDetails($val, array $opt=array())
 * @method static integer countByMainAttributes($val, array $opt=array())
 * @method static integer countByOrderFields($val, array $opt=array())
 * @method static integer countByOrderedFields($val, array $opt=array())
 * @method static integer countByLanguage($val, array $opt=array())
 * @method static integer countByDefaultType($val, array $opt=array())
 * @method static integer countByPublished($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class RealEstateTypeModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_real_estate_type';

    /**
     * Find published real estate types by their parent ID
     *
     * @param integer $intPid          The filter ID
     * @param array   $arrOptions      An optional options array
     *
     * @return \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null A collection of models or null if there are no real estate types
     */
    public static function findPublishedByPid($intPid, $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid=? AND $t.published='1'");

        return static::findBy($arrColumns, $intPid, $arrOptions);
    }

    /**
     * Find published real estate types by their parent IDs
     *
     * @param array $arrPids         Array of filter IDs
     * @param array $arrOptions      An optional options array
     *
     * @return \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null A collection of models or null if there are no real estate types
     */
    public static function findPublishedByPids($arrPids, $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ") AND $t.published='1'");

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Find published real estate types by their parent IDs
     *
     * @param string $mode           Search mode
     * @param array $arrPids         Array of filter IDs
     * @param array $arrOptions      An optional options array
     *
     * @return \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null A collection of models or null if there are no real estate types
     */
    public static function findPublishedByModeAndPids($mode, $arrPids, $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ") AND $t.published='1'");

        switch ($mode)
        {
            case 'referenz':
                $arrColumns[] = "$t.referenz='1'";
                break;
            case 'neubau':
                $arrColumns[] = "$t.neubauProjekt='1'";
                break;
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Find the current used real estate type
     *
     * @return RealEstateTypeModel|null
     */
    public static function findCurrentRealEstateType()
    {
        if (isset($_SESSION['FILTER_DATA']['REAL_ESTATE_TYPE_FIELD']))
        {
            $typeId = $_SESSION['FILTER_DATA'][$_SESSION['FILTER_DATA']['REAL_ESTATE_TYPE_FIELD']];
        }
        else
        {
            $typeId = $_SESSION['FILTER_DATA']['type'];
        }

        if ($typeId)
        {
            $objType = static::findByPk($typeId);
        }
        else
        {
            $objType = static::findOneByDefaultType(1);
        }

        return $objType;
    }

    /**
     * Find the current used real estate type
     *
     * @param integer $pageId The current page id
     *
     * @return RealEstateTypeModel|null
     */
    public static function findCurrentType($pageId=null)
    {
        if ($pageId !== null && ($objType = static::findOneByReferencePage($pageId)) instanceof RealEstateTypeModel)
        {
            return $objType;
        }

        if (isset($_SESSION['FILTER_DATA']['type']))
        {
            $typeId = $_SESSION['FILTER_DATA']['type'];

            return static::findByPk($typeId);
        }

        return null;
    }
}
