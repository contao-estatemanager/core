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
 * Reads and writes field format actions
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string $action
 * @property string $decimals
 * @property string $text
 * @property string $seperator
 * @property string $necessary
 * @property string $elements
 * @property string $customFunction
 * @property integer $sorting
 *
 * @method static FieldFormatActionModel|null findById($id, array $opt=array())
 * @method static FieldFormatActionModel|null findByPk($id, array $opt=array())
 * @method static FieldFormatActionModel|null findOneBy($col, $val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByPid($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByTstamp($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByAction($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByDecimals($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByText($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneBySeperator($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByNecessary($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByElements($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneByCustomFunction($val, $opt=array())
 * @method static FieldFormatActionModel|null findOneBySorting($val, $opt=array())
 *
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByAction($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByDecimals($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByText($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findBySeperator($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByNecessary($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByElements($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findByCustomFunction($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatActionModel[]|FieldFormatActionModel|null findBySorting($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($val, $opt=array())
 * @method static integer countByAction($val, $opt=array())
 * @method static integer countByDecimals($val, $opt=array())
 * @method static integer countByText($val, $opt=array())
 * @method static integer countBySeperator($val, $opt=array())
 * @method static integer countByNecessary($val, $opt=array())
 * @method static integer countByElements($val, $opt=array())
 * @method static integer countByCustomFunction($val, $opt=array())
 * @method static integer countBySorting($val, $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class FieldFormatActionModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_field_format_action';
}
