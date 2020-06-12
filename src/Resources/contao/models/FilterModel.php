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
 * Reads and writes filter
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 * @property string  $alias
 * @property integer $jumpTo
 * @property string  $groups
 * @property boolean $addBlankMarketingType
 * @property boolean $addBlankRealEstateType
 * @property boolean $submitOnChange
 * @property string  $toggleFilter
 * @property string  $roomOptions
 * @property string  $customTpl
 * @property string  $attributes
 * @property boolean $novalidate
 * @property string  $toggleMode
 *
 * @method static FilterModel|null findById($id, array $opt=array())
 * @method static FilterModel|null findByPk($id, array $opt=array())
 * @method static FilterModel|null findByIdOrAlias($val, array $opt=array())
 * @method static FilterModel|null findOneBy($col, $val, array $opt=array())
 * @method static FilterModel|null findOneByTstamp($val, array $opt=array())
 * @method static FilterModel|null findOneByTitle($val, array $opt=array())
 * @method static FilterModel|null findOneByAlias($val, array $opt=array())
 * @method static FilterModel|null findOneByJumpTo($val, array $opt=array())
 * @method static FilterModel|null findOneByGroups($val, array $opt=array())
 * @method static FilterModel|null findOneByAddBlankMarketingType($val, array $opt=array())
 * @method static FilterModel|null findOneByAddBlankRealEstateType($val, array $opt=array())
 * @method static FilterModel|null findOneBySubmitOnChange($val, array $opt=array())
 * @method static FilterModel|null findOneByToggleFilter($val, array $opt=array())
 * @method static FilterModel|null findOneByRoomOptions($val, array $opt=array())
 * @method static FilterModel|null findOneByCustomTpl($val, array $opt=array())
 * @method static FilterModel|null findOneByAttributes($val, array $opt=array())
 * @method static FilterModel|null findOneByNovalidate($val, array $opt=array())
 * @method static FilterModel|null findOneByToggleMode($val, array $opt=array())
 *
 * @method static Collection|FilterModel[]|FilterModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByTitle($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByAlias($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByJumpTo($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByGroups($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByAddBlankMarketingType($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByAddBlankRealEstateType($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findBySubmitOnChange($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByToggleFilter($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByRoomOptions($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByCustomTpl($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByAttributes($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByNovalidate($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findByToggleMode($val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|FilterModel[]|FilterModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countByAlias($val, array $opt=array())
 * @method static integer countByJumpTo($val, array $opt=array())
 * @method static integer countByGroups($val, array $opt=array())
 * @method static integer countByAddBlankMarketingType($val, array $opt=array())
 * @method static integer countByAddBlankRealEstateType($val, array $opt=array())
 * @method static integer countBySubmitOnChange($val, array $opt=array())
 * @method static integer countByToggleFilter($val, array $opt=array())
 * @method static integer countByRoomOptions($val, array $opt=array())
 * @method static integer countByCustomTpl($val, array $opt=array())
 * @method static integer countByAttributes($val, array $opt=array())
 * @method static integer countByNovalidate($val, array $opt=array())
 * @method static integer countByToggleMode($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class FilterModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_filter';
}
