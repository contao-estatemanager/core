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
 * Reads and writes field formats
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $fieldname
 * @property string  $cssClass
 * @property boolean $forceOutput
 * @property boolean $useCondition
 * @property string  $conditionFields
 *
 * @method static FieldFormatModel|null findById($id, array $opt=array())
 * @method static FieldFormatModel|null findByPk($id, array $opt=array())
 * @method static FieldFormatModel|null findOneBy($col, $val, array $opt=array())
 * @method static FieldFormatModel|null findOneByTstamp($val, array $opt=array())
 * @method static FieldFormatModel|null findOneByFieldname($val, array $opt=array())
 * @method static FieldFormatModel|null findOneByCssClass($val, array $opt=array())
 * @method static FieldFormatModel|null findOneByForceOutput($val, array $opt=array())
 * @method static FieldFormatModel|null findOneByUseCondition($val, array $opt=array())
 * @method static FieldFormatModel|null findOneByConditionFields($val, array $opt=array())
 *
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findByFieldname($val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findByCssClass($val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findByForceOutput($val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findByUseCondition($val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findByConditionFields($val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|FieldFormatModel[]|FieldFormatModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByFieldname($val, array $opt=array())
 * @method static integer countByCssClass($val, array $opt=array())
 * @method static integer countByForceOutput($val, array $opt=array())
 * @method static integer countByUseCondition($val, array $opt=array())
 * @method static integer countByConditionFields($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class FieldFormatModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_field_format';

    /**
     * Find used field formats
     *
     * @return \Model\Collection|FieldFormatModel[]|FieldFormatModel|null A collection of models or null if there are no field formats
     */
    public static function getUsedFieldFormatsFields()
    {
        $t = static::$strTable;

        $objResult = \Database::getInstance()->execute("SELECT id, fieldname FROM $t");
        $fields = array();

        while($objResult->next())
        {
            $fields[] = $objResult->fieldname;
        }

        return $fields;
    }
}
