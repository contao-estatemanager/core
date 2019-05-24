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
 * Reads and writes real estate types
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string  $longTitle
 * @property integer $referencePage
 * @property string  $jumpTo
 * @property string  $title
 * @property boolean $published
 *
 * @method static RealEstateTypeModel|null findById($id, array $opt=array())
 * @method static RealEstateTypeModel|null findByPk($id, array $opt=array())
 * @method static RealEstateTypeModel|null findOneBy($col, $val, $opt=array())
 * @method static RealEstateTypeModel|null findOneByTstamp($val, $opt=array())
 * @method static RealEstateTypeModel|null findOneByLongTitle($val, $opt=array())
 * @method static RealEstateTypeModel|null findOneByReferencePage($val, $opt=array())
 * @method static RealEstateTypeModel|null findOneByJumpTo($val, $opt=array())
 * @method static RealEstateTypeModel|null findOneByTitle($val, $opt=array())
 * @method static RealEstateTypeModel|null findOneByPublished($val, $opt=array())
 *
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByLongTitle($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByReferencePage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByJumpTo($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByTitle($val, array $opt=array())
 * @method static \Model\Collection|RealEstateTypeModel[]|RealEstateTypeModel|null findByPublished($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByLongTitle($id, array $opt=array())
 * @method static integer countByReferencePage($id, array $opt=array())
 * @method static integer countByJumpTo($id, array $opt=array())
 * @method static integer countByTitle($id, array $opt=array())
 * @method static integer countByPublished$id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class RealEstateTypeModel extends \Model
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

class_alias(RealEstateTypeModel::class, 'RealEstateTypeModel');