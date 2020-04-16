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
 * Reads and writes interface mappings
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string  $attribute
 * @property string  $oiField
 * @property string  $oiFieldGroup
 * @property string  $oiConditionField
 * @property string  $oiConditionValue
 *
 * @method static InterfaceMappingModel|null findById($id, array $opt=array())
 * @method static InterfaceMappingModel|null findByPk($id, array $opt=array())
 * @method static InterfaceMappingModel|null findOneBy($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByPid($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByAttribute($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByOiField($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByOiFieldGroup($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByOiConditionField($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByOiConditionValue($col, $val, $opt=array())
 *
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByAttribute($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByOiField($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByOiFieldGroup($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByOiConditionField($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByOiConditionValue($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findBy($col, $val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByAttribute($id, array $opt=array())
 * @method static integer countByOiField($id, array $opt=array())
 * @method static integer countByOiFieldGroup$id, array $opt=array())
 * @method static integer countByOiConditionField$id, array $opt=array())
 * @method static integer countByOiConditionValue$id, array $opt=array())
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */

class InterfaceMappingModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface_mapping';

    /**
     * Find published real estate items
     *
     * @param integer $pid            Parent ID
     * @param array   $arrAttributes  Array of attribute names
     * @param array   $arrOptions     An optional options array
     *
     * @return \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null A collection of models or null if there are no interface mappings
     */
    public static function findByPidAndAttributes($pid, $arrAttributes, array $arrOptions=array())
    {
        $t = static::$strTable;

        $arrColumns = array("$t.pid=?");
        $arrValues = array();

        if (count($arrAttributes))
        {
            $attributes = array();

            foreach ($arrAttributes as $attribute)
            {
                $attributes[] = "$t.attribute=?";
                $arrValues[] = $attribute;

            }

            $arrColumns[] = '(' . implode(' OR ', $attributes) . ')';
        }

        return static::findBy($arrColumns, $arrValues, $arrOptions);
    }
}
