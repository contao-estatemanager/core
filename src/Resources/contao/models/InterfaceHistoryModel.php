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
 * Reads and writes interfaces
 *
 * @property integer $id
 * @property string  $file
 * @property integer $synctime
 * @property integer $filetime
 * @property string  $user
 * @property integer $status
 *
 * @method static InterfaceHistoryModel|null findById($id, array $opt=array())
 * @method static InterfaceHistoryModel|null findByPk($id, array $opt=array())
 * @method static InterfaceHistoryModel|null findOneBy($col, $val, $opt=array())
 * @method static InterfaceHistoryModel|null findOneById($col, $val, $opt=array())
 * @method static InterfaceHistoryModel|null findOneByFile($col, $val, $opt=array())
 * @method static InterfaceHistoryModel|null findOneBySynctime($col, $val, $opt=array())
 * @method static InterfaceHistoryModel|null findOneByFiletime($col, $val, $opt=array())
 * @method static InterfaceHistoryModel|null findOneByUser($col, $val, $opt=array())
 *
 * @method static \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByFile($val, array $opt=array())
 * @method static \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findBySynctime($val, array $opt=array())
 * @method static \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByFiletime($val, array $opt=array())
 * @method static \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByUser($val, array $opt=array())
 * @method static \Model\Collection|InterfaceHistoryModel[]|InterfaceHistoryModel|null findByStatus($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByFile($id, array $opt=array())
 * @method static integer countBySynctime($id, array $opt=array())
 * @method static integer countByFiletime($id, array $opt=array())
 * @method static integer countByUser($id, array $opt=array())
 * @method static integer countByStatus($id, array $opt=array())
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */

class InterfaceHistoryModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface_history';
}
