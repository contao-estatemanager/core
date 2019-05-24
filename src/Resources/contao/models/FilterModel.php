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
 * Reads and writes filter
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 * @property boolean $published
 *
 * @method static FilterModel|null findById($id, array $opt=array())
 * @method static FilterModel|null findOneBy($col, $val, $opt=array())
 * @method static FilterModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static FilterModel|null findOneByTitle($col, $val, $opt=array())
 * @method static FilterModel|null findOneByPublished($col, $val, $opt=array())
 *
 * @method static \Model\Collection|FilterModel[]|FilterModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|FilterModel[]|FilterModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|FilterModel[]|FilterModel|null findByTitle($val, array $opt=array())
 * @method static \Model\Collection|FilterModel[]|FilterModel|null findByPublished($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByTitle($id, array $opt=array())
 * @method static integer countByPublished$id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class FilterModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_filter';
}

class_alias(FilterModel::class, 'FilterModel');