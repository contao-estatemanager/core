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

use Contao\Database;
use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes real estate groups
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 * @property integer $similarGroup
 * @property integer $referencePage
 * @property string  $vermarktungsart
 * @property boolean $published
 *
 * @method static RealEstateGroupModel|null findById($id, array $opt=array())
 * @method static RealEstateGroupModel|null findByPk($id, array $opt=array())
 * @method static RealEstateGroupModel|null findOneBy($col, $val, array $opt=array())
 * @method static RealEstateGroupModel|null findOneByTstamp($val, array $opt=array())
 * @method static RealEstateGroupModel|null findOneByTitle($val, array $opt=array())
 * @method static RealEstateGroupModel|null findOneBySimilarGroup($val, array $opt=array())
 * @method static RealEstateGroupModel|null findOneByReferencePage($val, array $opt=array())
 * @method static RealEstateGroupModel|null findOneByVermarktungsart($val, array $opt=array())
 * @method static RealEstateGroupModel|null findOneByPublished($val, array $opt=array())
 *
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findByTitle($val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findBySimilarGroup($val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findByReferencePage($val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findByVermarktungsart($val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findByPublished($val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|RealEstateGroupModel[]|RealEstateGroupModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countBySimilarGroup($val, array $opt=array())
 * @method static integer countByReferencePage($val, array $opt=array())
 * @method static integer countByVermarktungsart($val, array $opt=array())
 * @method static integer countByPublished($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class RealEstateGroupModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_real_estate_group';

    /**
     * Find all published real estate groups
     *
     * @param array $arrOptions An optional options array
     *
     * @return Collection|RealEstateGroupModel|RealEstateGroupModel[]|null A collection of models ot null if there are no groups
     */
    public static function findAllPublished(array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array();

        if (!static::isPreviewMode($arrOptions))
        {
            $arrColumns[] = "$t.published='1'";
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Find all published real estate groups by their IDs and sort them if no order is given
     *
     * @param array $arrIds      An array of IDs
     * @param array $arrOptions  An optional options array
     *
     * @return \Model\Collection|RealEstateGroupModel[]|RealEstateGroupModel|null A collection of models or null if there are no groups
     */
    public static function findPublishedByIds($arrIds, array $arrOptions=array())
    {
        if (empty($arrIds) || !\is_array($arrIds))
        {
            return null;
        }

        $t = static::$strTable;
        $arrColumns = array("$t.id IN(" . implode(',', array_map('\intval', $arrIds)) . ") AND $t.published='1'");

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = Database::getInstance()->findInSet("$t.id", $arrIds);
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Find the current used real estate group
     *
     * @param integer $pageId The current page id
     *
     * @return RealEstateGroupModel|null
     */
    public static function findCurrentGroup($pageId=null)
    {
        if ($pageId !== null && ($objGroup = static::findOneByReferencePage($pageId)) instanceof RealEstateGroupModel)
        {
            return $objGroup;
        }

        if ($group = SessionManager::getInstance()->get('group'))
        {
            return static::findOneByVermarktungsart($group);
        }

        return null;
    }
}
