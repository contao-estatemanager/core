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
 * Reads and writes provider
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $anbieternr
 * @property string  $openimmo_anid
 * @property string  $lizenzkennung
 * @property string  $singleSRC
 * @property string  $forwardingMode
 * @property string  $firma
 * @property string  $postleitzahl
 * @property string  $ort
 * @property string  $strasse
 * @property string  $hausnummer
 * @property string  $bundesland
 * @property string  $land
 * @property string  $lat
 * @property string  $lng
 * @property string  $telefon
 * @property string  $telefon2
 * @property string  $fax
 * @property string  $email
 * @property string  $homepage
 * @property string  $firmenanschrift
 * @property string  $vertretungsberechtigter
 * @property string  $berufsaufsichtsbehoerde
 * @property string  $handelsregister
 * @property string  $handelsregister_nr
 * @property string  $umsstid
 * @property string  $steuernummer
 * @property string  $weiteres
 * @property string  $impressum
 * @property string  $beschreibung
 * @property boolean $published
 *
 * @method static ProviderModel|null findById($id, array $opt=array())
 * @method static ProviderModel|null findByPk($id, array $opt=array())
 * @method static ProviderModel|null findOneBy($col, $val, array $opt=array())
 * @method static ProviderModel|null findOneByTstamp($val, array $opt=array())
 * @method static ProviderModel|null findOneByAnbieternr($val, array $opt=array())
 * @method static ProviderModel|null findOneByOpenimmo_anid($val, array $opt=array())
 * @method static ProviderModel|null findOneByLizenzkennung($val, array $opt=array())
 * @method static ProviderModel|null findOneBySingleSRC($val, array $opt=array())
 * @method static ProviderModel|null findOneByForwardingMode($val, array $opt=array())
 * @method static ProviderModel|null findOneByFirma($val, array $opt=array())
 * @method static ProviderModel|null findOneByPostleitzahl($val, array $opt=array())
 * @method static ProviderModel|null findOneByOrt($val, array $opt=array())
 * @method static ProviderModel|null findOneByStrasse($val, array $opt=array())
 * @method static ProviderModel|null findOneByHausnummer($val, array $opt=array())
 * @method static ProviderModel|null findOneByBundesland($val, array $opt=array())
 * @method static ProviderModel|null findOneByLand($val, array $opt=array())
 * @method static ProviderModel|null findOneByLat($val, array $opt=array())
 * @method static ProviderModel|null findOneByLng($val, array $opt=array())
 * @method static ProviderModel|null findOneByTelefon($val, array $opt=array())
 * @method static ProviderModel|null findOneByTelefon2($val, array $opt=array())
 * @method static ProviderModel|null findOneByFax($val, array $opt=array())
 * @method static ProviderModel|null findOneByEmail($val, array $opt=array())
 * @method static ProviderModel|null findOneByHomepage($val, array $opt=array())
 * @method static ProviderModel|null findOneByFirmenanschrift($val, array $opt=array())
 * @method static ProviderModel|null findOneByVertretungsberechtigter($val, array $opt=array())
 * @method static ProviderModel|null findOneByBerufsaufsichtsbehoerde($val, array $opt=array())
 * @method static ProviderModel|null findOneByHandelsregister($val, array $opt=array())
 * @method static ProviderModel|null findOneByHandelsregister_nr($val, array $opt=array())
 * @method static ProviderModel|null findOneByUmsstid($val, array $opt=array())
 * @method static ProviderModel|null findOneBySteuernummer($val, array $opt=array())
 * @method static ProviderModel|null findOneByWeiteres($val, array $opt=array())
 * @method static ProviderModel|null findOneByImpressum($val, array $opt=array())
 * @method static ProviderModel|null findOneByBeschreibung($val, array $opt=array())
 * @method static ProviderModel|null findOneByPublished($val, array $opt=array())
 *
 * @method static Collection|ProviderModel[]|ProviderModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByAnbieternr($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByOpenimmo_anid($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByLizenzkennung($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findBySingleSRC($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByForwardingMode($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByFirma($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByPostleitzahl($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByOrt($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByStrasse($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByHausnummer($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByBundesland($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByLand($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByLat($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByLng($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByTelefon($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByTelefon2($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByFax($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByEmail($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByHomepage($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByFirmenanschrift($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByVertretungsberechtigter($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByBerufsaufsichtsbehoerde($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByHandelsregister($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByHandelsregister_nr($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByUmsstid($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findBySteuernummer($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByWeiteres($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByImpressum($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByBeschreibung($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findByPublished($val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|ProviderModel[]|ProviderModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByAnbieternr($val, array $opt=array())
 * @method static integer countByOpenimmo_anid($val, array $opt=array())
 * @method static integer countByLizenzkennung($val, array $opt=array())
 * @method static integer countBySingleSRC($val, array $opt=array())
 * @method static integer countByForwardingMode($val, array $opt=array())
 * @method static integer countByFirma($val, array $opt=array())
 * @method static integer countByPostleitzahl($val, array $opt=array())
 * @method static integer countByOrt($val, array $opt=array())
 * @method static integer countByStrasse($val, array $opt=array())
 * @method static integer countByHausnummer($val, array $opt=array())
 * @method static integer countByBundesland($val, array $opt=array())
 * @method static integer countByLand($val, array $opt=array())
 * @method static integer countByLat($val, array $opt=array())
 * @method static integer countByLng($val, array $opt=array())
 * @method static integer countByTelefon($val, array $opt=array())
 * @method static integer countByTelefon2($val, array $opt=array())
 * @method static integer countByFax($val, array $opt=array())
 * @method static integer countByEmail($val, array $opt=array())
 * @method static integer countByHomepage($val, array $opt=array())
 * @method static integer countByFirmenanschrift($val, array $opt=array())
 * @method static integer countByVertretungsberechtigter($val, array $opt=array())
 * @method static integer countByBerufsaufsichtsbehoerde($val, array $opt=array())
 * @method static integer countByHandelsregister($val, array $opt=array())
 * @method static integer countByHandelsregister_nr($val, array $opt=array())
 * @method static integer countByUmsstid($val, array $opt=array())
 * @method static integer countBySteuernummer($val, array $opt=array())
 * @method static integer countByWeiteres($val, array $opt=array())
 * @method static integer countByImpressum($val, array $opt=array())
 * @method static integer countByBeschreibung($val, array $opt=array())
 * @method static integer countByPublished($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class ProviderModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_provider';
}
