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
 * Reads and writes interfaces
 *
 * @property integer $id
 * @property integer $tstamp
 * @property integer $lastSync
 * @property string  $title
 * @property string  $type
 * @property string  $provider
 * @property string  $anbieternr
 * @property string  $uniqueProviderField
 * @property string  $uniqueField
 * @property string  $importPath
 * @property string  $filesPath
 * @property string  $filesPathContactPerson
 * @property string  $contactPersonActions
 * @property string  $contactPersonUniqueField
 * @property string  $importThirdPartyRecords
 * @property integer $assignContactPersonKauf
 * @property integer $assignContactPersonMietePacht
 * @property integer $assignContactPersonErbpacht
 * @property integer $assignContactPersonLeasing
 * @property string  $skipRecords
 * @property string  $autoSync
 * @property integer $deleteFilesOlderThen
 *
 * @method static InterfaceModel|null findById($id, array $opt=array())
 * @method static InterfaceModel|null findByPk($id, array $opt=array())
 * @method static InterfaceModel|null findOneBy($col, $val, array $opt=array())
 * @method static InterfaceModel|null findOneByTstamp($val, array $opt=array())
 * @method static InterfaceModel|null findOneByLastSync($val, array $opt=array())
 * @method static InterfaceModel|null findOneByTitle($val, array $opt=array())
 * @method static InterfaceModel|null findOneByType($val, array $opt=array())
 * @method static InterfaceModel|null findOneByProvider($val, array $opt=array())
 * @method static InterfaceModel|null findOneByAnbieternr($val, array $opt=array())
 * @method static InterfaceModel|null findOneByUniqueProviderField($val, array $opt=array())
 * @method static InterfaceModel|null findOneByUniqueField($val, array $opt=array())
 * @method static InterfaceModel|null findOneByImportPath($val, array $opt=array())
 * @method static InterfaceModel|null findOneByFilesPath($val, array $opt=array())
 * @method static InterfaceModel|null findOneByFilesPathContactPerson($val, array $opt=array())
 * @method static InterfaceModel|null findOneByContactPersonActions($val, array $opt=array())
 * @method static InterfaceModel|null findOneByContactPersonUniqueField($val, array $opt=array())
 * @method static InterfaceModel|null findOneByImportThirdPartyRecords($val, array $opt=array())
 * @method static InterfaceModel|null findOneByAssignContactPersonKauf($val, array $opt=array())
 * @method static InterfaceModel|null findOneByAssignContactPersonMietePacht($val, array $opt=array())
 * @method static InterfaceModel|null findOneByAssignContactPersonErbpacht($val, array $opt=array())
 * @method static InterfaceModel|null findOneByAssignContactPersonLeasing($val, array $opt=array())
 * @method static InterfaceModel|null findOneBySkipRecords($val, array $opt=array())
 * @method static InterfaceModel|null findOneByAutoSync($val, array $opt=array())
 * @method static InterfaceModel|null findOneByDeleteFilesOlderThen($val, array $opt=array())
 *
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByLastSync($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByTitle($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByType($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByProvider($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByAnbieternr($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByUniqueProviderField($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByUniqueField($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByImportPath($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByFilesPath($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByFilesPathContactPerson($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByContactPersonActions($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByContactPersonUniqueField($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByImportThirdPartyRecords($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByAssignContactPersonKauf($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByAssignContactPersonMietePacht($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByAssignContactPersonErbpacht($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByAssignContactPersonLeasing($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findBySkipRecords($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByAutoSync($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findByDeleteFilesOlderThen($val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|InterfaceModel[]|InterfaceModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByLastSync($val, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countByType($val, array $opt=array())
 * @method static integer countByProvider($val, array $opt=array())
 * @method static integer countByAnbieternr($val, array $opt=array())
 * @method static integer countByUniqueProviderField($val, array $opt=array())
 * @method static integer countByUniqueField($val, array $opt=array())
 * @method static integer countByImportPath($val, array $opt=array())
 * @method static integer countByFilesPath($val, array $opt=array())
 * @method static integer countByFilesPathContactPerson($val, array $opt=array())
 * @method static integer countByContactPersonActions($val, array $opt=array())
 * @method static integer countByContactPersonUniqueField($val, array $opt=array())
 * @method static integer countByImportThirdPartyRecords($val, array $opt=array())
 * @method static integer countByAssignContactPersonKauf($val, array $opt=array())
 * @method static integer countByAssignContactPersonMietePacht($val, array $opt=array())
 * @method static integer countByAssignContactPersonErbpacht($val, array $opt=array())
 * @method static integer countByAssignContactPersonLeasing($val, array $opt=array())
 * @method static integer countBySkipRecords($val, array $opt=array())
 * @method static integer countByAutoSync($val, array $opt=array())
 * @method static integer countByDeleteFilesOlderThen($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class InterfaceModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface';
}
