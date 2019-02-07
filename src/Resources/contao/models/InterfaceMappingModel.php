<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


/**
 * Reads and writes interface mappings
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property integer $sorting
 * @property string  $title
 * @property boolean $published
 *
 * @method static InterfaceMappingModel|null findById($id, array $opt=array())
 * @method static InterfaceMappingModel|null findByPk($id, array $opt=array())
 * @method static InterfaceMappingModel|null findOneBy($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneBySorting($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByTitle($col, $val, $opt=array())
 * @method static InterfaceMappingModel|null findOneByPublished($col, $val, $opt=array())
 *
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findBySorting($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByTitle($val, array $opt=array())
 * @method static \Model\Collection|InterfaceMappingModel[]|InterfaceMappingModel|null findByPublished($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countBySorting($id, array $opt=array())
 * @method static integer countByTitle($id, array $opt=array())
 * @method static integer countByPublished$id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class InterfaceMappingModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface_mapping';
}

class_alias(InterfaceMappingModel::class, 'InterfaceMappingModel');