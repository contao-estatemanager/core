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
 * Reads and writes contact persons
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string $name
 * @property string $vorname
 * @property string $anrede
 * @property string $titel
 * @property string $position
 * @property string $anrede_brief
 * @property string $firma
 * @property string $zusatzfeld
 * @property string $strasse
 * @property string $hausnummer
 * @property string $plz
 * @property string $ort
 * @property string $postfach
 * @property string $postf_plz
 * @property string $postf_ort
 * @property string $land
 * @property string $email_privat
 * @property string $email_sonstige
 * @property string $email_feedback
 * @property string $tel_privat
 * @property string $tel_sonstige
 * @property string $url
 * @property string $adressfreigabe
 * @property string $personennummer
 * @property string $immobilientreuhaenderid
 * @property string $singleSRC
 * @property string $freitextfeld
 * @property boolean $published
 *
 * @method static ContactPersonModel|null findById($id, array $opt=array())
 * @method static ContactPersonModel|null findByPk($id, array $opt=array())
 * @method static ContactPersonModel|null findOneBy($col, $val, $opt=array())
 * @method static ContactPersonModel|null findOneByPid($val, $opt=array())
 * @method static ContactPersonModel|null findOneByTstamp($val, $opt=array())
 * @method static ContactPersonModel|null findOneByName($val, $opt=array())
 * @method static ContactPersonModel|null findOneByVorname($val, $opt=array())
 * @method static ContactPersonModel|null findOneByAnrede($val, $opt=array())
 * @method static ContactPersonModel|null findOneByTitel($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPosition($val, $opt=array())
 * @method static ContactPersonModel|null findOneByAnrede_brief($val, $opt=array())
 * @method static ContactPersonModel|null findOneByFirma($val, $opt=array())
 * @method static ContactPersonModel|null findOneByZusatzfeld($val, $opt=array())
 * @method static ContactPersonModel|null findOneByStrasse($val, $opt=array())
 * @method static ContactPersonModel|null findOneByHausnummer($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPlz($val, $opt=array())
 * @method static ContactPersonModel|null findOneByOrt($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPostfach($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPostf_plz($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPostf_ort($val, $opt=array())
 * @method static ContactPersonModel|null findOneByLand($val, $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_privat($val, $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_sonstige($val, $opt=array())
 * @method static ContactPersonModel|null findOneByEmail_feedback($val, $opt=array())
 * @method static ContactPersonModel|null findOneByTel_privat($val, $opt=array())
 * @method static ContactPersonModel|null findOneByTel_sonstige($val, $opt=array())
 * @method static ContactPersonModel|null findOneByUrl($val, $opt=array())
 * @method static ContactPersonModel|null findOneByAdressfreigabe($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPersonennummer($val, $opt=array())
 * @method static ContactPersonModel|null findOneByImmobilientreuhaenderid($val, $opt=array())
 * @method static ContactPersonModel|null findOneBySingleSRC($val, $opt=array())
 * @method static ContactPersonModel|null findOneByFreitextfeld($val, $opt=array())
 * @method static ContactPersonModel|null findOneByPublished($val, $opt=array())
 *
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByName($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByVorname($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByAnrede($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByTitel($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPosition($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByAnrede_brief($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByFirma($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByZusatzfeld($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByStrasse($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByHausnummer($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPlz($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByOrt($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPostfach($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPostf_plz($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPostf_ort($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByLand($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_privat($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_sonstige($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByEmail_feedback($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_privat($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByTel_sonstige($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByUrl($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByAdressfreigabe($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPersonennummer($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByImmobilientreuhaenderid($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findBySingleSRC($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByFreitextfeld($val, array $opt=array())
 * @method static \Model\Collection|ContactPersonModel[]|ContactPersonModel|null findByPublished($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByTstamp($val, $opt=array())
 * @method static integer countByName($val, $opt=array())
 * @method static integer countByVorname($val, $opt=array())
 * @method static integer countByAnrede($val, $opt=array())
 * @method static integer countByTitel($val, $opt=array())
 * @method static integer countByPosition($val, $opt=array())
 * @method static integer countByAnrede_brief($val, $opt=array())
 * @method static integer countByFirma($val, $opt=array())
 * @method static integer countByZusatzfeld($val, $opt=array())
 * @method static integer countByStrasse($val, $opt=array())
 * @method static integer countByHausnummer($val, $opt=array())
 * @method static integer countByPlz($val, $opt=array())
 * @method static integer countByOrt($val, $opt=array())
 * @method static integer countByPostfach($val, $opt=array())
 * @method static integer countByPostf_plz($val, $opt=array())
 * @method static integer countByPostf_ort($val, $opt=array())
 * @method static integer countByLand($val, $opt=array())
 * @method static integer countByEmail_privat($val, $opt=array())
 * @method static integer countByEmail_sonstige($val, $opt=array())
 * @method static integer countByEmail_feedback($val, $opt=array())
 * @method static integer countByTel_privat($val, $opt=array())
 * @method static integer countByTel_sonstige($val, $opt=array())
 * @method static integer countByUrl($val, $opt=array())
 * @method static integer countByAdressfreigabe($val, $opt=array())
 * @method static integer countByPersonennummer($val, $opt=array())
 * @method static integer countByImmobilientreuhaenderid($val, $opt=array())
 * @method static integer countBySingleSRC($val, $opt=array())
 * @method static integer countByFreitextfeld($val, $opt=array())
 * @method static integer countByPublished($val, $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class ContactPersonModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_contact_person';
}