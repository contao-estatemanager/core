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
 * Reads and writes interface mappings
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property integer $level
 * @property string  $source
 * @property string  $action
 * @property string  $username
 * @property string  $text
 * @property string  $data
 *
 * @method static InterfaceMappingModel|null findById($id, array $opt=array())
 * @method static InterfaceMappingModel|null findByPk($id, array $opt=array())
 * @method static InterfaceMappingModel|null findOneBy($col, $val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByPid($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByTstamp($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByLevel($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneBySource($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByAction($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByUsername($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByText($val, array $opt=array())
 * @method static InterfaceMappingModel|null findOneByData($val, array $opt=array())
 *
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByPid($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByLevel($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findBySource($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByAction($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByUsername($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByText($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByData($val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByLevel($val, array $opt=array())
 * @method static integer countBySource($val, array $opt=array())
 * @method static integer countByAction($val, array $opt=array())
 * @method static integer countByUsername($val, array $opt=array())
 * @method static integer countByText($val, array $opt=array())
 * @method static integer countByData($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class InterfaceMappingModel extends Model
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
