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
 * Reads and writes interfaces
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static InterfaceModel|null findById($id, array $opt=array())
 * @method static InterfaceModel|null findOneBy($col, $val, $opt=array())
 * @method static InterfaceModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static InterfaceModel|null findOneByTitle($col, $val, $opt=array())
 *
 * @method static \Model\Collection|InterfaceModel[]|InterfaceModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|InterfaceModel[]|InterfaceModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|InterfaceModel[]|InterfaceModel|null findByTitle($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByTitle($id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class InterfaceModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_interface';
}

class_alias(InterfaceModel::class, 'InterfaceModel');