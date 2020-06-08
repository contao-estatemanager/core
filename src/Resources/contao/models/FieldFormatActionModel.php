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
 * Reads and writes field format actions
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string  $action
 * @property string  $decimals
 * @property string  $text
 * @property string  $seperator
 * @property boolean $necessary
 * @property string  $elements
 * @property string  $customFunction
 * @property integer $sorting
 *
 * @method static FieldFormatActionModel|null findById($id, array $opt=array())
 * @method static FieldFormatActionModel|null findByPk($id, array $opt=array())
 * @method static FieldFormatActionModel|null findOneBy($col, $val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByPid($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByTstamp($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByAction($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByDecimals($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByText($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneBySeperator($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByNecessary($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByElements($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneByCustomFunction($val, array $opt=array())
 * @method static FieldFormatActionModel|null findOneBySorting($val, array $opt=array())
 *
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByPid($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByAction($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByDecimals($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByText($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findBySeperator($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByNecessary($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByElements($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByCustomFunction($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findBySorting($val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByAction($val, array $opt=array())
 * @method static integer countByDecimals($val, array $opt=array())
 * @method static integer countByText($val, array $opt=array())
 * @method static integer countBySeperator($val, array $opt=array())
 * @method static integer countByNecessary($val, array $opt=array())
 * @method static integer countByElements($val, array $opt=array())
 * @method static integer countByCustomFunction($val, array $opt=array())
 * @method static integer countBySorting($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class FieldFormatActionModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_field_format_action';
}
