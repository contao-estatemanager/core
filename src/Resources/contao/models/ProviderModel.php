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
 * Reads and writes provider
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $anbieternr
 * @property string  $firma
 * @property string  $openimmo_anid
 * @property string  $lizenzkennung
 * @property string  $singleSRC
 * @property string  $impressum
 * @property string  $firmenanschrift
 * @property string  $postleitzahl
 * @property string  $ort
 * @property string  $strasse
 * @property string  $hausnummer
 * @property string  $bundesland
 * @property string  $land
 * @property string  $telefon
 * @property string  $vertretungsberechtigter
 * @property string  $berufsaufsichtsbehoerde
 * @property string  $handelsregister
 * @property string  $handelsregister_nr
 * @property string  $umsstid
 * @property string  $steuernummer
 * @property string  $weiteres
 * @property boolean $published
 *
 * @method static ProviderModel|null findById($id, array $opt=array())
 * @method static ProviderModel|null findOneBy($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByAnbieternr($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByFirma($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByOpenimmo_anid($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByLizenzkennung($col, $val, $opt=array())
 * @method static ProviderModel|null findOneBySingleSRC($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByImpressum($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByFirmenanschrift($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByPostleitzahl($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByOrt($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByStrasse($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByHausnummer($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByBundesland($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByLand($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByTelefon($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByVertretungsberechtigter($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByBerufsaufsichtsbehoerde($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByHandelsregister($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByHandelsregister_nr($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByUmsstid($col, $val, $opt=array())
 * @method static ProviderModel|null findOneBySteuernummer($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByWeiteres($col, $val, $opt=array())
 * @method static ProviderModel|null findOneByPublished($col, $val, $opt=array())
 *
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByAnbieternr($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByFirma($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByOpenimmo_anid($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByLizenzkennung($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findBySingleSRC($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByImpressum($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByFirmenanschrift($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByPostleitzahl($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByOrt($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByStrasse($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByHausnummer($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByBundesland($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByLand($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByTelefon($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByVertretungsberechtigter($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByBerufsaufsichtsbehoerde($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByHandelsregister($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByHandelsregister_nr($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByUmsstid($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findBySteuernummer($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByWeiteres($val, array $opt=array())
 * @method static \Model\Collection|ProviderModel[]|ProviderModel|null findByPublished($val, array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByAnbieternr($id, array $opt=array())
 * @method static integer countByFirma($id, array $opt=array())
 * @method static integer countByOpenimmo_anid($id, array $opt=array())
 * @method static integer countByLizenzkennung($id, array $opt=array())
 * @method static integer countBySingleSRC($id, array $opt=array())
 * @method static integer countByImpressum($id, array $opt=array())
 * @method static integer countByFirmenanschrift($id, array $opt=array())
 * @method static integer countByPostleitzahl($id, array $opt=array())
 * @method static integer countByOrt($id, array $opt=array())
 * @method static integer countByStrasse($id, array $opt=array())
 * @method static integer countByHausnummer($id, array $opt=array())
 * @method static integer countByBundesland($id, array $opt=array())
 * @method static integer countByLand($id, array $opt=array())
 * @method static integer countByTelefon($id, array $opt=array())
 * @method static integer countByVertretungsberechtigter($id, array $opt=array())
 * @method static integer countByBerufsaufsichtsbehoerde($id, array $opt=array())
 * @method static integer countByHandelsregister($id, array $opt=array())
 * @method static integer countByHandelsregister_nr($id, array $opt=array())
 * @method static integer countByUmsstid($id, array $opt=array())
 * @method static integer countBySteuernummer($id, array $opt=array())
 * @method static integer countByWeiteres($id, array $opt=array())
 * @method static integer countByPublished$id, array $opt=array())
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class ProviderModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_provider';
}
