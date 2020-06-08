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
 * Reads and writes filter items
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $sorting
 * @property integer $tstamp
 * @property string  $type
 * @property string  $label
 * @property string  $name
 * @property boolean $mandatory
 * @property string  $countrySource
 * @property string  $countryOptions
 * @property string  $placeholder
 * @property boolean $showLongTitle
 * @property boolean $impreciseMode
 * @property boolean $mergeOptions
 * @property boolean $rangeMode
 * @property boolean $showLabel
 * @property boolean $showPlaceholder
 * @property string  $class
 * @property boolean $accesskey
 * @property string  $tabindex
 * @property string  $customTpl
 * @property string  $slabel
 * @property boolean $imageSubmit
 * @property string  $singleSRC
 * @property boolean $invisible
 *
 * @method static FilterItemModel|null findById($id, array $opt=array())
 * @method static FilterItemModel|null findByPk($id, array $opt=array())
 * @method static FilterItemModel|null findOneBy($col, $val, array $opt=array())
 * @method static FilterItemModel|null findOneByPid($val, array $opt=array())
 * @method static FilterItemModel|null findOneBySorting($val, array $opt=array())
 * @method static FilterItemModel|null findOneByTstamp($val, array $opt=array())
 * @method static FilterItemModel|null findOneByType($val, array $opt=array())
 * @method static FilterItemModel|null findOneByLabel($val, array $opt=array())
 * @method static FilterItemModel|null findOneByName($val, array $opt=array())
 * @method static FilterItemModel|null findOneByMandatory($val, array $opt=array())
 * @method static FilterItemModel|null findOneByCountrySource($val, array $opt=array())
 * @method static FilterItemModel|null findOneByCountryOptions($val, array $opt=array())
 * @method static FilterItemModel|null findOneByPlaceholder($val, array $opt=array())
 * @method static FilterItemModel|null findOneByShowLongTitle($val, array $opt=array())
 * @method static FilterItemModel|null findOneByImpreciseMode($val, array $opt=array())
 * @method static FilterItemModel|null findOneByMergeOptions($val, array $opt=array())
 * @method static FilterItemModel|null findOneByRangeMode($val, array $opt=array())
 * @method static FilterItemModel|null findOneByShowLabel($val, array $opt=array())
 * @method static FilterItemModel|null findOneByShowPlaceholder($val, array $opt=array())
 * @method static FilterItemModel|null findOneByClass($val, array $opt=array())
 * @method static FilterItemModel|null findOneByAccesskey($val, array $opt=array())
 * @method static FilterItemModel|null findOneByTabindex($val, array $opt=array())
 * @method static FilterItemModel|null findOneByCustomTpl($val, array $opt=array())
 * @method static FilterItemModel|null findOneBySlabel($val, array $opt=array())
 * @method static FilterItemModel|null findOneByImageSubmit($val, array $opt=array())
 * @method static FilterItemModel|null findOneBySingleSRC($val, array $opt=array())
 * @method static FilterItemModel|null findOneByInvisible($val, array $opt=array())
 *
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByPid($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findBySorting($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByType($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByLabel($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByName($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByMandatory($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByCountrySource($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByCountryOptions($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByPlaceholder($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByShowLongTitle($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByImpreciseMode($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByMergeOptions($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByRangeMode($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByShowLabel($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByShowPlaceholder($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByClass($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByAccesskey($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByTabindex($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByCustomTpl($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findBySlabel($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByImageSubmit($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findBySingleSRC($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findByInvisible($val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|FilterItemModel[]|FilterItemModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countBySorting($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByType($val, array $opt=array())
 * @method static integer countByLabel($val, array $opt=array())
 * @method static integer countByName($val, array $opt=array())
 * @method static integer countByMandatory($val, array $opt=array())
 * @method static integer countByCountrySource($val, array $opt=array())
 * @method static integer countByCountryOptions($val, array $opt=array())
 * @method static integer countByPlaceholder($val, array $opt=array())
 * @method static integer countByShowLongTitle($val, array $opt=array())
 * @method static integer countByImpreciseMode($val, array $opt=array())
 * @method static integer countByMergeOptions($val, array $opt=array())
 * @method static integer countByRangeMode($val, array $opt=array())
 * @method static integer countByShowLabel($val, array $opt=array())
 * @method static integer countByShowPlaceholder($val, array $opt=array())
 * @method static integer countByClass($val, array $opt=array())
 * @method static integer countByAccesskey($val, array $opt=array())
 * @method static integer countByTabindex($val, array $opt=array())
 * @method static integer countByCustomTpl($val, array $opt=array())
 * @method static integer countBySlabel($val, array $opt=array())
 * @method static integer countByImageSubmit($val, array $opt=array())
 * @method static integer countBySingleSRC($val, array $opt=array())
 * @method static integer countByInvisible($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class FilterItemModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_filter_item';

    /**
     * Find published filter items by ID
     *
     * @param integer $intId       The filter ID
     * @param array   $arrOptions  An optional options array
     *
     * @return FilterItemModel|null  A model or null if filter item is not published
     */
    public static function findPublishedById($intId, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.id=?");

        if (!static::isPreviewMode($arrOptions))
        {
            $arrColumns[] = "$t.invisible=''";
        }

        return static::findOneBy($arrColumns, $intId, $arrOptions);
    }

    /**
     * Find published filter items by their parent ID
     *
     * @param integer $intPid     The filter ID
     * @param array   $arrOptions An optional options array
     *
     * @return \Model\Collection|FilterItemModel[]|FilterItemModel|null A collection of models or null if there are no filter items
     */
    public static function findPublishedByPid($intPid, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid=?");

        if (!static::isPreviewMode($arrOptions))
        {
            $arrColumns[] = "$t.invisible=''";
        }

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = "$t.sorting";
        }

        return static::findBy($arrColumns, $intPid, $arrOptions);
    }

    /**
     * Find published filter items by type and their parent ID
     *
     * @param string  $strType    The filter type
     * @param integer $intPid     The filter ID
     * @param array   $arrOptions An optional options array
     *
     * @return \Model\Collection|FilterItemModel[]|FilterItemModel|null A collection of models or null if there are no filter items
     */
    public static function findPublishedByTypeAndPid($strType, $intPid, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.type=? AND $t.pid=?");
        $arrValues = array($strType, $intPid);

        if (!static::isPreviewMode($arrOptions))
        {
            $arrColumns[] = "$t.invisible=''";
        }

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = "$t.sorting";
        }

        return static::findBy($arrColumns, $arrValues, $arrOptions);
    }
}
