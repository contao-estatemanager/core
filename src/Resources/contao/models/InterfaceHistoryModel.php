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
 * Reads and writes interface history records
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property integer $mtime
 * @property string  $source
 * @property string  $action
 * @property string  $username
 * @property string  $text
 * @property integer $status
 *
 * @method static InterfaceHistoryModel|null findById($id, array $opt=array())
 * @method static InterfaceHistoryModel|null findByPk($id, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneBy($col, $val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByPid($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByTstamp($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByMtime($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneBySource($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByAction($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByUsername($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByText($val, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneByStatus($val, array $opt=array())
 *
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByPid($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByMtime($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findBySource($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByAction($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByUsername($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByText($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByStatus($val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByMtime($val, array $opt=array())
 * @method static integer countBySource($val, array $opt=array())
 * @method static integer countByAction($val, array $opt=array())
 * @method static integer countByUsername($val, array $opt=array())
 * @method static integer countByText($val, array $opt=array())
 * @method static integer countByStatus($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class InterfaceHistoryModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface_history';

    /**
     * Find multiple history records by their sources
     *
     * @param array $arrPaths   An array of file paths
     * @param array $arrOptions An optional options array
     *
     * @return \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null A collection of models or null if there are no history records
     */
    public static function findMultipleBySources($arrPaths, array $arrOptions=array())
    {
        if (empty($arrPaths) || !\is_array($arrPaths))
        {
            return null;
        }

        $t = static::$strTable;

        return static::findBy(array("$t.source IN(" . implode(',', array_fill(0, \count($arrPaths), '?')) . ")"), $arrPaths, $arrOptions);
    }
}
