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
 * @property integer $level
 * @property string  $source
 * @property string  $action
 * @property string  $username
 * @property string  $text
 * @property string  $data
 *
 * @method static InterfaceLogModel|null findById($id, array $opt=array())
 * @method static InterfaceLogModel|null findByPk($id, array $opt=array())
 * @method static InterfaceLogModel|null findOneBy($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneByPid($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneBySource($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneByLevel($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneByAction($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneByUsername($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneByText($col, $val, $opt=array())
 * @method static InterfaceLogModel|null findOneByData($col, $val, $opt=array())
 *
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findBySource($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByLevel($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByAction($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByUsername($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByText($val, array $opt=array())
 * @method static \Model\Collection|InterfaceLogModel[]|InterfaceLogModel|null findByData($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countBySource($id, array $opt=array())
 * @method static integer countByLevel($id, array $opt=array())
 * @method static integer countByAction($id, array $opt=array())
 * @method static integer countByUsername($id, array $opt=array())
 * @method static integer countByText($id, array $opt=array())
 * @method static integer countByData($id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class InterfaceLogModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface_log';
}
