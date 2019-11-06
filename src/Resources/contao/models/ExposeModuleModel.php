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
 * Reads and writes front end modules
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $name
 * @property string  $headline
 * @property string  $type
 * @property string  $customTpl
 * @property boolean $protected
 * @property string  $groups
 * @property boolean $guests
 * @property string  $cssID
 * @property string  $typePrefix
 * @property string  $classes
 *
 * @method static ExposeModuleModel|null findById($id, array $opt=array())
 * @method static ExposeModuleModel|null findByPk($id, array $opt=array())
 * @method static ExposeModuleModel|null findByIdOrAlias($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneBy($col, $val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByTstamp($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByName($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByHeadline($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByType($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByCustomTpl($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByProtected($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGroups($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGuests($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByCssID($val, array $opt=array())
 *
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByTstamp($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByName($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByHeadline($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByType($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByCustomTpl($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByProtected($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGroups($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGuests($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findByCssID($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findMultipleByIds($val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findBy($col, $val, array $opt=array())
 * @method static Model\Collection|ExposeModuleModel[]|ExposeModuleModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByName($val, array $opt=array())
 * @method static integer countByHeadline($val, array $opt=array())
 * @method static integer countByType($val, array $opt=array())
 * @method static integer countByProtected($val, array $opt=array())
 * @method static integer countByGroups($val, array $opt=array())
 * @method static integer countByGuests($val, array $opt=array())
 * @method static integer countByCssID($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleModel extends \Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_expose_module';

}
