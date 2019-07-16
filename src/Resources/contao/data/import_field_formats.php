<?php
/**
 * Default field formats with action
 *
 * @version 0.0.3
 * @author  Daniele Sciannimanica <daniele@oveleon.de>
 */
return array
(
    array
    (
        'field' => array('kaufpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('kaltmiete', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('nettokaltmiete', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('nebenkosten', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('heizkosten', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('warmmiete', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('kaution', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('hausgeld', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stpGarageKaufpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stpGarageMietpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stpFreiplatzMietpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stpFreiplatzKaufpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stpTiefgarageMietpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stpTiefgarageKaufpreis', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('pauschalmiete', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('wohnflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('vermietbareFlaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('nutzflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('gartenflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('lagerflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('ladenflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('grundstuecksflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('gesamtflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('bueroflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlBetten', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlZimmer', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlSchlafzimmer', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlBadezimmer', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlWohneinheiten', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlBalkone', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlTerrassen', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('klimatisiert', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('zzgMehrwertsteuer', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('provisionspflichtig', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('kabelSatTv', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('dachboden', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('kamin', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('rolladen', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('waschTrockenraum', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('gartennutzung', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('teekueche', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('alsFerien', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('einliegerwohnung', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('gaestewc', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('wintergarten', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('energiepassMitwarmwasser', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('heizkostenEnthalten', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('barrierefrei', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('seniorengerecht', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('nichtraucher', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('haustiere', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('kabelkanaele', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('abstellraum', '', '', NULL),
        'actions' => array
        (
            array('boolToWord', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('fahrstuhlart', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('stellplatzart', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('befeuerung', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('heizungsart', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('boden', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('kueche', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('bad', '', '', NULL),
        'actions' => array
        (
            array('unserialize', '', '', ', ', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('energiepassEnergieverbrauchkennwert', '', '', NULL),
        'actions' => array
        (
            array('append', '', ' kWh/(m²*a)', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('energiepassEndenergiebedarf', '', '', NULL),
        'actions' => array
        (
            array('append', '', ' kWh/(m²*a)', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('nettorenditeIst', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' %', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('nettorenditeSoll', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' %', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('aussenCourtage', '', '', NULL, '1'),
        'actions' => array
        (
            array('custom', '', '', '', '', NULL, 're_ac_openimmo_courtage')
        )
    ),
    array
    (
        'field' => array('breitbandArt', '', '1', 'a:1:{i:0;a:2:{s:5:"field";s:15:"breitbandZugang";s:5:"value";s:1:"1";}}'),
        'actions' => null
    ),
    array
    (
        'field' => array('breitbandGeschw', '', '1', 'a:1:{i:0;a:2:{s:5:"field";s:15:"breitbandZugang";s:5:"value";s:1:"1";}}'),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' Mbit/s', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlSepWc', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('pacht', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' € / Jahr', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('gesamtmietenetto', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('abdatum', '', '', NULL),
        'actions' => array
        (
            array('date_format', '', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('anzahlStellplaetze', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, '')
        )
    ),
    array
    (
        'field' => array('mietpreisProQm', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €/m²', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('verkaufsflaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('teilbarAb', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('balkonTerrasseFlaeche', '', '', NULL),
        'actions' => array
        (
            array('number_format', '2', '', '', '', NULL, ''),
            array('append', '', ' m²', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('kaufpreisProQm', '', '', NULL),
        'actions' => array
        (
            array('number_format', '0', '', '', '', NULL, ''),
            array('append', '', ' €/m²', '', '', NULL, ''),
        )
    ),
    array
    (
        'field' => array('objektart', '', '', NULL),
        'actions' => array
        (
            array('custom', '', '', '', '', NULL, 're_ac_openimmo_objektart')
        )
    ),
    array
    (
        'field' => array('etage', '', '', NULL),
        'actions' => array
        (
            array('combine', '', '', ' / ', '', 'a:2:{i:0;a:2:{s:5:"field";s:5:"etage";s:6:"remove";s:0:"";}i:1;a:2:{s:5:"field";s:12:"anzahlEtagen";s:6:"remove";s:1:"1";}}', '')
        )
    ),
    array
    (
        'field' => array('plz', '', '', NULL),
        'actions' => array
        (
            array('combine', '', '', ' ', '', 'a:2:{i:0;a:2:{s:5:"field";s:3:"plz";s:6:"remove";s:1:"1";}i:1;a:2:{s:5:"field";s:3:"ort";s:6:"remove";s:1:"1";}}', '')
        )
    ),
    array
    (
        'field' => array('strasse', '', '1', 'a:1:{i:0;a:2:{s:5:"field";s:22:"objektadresseFreigeben";s:5:"value";s:1:"1";}}'),
        'actions' => array
        (
            array('combine', '', '', ' ', '', 'a:2:{i:0;a:2:{s:5:"field";s:7:"strasse";s:6:"remove";s:1:"1";}i:1;a:2:{s:5:"field";s:10:"hausnummer";s:6:"remove";s:1:"1";}}', '')
        )
    ),
    array
    (
        'field' => array('hausnummer', '', '1', 'a:1:{i:0;a:2:{s:5:"field";s:22:"objektadresseFreigeben";s:5:"value";s:1:"1";}}'),
        'actions' => null
    ),
    array
    (
        'field' => array('wohnungsnr', '', '1', 'a:1:{i:0;a:2:{s:5:"field";s:22:"objektadresseFreigeben";s:5:"value";s:1:"1";}}'),
        'actions' => null
    ),
    array
    (
        'field' => array('ort', '', '', NULL),
        'actions' => array
        (
            array('combine', '', '', ' ', '', 'a:2:{i:0;a:2:{s:5:"field";s:3:"ort";s:6:"remove";s:1:"1";}i:1;a:2:{s:5:"field";s:16:"regionalerZusatz";s:6:"remove";s:1:"1";}}', '')
        )
    )
);