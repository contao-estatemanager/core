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
 * Reads and writes interface logs
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
 * @method static InterfaceLogModel|null findById($id, array $opt=array())
 * @method static InterfaceLogModel|null findByPk($id, array $opt=array())
 * @method static InterfaceLogModel|null findOneBy($col, $val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByPid($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByTstamp($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByLevel($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneBySource($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByAction($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByUsername($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByText($val, array $opt=array())
 * @method static InterfaceLogModel|null findOneByData($val, array $opt=array())
 *
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByPid($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByLevel($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findBySource($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByAction($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByUsername($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByText($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findByData($val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|InterfaceLogModel[]|InterfaceLogModel|null findAll(array $opt=array())
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

class InterfaceLogModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface_log';
}
