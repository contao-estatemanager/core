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
 * Reads and writes field formats
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string $fieldname
 * @property string $cssClass
 * @property string $useCondition
 * @property string $conditionFields
 *
 * @method static FieldFormatModel|null findById($id, array $opt=array())
 * @method static FieldFormatModel|null findOneBy($col, $val, $opt=array())
 * @method static FieldFormatModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static FieldFormatModel|null findOneByFieldname($col, $val, $opt=array())
 * @method static FieldFormatModel|null findOneByCssClass($col, $val, $opt=array())
 * @method static FieldFormatModel|null findOneByUseCondition($col, $val, $opt=array())
 * @method static FieldFormatModel|null findOneByConditionFields($col, $val, $opt=array())
 *
 * @method static \Model\Collection|FieldFormatModel[]|FieldFormatModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatModel[]|FieldFormatModel|null findByFieldname($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatModel[]|FieldFormatModel|null findByCssClass($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatModel[]|FieldFormatModel|null findByUseCondition($val, array $opt=array())
 * @method static \Model\Collection|FieldFormatModel[]|FieldFormatModel|null findByConditionFields($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByFieldname($id, array $opt=array())
 * @method static integer countByCssClass($id, array $opt=array())
 * @method static integer countByUseCondition($id, array $opt=array())
 * @method static integer countByConditionFields($id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class FieldFormatModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_field_format';
}
