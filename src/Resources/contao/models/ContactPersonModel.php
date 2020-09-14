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
 * Reads and writes contact persons
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string  $anrede
 * @property string  $firma
 * @property string  $vorname
 * @property string  $name
 * @property string  $titel
 * @property string  $position
 * @property string  $anrede_brief
 * @property string  $email_zentrale
 * @property string  $email_direkt
 * @property string  $email_privat
 * @property string  $email_sonstige
 * @property string  $email_feedback
 * @property string  $tel_zentrale
 * @property string  $tel_durchw
 * @property string  $tel_fax
 * @property string  $tel_handy
 * @property string  $tel_privat
 * @property string  $tel_sonstige
 * @property string  $strasse
 * @property string  $hausnummer
 * @property string  $plz
 * @property string  $ort
 * @property string  $land
 * @property string  $zusatzfeld
 * @property string  $freitextfeld
 * @property boolean $adressfreigabe
 * @property string  $singleSRC
 * @property string  $postfach
 * @property string  $postfach_plz
 * @property string  $postfach_ort
 * @property string  $personennummer
 * @property string  $immobilientreuhaenderid
 * @property boolean $published
 *
 * @method static ContactPersonModel|null findById($id, array $opt=array())
 * @method static ContactPersonModel|null findByPk($id, array $opt=array())
 * @method static ContactPersonModel|null findOneBy($col, $val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPid($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTstamp($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByAnrede($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByFirma($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByVorname($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByName($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTitel($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPosition($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByAnrede_brief($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_zentrale($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_direkt($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_privat($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_sonstige($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_feedback($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTel_zentrale($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTel_durchw($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTel_fax($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTel_handy($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTel_privat($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByTel_sonstige($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByStrasse($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByHausnummer($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPlz($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByOrt($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByLand($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByZusatzfeld($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByFreitextfeld($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByAdressfreigabe($val, array $opt=array())
 * @method static ContactPersonModel|null findOneBySingleSRC($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPostfach($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPostfach_plz($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPostfach_ort($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPersonennummer($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByImmobilientreuhaenderid($val, array $opt=array())
 * @method static ContactPersonModel|null findOneByPublished($val, array $opt=array())
 *
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPid($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByAnrede($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByFirma($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByVorname($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByName($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTitel($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPosition($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByAnrede_brief($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_zentrale($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_direkt($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_privat($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_sonstige($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_feedback($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_zentrale($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_durchw($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_fax($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_handy($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_privat($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_sonstige($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByStrasse($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByHausnummer($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPlz($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByOrt($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByLand($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByZusatzfeld($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByFreitextfeld($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByAdressfreigabe($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findBySingleSRC($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPostfach($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPostfach_plz($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPostfach_ort($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPersonennummer($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByImmobilientreuhaenderid($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findByPublished($val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|ContactPersonModel[]|ContactPersonModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByAnrede($val, array $opt=array())
 * @method static integer countByFirma($val, array $opt=array())
 * @method static integer countByVorname($val, array $opt=array())
 * @method static integer countByName($val, array $opt=array())
 * @method static integer countByTitel($val, array $opt=array())
 * @method static integer countByPosition($val, array $opt=array())
 * @method static integer countByAnrede_brief($val, array $opt=array())
 * @method static integer countByEmail_zentrale($val, array $opt=array())
 * @method static integer countByEmail_direkt($val, array $opt=array())
 * @method static integer countByEmail_privat($val, array $opt=array())
 * @method static integer countByEmail_sonstige($val, array $opt=array())
 * @method static integer countByEmail_feedback($val, array $opt=array())
 * @method static integer countByTel_zentrale($val, array $opt=array())
 * @method static integer countByTel_durchw($val, array $opt=array())
 * @method static integer countByTel_fax($val, array $opt=array())
 * @method static integer countByTel_handy($val, array $opt=array())
 * @method static integer countByTel_privat($val, array $opt=array())
 * @method static integer countByTel_sonstige($val, array $opt=array())
 * @method static integer countByStrasse($val, array $opt=array())
 * @method static integer countByHausnummer($val, array $opt=array())
 * @method static integer countByPlz($val, array $opt=array())
 * @method static integer countByOrt($val, array $opt=array())
 * @method static integer countByLand($val, array $opt=array())
 * @method static integer countByZusatzfeld($val, array $opt=array())
 * @method static integer countByFreitextfeld($val, array $opt=array())
 * @method static integer countByAdressfreigabe($val, array $opt=array())
 * @method static integer countBySingleSRC($val, array $opt=array())
 * @method static integer countByPostfach($val, array $opt=array())
 * @method static integer countByPostfach_plz($val, array $opt=array())
 * @method static integer countByPostfach_ort($val, array $opt=array())
 * @method static integer countByPersonennummer($val, array $opt=array())
 * @method static integer countByImmobilientreuhaenderid($val, array $opt=array())
 * @method static integer countByPublished($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class ContactPersonModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_contact_person';

    /**
     * Find published contact persons by their parent IDs
     *
     * @param array $arrPids         Array of provider IDs
     * @param array $arrOptions      An optional options array
     *
     * @return \Model\Collection|ContactPersonModel[]|ContactPersonModel|null A collection of models or null if there are no contact persons
     */
    public static function findPublishedByPids($arrPids, $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ") AND $t.published='1'");

        return static::findBy($arrColumns, null, $arrOptions);
    }
}
