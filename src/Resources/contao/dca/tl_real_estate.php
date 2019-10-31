<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_real_estate'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'markAsCopy'                  => 'objekttitel',
        'onload_callback' => array
        (
            array('tl_real_estate', 'checkPermission')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'published' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 2,
            'fields'                  => array('dateAdded DESC'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,sort,limit'
        ),
        'label' => array
        (
            'fields'                  => array('image', 'id', 'objekttitel', 'objektart', 'nutzungsart', 'tstamp'),
            'showColumns'             => true,
            'label_callback'          => array('tl_real_estate', 'addPreviewImageAndInformation')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
                'button_callback'     => array('tl_real_estate', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_real_estate', 'copyRealEstate')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_real_estate', 'deleteRealEstate')
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate']['toggle'],
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_real_estate\')"',
                'button_callback'     => array('tl_real_estate', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('objektart', 'breitbandZugang','weitergabeGenerell'),
        'default'                     => '{real_estate_legend},objekttitel,alias,objektnrIntern,objektnrExtern,openimmoObid,published,weitergabeGenerell;'.
                                         '{real_estate_contact_legend},provider,anbieternr,contactPerson;'.
                                         '{real_estate_basic_legend},vermarktungsartKauf,vermarktungsartMietePacht,vermarktungsartErbpacht,vermarktungsartLeasing,vermietet,verkaufstatus,verfuegbarAb,nutzungsart,objektart;'.
                                         '{real_estate_address_legend},plz,ort,strasse,hausnummer,regionalerZusatz,bundesland,land,breitengrad,laengengrad,lageImBau,lageGebiet,gemeindecode,objektadresseFreigeben;'.
                                         '{real_estate_props_legend:hide},etage,anzahlEtagen,alsFerien,gewerblicheNutzung,denkmalgeschuetzt,wbsSozialwohnung,einliegerwohnung,raeumeVeraenderbar,barrierefrei,rollstuhlgerecht,seniorengerecht,wgGeeignet,nichtraucher,hochhaus,haustiere;'.
                                         '{real_estate_text_legend:hide},dreizeiler,lage,ausstattBeschr,objektbeschreibung,sonstigeAngaben,objektText;'.
                                         '{real_estate_room_legend:hide},anzahlZimmer,anzahlSchlafzimmer,anzahlBadezimmer,anzahlSepWc,anzahlBalkone,anzahlTerrassen,anzahlLogia,anzahlWohnSchlafzimmer,anzahlTagungsraeume,anzahlWohneinheiten,anzahlGewerbeeinheiten;'.
                                         '{real_estate_price_legend:hide},kaufpreis,kaufpreisnetto,kaufpreisbrutto,kaltmiete,nettokaltmiete,warmmiete,freitextPreis,nebenkosten,heizkostenEnthalten,heizkosten,heizkostennetto,heizkostenust,zzgMehrwertsteuer,mietzuschlaege,pauschalmiete,hauptmietzinsnetto,hauptmietzinsust,betriebskostennetto,betriebskostenust,evbnetto,evbust,gesamtmietenetto,gesamtmieteust,gesamtmietebrutto,gesamtbelastungnetto,gesamtbelastungust,gesamtbelastungbrutto,gesamtkostenprom2von,gesamtkostenprom2bis,monatlichekostennetto,monatlichekostenust,monatlichekostenbrutto,nebenkostenprom2von,nebenkostenprom2bis,ruecklagenetto,ruecklageust,sonstigekostennetto,sonstigekostenust,sonstigemietenetto,sonstigemieteust,summemietenetto,summemieteust,nettomieteprom2von,nettomieteprom2bis,pacht,erbpacht,hausgeld,abstand,preisZeitraumVon,preisZeitraumBis,preisZeiteinheit,mietpreisProQm,kaufpreisProQm,provisionspflichtig,provisionTeilenWert,innenCourtage,innenCourtageMwst,aussenCourtage,aussenCourtageMwst,courtageHinweis,provisionnetto,provisionust,provisionbrutto,mwstSatz,mwstGesamt,xFache,nettorendite,nettorenditeSoll,nettorenditeIst,mieteinnahmenIst,mieteinnahmenIstPeriode,mieteinnahmenSoll,mieteinnahmenSollPeriode,erschliessungskosten,kaution,kautionText,geschaeftsguthaben,richtpreis,richtpreisprom2;'.
                                         '{real_estate_area_legend:hide},wohnflaeche,nutzflaeche,gesamtflaeche,ladenflaeche,lagerflaeche,verkaufsflaeche,freiflaeche,bueroflaeche,bueroteilflaeche,fensterfront,verwaltungsflaeche,gastroflaeche,grz,gfz,bmz,bgf,grundstuecksflaeche,sonstflaeche,balkonTerrasseFlaeche,gartenflaeche,kellerflaeche,fensterfrontQm,grundstuecksfront,dachbodenflaeche,beheizbareFlaeche,vermietbareFlaeche,teilbarAb;'.
                                         '{real_estate_features_legend:hide},ausstattKategorie,bad,kueche,boden,heizungsart,befeuerung,fahrstuhlart,ausrichtBalkonTerrasse,moebliert,angeschlGastronomie,serviceleistungen,sicherheitstechnik,kabelSatTv,dvbt,sauna,swimmingpool,waschTrockenraum,wintergarten,dvVerkabelung,rampe,hebebuehne,kran,gastterrasse,kantineCafeteria,teekueche,brauereibindung,sporteinrichtungen,wellnessbereich,telefonFerienimmobilie,umtsEmpfang,abstellraum,fahrradraum,rolladen,bibliothek,dachboden,gaestewc,kabelkanaele,kartenMakro,kartenMikro,virtuelletour,luftbildern,zulieferung,kamin,klimatisiert,gartennutzung,unterkellert,breitbandZugang;'.
                                         '{real_estate_parking_legend:hide},stellplatzart,anzahlStellplaetze,stpCarport,stpCarportMietpreis,stpCarportKaufpreis,stpDuplex,stpDuplexMietpreis,stpDuplexKaufpreis,stpFreiplatz,stpFreiplatzMietpreis,stpFreiplatzKaufpreis,stpGarage,stpGarageMietpreis,stpGarageKaufpreis,stpParkhaus,stpParkhausMietpreis,stpParkhausKaufpreis,stpTiefgarage,stpTiefgarageMietpreis,stpTiefgarageKaufpreis,stpSonstige,stpSonstigeMietpreis,stpSonstigeKaufpreis,stpSonstigePlatzart,stpSonstigeBemerkung;'.
                                         '{real_estate_energie_legend:hide},baujahr,letztemodernisierung,zustand,alterAttr,bebaubarNach,erschliessung,erschliessungUmfang,bauzone,energiepassEpart,energiepassGueltigBis,energiepassEnergieverbrauchkennwert,energiepassMitwarmwasser,energiepassEndenergiebedarf,energiepassPrimaerenergietraeger,energiepassStromwert,energiepassWaermewert,energiepassWertklasse,energiepassBaujahr,energiepassAusstelldatum,energiepassJahrgang,energiepassGebaeudeart,energiepassEpasstext,energiepassHwbwert,energiepassHwbklasse,energiepassFgeewert,energiepassFgeeklasse;'.
                                         '{real_estate_media_legend:hide},titleImageSRC,imageSRC,planImageSRC,interiorViewImageSRC,exteriorViewImageSRC,mapViewImageSRC,panoramaImageSRC,epassSkalaImageSRC,logoImageSRC,qrImageSRC,documents,links;' .
                                         '{real_estate_more_props_legend:hide},flur,flurstueck,gemarkung,beginnAngebotsphase,besichtigungstermin,besichtigungstermin2,beginnBietzeit,endeBietzeit,hoechstgebotZeigen,mindestpreis,zwangsversteigerung,aktenzeichen,zvtermin,zusatztermin,amtsgericht,verkehrswert,plaetzeGastraum,anzahlBetten,kubatur,ausnuetzungsziffer,flaechevon,flaechebis,stromanschlusswert,hallenhoehe,altlasten,ausblick,distanzFlughafen,distanzFernbahnhof,distanzAutobahn,distanzUsBahn,distanzBus,distanzKindergarten,distanzGrundschule,distanzHauptschule,distanzRealschule,distanzGesamtschule,distanzGymnasium,distanzZentrum,distanzEinkaufsmoeglichkeiten,distanzGaststaetten,distanzSportStrand,distanzSportSee,distanzSportMeer,distanzSportSkigebiet,distanzSportSportanlagen,distanzSportWandergebiete,distanzSportNaherholung,abdatum,bisdatum,minMietdauer,maxMietdauer,versteigerungstermin,gruppennummer,zugang,laufzeit,maxPersonen,geschlecht,branchen,aktivVon,aktivBis,kennungUrsprung,standVom,sprache,anbieterobjekturl;'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'objektart_zimmer'                       => 'zimmerTyp',
        'objektart_wohnung'                      => 'wohnungTyp',
        'objektart_haus'                         => 'hausTyp',
        'objektart_grundstueck'                  => 'grundstTyp',
        'objektart_buero_praxen'                 => 'bueroTyp',
        'objektart_einzelhandel'                 => 'handelTyp',
        'objektart_gastgewerbe'                  => 'gastgewTyp',
        'objektart_hallen_lager_prod'            => 'hallenTyp',
        'objektart_parken'                       => 'parkenTyp',
        'objektart_sonstige'                     => 'sonstigeTyp',
        'objektart_zinshaus_renditeobjekt'       => 'zinsTyp',
        'objektart_land_und_forstwirtschaft'     => 'landTyp',
        'objektart_freizeitimmobilie_gewerblich' => 'freizeitTyp',
        'breitbandZugang'                        => 'breitbandArt,breitbandGeschw',
        'weitergabeGenerell'                     => 'weitergabePositiv,weitergabeNegativ',
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['id'],
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['tstamp'],
            'sorting'                 => true,
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'realEstate'              => array(
                'sorting'   => true
            )
        ),
        'dateAdded' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['dateAdded'],
            'default'                 => time(),
            'sorting'                 => true,
            'flag'                    => 6,
            'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'realEstate'              => array(
                'sorting'   => true
            )
        ),
        'alias' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['alias'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'save_callback' => array
            (
                array('tl_real_estate', 'generateAlias')
            ),
            'sql'                     => "varchar(255) COLLATE utf8_bin NOT NULL default ''"
        ),
        'provider' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['provider'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_real_estate', 'getAllProvider'),
            'eval'                    => array('submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''",
        ),
        'contactPerson' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['contactPerson'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_real_estate', 'getContactPerson'),
            'foreignKey'              => 'tl_contact_person.name',
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'anbieternr' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['anbieternr'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),

         // Objektkategorien
        'nutzungsart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nutzungsart'],
            'inputType'                 => 'select',
            'sorting'                   => true,
            'options'                   => array('wohnen', 'gewerbe', 'anlage', 'waz'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'  => true,
                'order'   => 100
            )
        ),
        'vermarktungsartKauf'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermarktungsartKauf'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'vermarktungsartMietePacht'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermarktungsartMietePacht'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'vermarktungsartErbpacht'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermarktungsartErbpacht'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'vermarktungsartLeasing'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermarktungsartLeasing'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'objektart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektart'],
            'inputType'                 => 'select',
            'sorting'                   => true,
            'options'                   => array('zimmer', 'wohnung', 'haus', 'grundstueck', 'buero_praxen', 'einzelhandel', 'gastgewerbe', 'hallen_lager_prod', 'land_und_forstwirtschaft', 'parken', 'sonstige', 'freizeitimmobilie_gewerblich', 'zinshaus_renditeobjekt'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'  => true,
                'order'   => 100
            )
        ),

        // Objekttypen
        'zimmerTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zimmerTyp'],
            'inputType'                 => 'select',
            'options'                   => array('zimmer'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'wohnungTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wohnungTyp'],
            'inputType'                 => 'select',
            'options'                   => array('dachgeschoss', 'maisonette', 'loft-studio-atelier', 'penthouse', 'terrassen', 'etage', 'erdgeschoss', 'souterrain', 'apartment', 'ferienwohnung', 'galerie', 'rohdachboden', 'attikawohnung', 'keine_angabe'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'hausTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hausTyp'],
            'inputType'                 => 'select',
            'options'                   => array('reihenhaus','reihenend','reihenmittel','reiheneck','doppelhaushaelfte','einfamilienhaus','stadthaus','bungalow','villa','resthof','bauernhaus','landhaus','schloss','zweifamilienhaus','mehrfamilienhaus','ferienhaus','berghuette','chalet','strandhaus','laube-datsche-gartenhaus','apartmenthaus','burg','herrenhaus','finca','rustico','fertighaus','keine_angabe'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'grundstTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['grundstTyp'],
            'inputType'                 => 'select',
            'options'                   => array('wohnen','gewerbe','industrie','land_forstwirschaft','freizeit','gemischt','gewerbepark','sondernutzung','seeliegenschaft'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'bueroTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bueroTyp'],
            'inputType'                 => 'select',
            'options'                   => array('bueroflaeche','buerohaus','buerozentrum','loft_atelier','praxis','praxisflaeche','praxishaus','ausstellungsflaeche','coworking','shared_office'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'handelTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['handelTyp'],
            'inputType'                 => 'select',
            'options'                   => array('ladenlokal','einzelhandelsladen','verbrauchermarkt','einkaufszentrum','kaufhaus','factory_outlet','kiosk','verkaufsflaeche','ausstellungsflaeche'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'gastgewTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gastgewTyp'],
            'inputType'                 => 'select',
            'options'                   => array('gastronomie','gastronomie_und_wohnung','pensionen','hotels','weitere_beherbergungsbetriebe','bar','cafe','discothek','restaurant','raucherlokal','einraumlokal'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'hallenTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hallenTyp'],
            'inputType'                 => 'select',
            'options'                   => array('halle','industriehalle','lager','lagerflaechen','lager_mit_freiflaeche','hochregallager','speditionslager','produktion','werkstatt','service','freiflaechen','kuehlhaus'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'landTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['landTyp'],
            'inputType'                 => 'select',
            'options'                   => array('landwirtschaftliche_betriebe','bauernhof','aussiedlerhof','gartenbau','ackerbau','weinbau','viehwirtschaft','jagd_und_forstwirtschaft','teich_und_fischwirtschaft','scheunen','reiterhoefe','sonstige_landwirtschaftsimmobilien','anwesen','jagdrevier'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'parkenTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['parkenTyp'],
            'inputType'                 => 'select',
            'options'                   => array('stellplatz','carport','doppelgarage','duplex','tiefgarage','bootsliegeplatz','einzelgarage','parkhaus','tiefgaragenstellplatz','parkplatz_strom'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'sonstigeTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigeTyp'],
            'inputType'                 => 'select',
            'options'                   => array('parkhaus','tankstelle','krankenhaus','sonstige'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'freizeitTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['freizeitTyp'],
            'inputType'                 => 'select',
            'options'                   => array('sportanlagen', 'vergnuegungsparks_und_center', 'freizeitanlagen'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'zinsTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zinsTyp'],
            'inputType'                 => 'select',
            'options'                   => array('mehrfamilienhaus','wohn_und_geschaeftshaus','geschaeftshaus','buerogebaeude','sb_maerkte','einkaufscentren','wohnanlagen','verbrauchermaerkte','industrieanlagen','pflegeheim','sanatorium','seniorenheim','betreutes-wohnen'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),

        /**
         * Preise
         */
        'kaufpreisAufAnfrage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreisAufAnfrage'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),

        // Kaufpreis
        'kaufpreis' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>20, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'kaufpreisnetto' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreisnetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'kaufpreisbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreisbrutto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),

        // Mietpreis
        'nettokaltmiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettokaltmiete'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'kaltmiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaltmiete'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'warmmiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['warmmiete'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),

        // Freitext
        'freitextPreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['freitextPreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "varchar(20) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Zusatzkosten
        'nebenkosten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nebenkosten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'order'    => 810
            )
        ),
        'heizkosten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['heizkosten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'     => true,
                'sorting'   => true,
                'order'     => 815
            )
        ),
        'heizkostenEnthalten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['heizkostenEnthalten'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'price'     => true,
                'filter'    => true,
                'sorting'   => true,
                'order'     => 817
            )
        ),
        'heizkostennetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['heizkostennetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'     => true,
                'sorting'   => true,
                'order'     => 816
            )
        ),
        'heizkostenust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['heizkostenust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'zzgMehrwertsteuer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zzgMehrwertsteuer'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'price'     => true,
                'filter'    => true
            )
        ),
        'mietzuschlaege'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mietzuschlaege'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'     => true,
                'filter'    => true,
                'order'     => 815
            )
        ),

        // Preisergänzungen
        'hauptmietzinsnetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hauptmietzinsnetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'     => true,
                'order'     => 815
            )
        ),
        'hauptmietzinsust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hauptmietzinsust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'pauschalmiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['pauschalmiete'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'filter'   => true,
                'order'    => 800
            )
        ),
        'betriebskostennetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['betriebskostennetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'filter'   => true,
                'order'    => 820
            )
        ),
        'betriebskostenust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['betriebskostenust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'evbnetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['evbnetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'sorting'  => true,
                'filter'   => true,
                'order'    => 820
            )
        ),
        'evbust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['evbust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtmietenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtmietenetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'gesamtmieteust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtmieteust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtmietebrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtmietebrutto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'gesamtbelastungnetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtbelastungnetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'gesamtbelastungust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtbelastungust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtbelastungbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtbelastungbrutto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'gesamtkostenprom2von'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtkostenprom2von'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'gesamtkostenprom2bis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtkostenprom2bis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'monatlichekostennetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['monatlichekostennetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'monatlichekostenust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['monatlichekostenust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'monatlichekostenbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['monatlichekostenbrutto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'nebenkostenprom2von'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nebenkostenprom2von'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'nebenkostenprom2bis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nebenkostenprom2bis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'ruecklagenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ruecklagenetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'ruecklageust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ruecklageust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'sonstigekostennetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigekostennetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'sonstigekostenust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigekostenust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'sonstigemietenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigemietenetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'sonstigemieteust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigekostenust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'summemietenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ruecklagenetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'summemieteust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['summemieteust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'nettomieteprom2von'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettomieteprom2von'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'nettomieteprom2bis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettomieteprom2bis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'pacht'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['pacht'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'erbpacht'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erbpacht'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'hausgeld'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hausgeld'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 820
            )
        ),
        'abstand'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['abstand'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 820
            )
        ),
        'preisZeitraumVon'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['preisZeitraumVon'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 820
            )
        ),
        'preisZeitraumBis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['preisZeitraumBis'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 820
            )
        ),
        'preisZeiteinheit'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['preisZeiteinheit'],
            'inputType'                 => 'select',
            'options'                   => array('tag', 'woche', 'monat', 'jahr'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 820
            )
        ),
        'mietpreisProQm'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mietpreisProQm'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'kaufpreisProQm'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreisProQm'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 800
            )
        ),
        'provisionspflichtig'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionspflichtig'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 825
            )
        ),
        'provisionTeilen'  => array // ToDo: Feld kann nicht eindeutig zugeordnet werden. Ist ein Boolean, scheinbar aber auch ein String.
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionTeilen'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'provisionTeilenWert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionTeilenWert'],
            'inputType'                 => 'select',
            'options'                   => array('absolut','prozent','text'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'innenCourtage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['innenCourtage'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 32, 'tl_class' => 'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'innenCourtageMwst'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['innenCourtageMwst'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),
        'aussenCourtage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aussenCourtage'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 32, 'tl_class' => 'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'courtageHinweis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['courtageHinweis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 128, 'tl_class' => 'w50'),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'aussenCourtageMwst'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aussenCourtageMwst'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'provisionnetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionnetto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'provisionust'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionust'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'provisionbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionbrutto'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'waehrung'  => array // ToDo: Select -> Alle Währungen
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['waehrung'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "varchar(20) NOT NULL default ''",
        ),
        'mwstSatz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mwstSatz'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'mwstGesamt'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mwstGesamt'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'xFache'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['xFache'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "varchar(20) NOT NULL default ''"
        ),
        'nettorendite'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettorendite'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'nettorenditeSoll'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettorenditeSoll'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'nettorenditeIst'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettorenditeIst'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'mieteinnahmenIst'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mieteinnahmenIst'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'mieteinnahmenIstPeriode'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mieteinnahmenIstPeriode'],
            'inputType'                 => 'select',
            'options'                   => array('tag','woche','monat','jahr'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'mieteinnahmenSoll'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mieteinnahmenSoll'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'mieteinnahmenSollPeriode'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mieteinnahmenSollPeriode'],
            'inputType'                 => 'select',
            'options'                   => array('tag','woche','monat','jahr'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'erschliessungskosten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erschliessungskosten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 825
            )
        ),
        'kaution'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaution'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'kautionText'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kautionText'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "varchar(20) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 831
            )
        ),
        'geschaeftsguthaben'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['geschaeftsguthaben'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'richtpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['richtpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'richtpreisprom2'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['richtpreisprom2'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),

        /**
         * Stellplätze
         */
        // Carport
        'stpCarport'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpCarport'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpCarportMietpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpCarportMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpCarportKaufpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpCarportKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Duplex
        'stpDuplex'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpDuplex'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpDuplexMietpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpDuplexMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpDuplexKaufpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpDuplexKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Freiplatz
        'stpFreiplatz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpFreiplatz'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpFreiplatzMietpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpFreiplatzMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpFreiplatzKaufpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpFreiplatzKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Garage
        'stpGarage'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpGarage'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpGarageMietpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpGarageMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpGarageKaufpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpGarageKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Parkhaus
        'stpParkhaus'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpParkhaus'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpParkhausMietpreis'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpParkhausMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpParkhausKaufpreis'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpParkhausKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Tiefgarage
        'stpTiefgarage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpTiefgarage'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpTiefgarageMietpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpTiefgarageMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpTiefgarageKaufpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpTiefgarageKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Sonstige
        'stpSonstige'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpSonstige'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'stellplatz',
                'detail'    => true
            )
        ),
        'stpSonstigeMietpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpSonstigeMietpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpSonstigeKaufpreis'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpSonstigeKaufpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),
        'stpSonstigePlatzart'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpSonstigePlatzart'],
            'inputType'                 => 'select',
            'options'                   => array('freiplatz','garage','tiefgarage','carport','duplex','parkhaus','sonstiges'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'stpSonstigeBemerkung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpSonstigeBemerkung'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),

        /**
         * Geo / Adressinformationen
         */
        'plz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['plz'],
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(8) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 200
            )
        ),
        'ort'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ort'],
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 201
            )
        ),
        'strasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['strasse'],
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 203
            )
        ),
        'hausnummer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hausnummer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 204
            )
        ),
        'breitengrad'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['breitengrad'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'laengengrad'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['laengengrad'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'bundesland'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bundesland'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 210
            )
        ),
        'land'  => array // ToDo: Isokürzel als Selectfeld
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['land'],
            'inputType'                 => 'text',
            'filter'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'address'  => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 210
            )
        ),
        'flur'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['flur'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'flurstueck'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['flurstueck'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'gemarkung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gemarkung'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'etage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['etage'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>8, 'tl_class'=>'w50'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'filter'   => true,
                'detail'   => true,
                'order'    => 450
            )
        ),
        'anzahlEtagen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlEtagen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "int(8) NULL default NULL",
            'realEstate'                => array(
                'filter'   => true,
                'detail'   => true,
                'order'    => 450
            )
        ),
        'lageImBau'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['lageImBau'],
            'inputType'                 => 'select',
            'options'                   => array('links','rechts','vorne','hinten'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter'   => true,
                'detail'   => true
            )
        ),
        'wohnungsnr'  => array // ToDo: Bei Adressfreigabe falls vohanden aufnehmen?!
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wohnungsnr'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 210
            )
        ),
        'lageGebiet'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['lageGebiet'],
            'inputType'                 => 'select',
            'options'                   => array('wohn','gewerbe','industrie','misch','neubau','ortslage','siedlung','stadtrand','stadtteil','stadtzentrum','nebenzentrum','1a','1b'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'gemeindecode'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gemeindecode'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'regionalerZusatz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['regionalerZusatz'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'address' => true,
                'order'   => 202
            )
        ),
        'kartenMakro'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kartenMakro'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'kartenMikro'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kartenMikro'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''",
        ),
        'virtuelletour'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['virtuelletour'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''",
            'realEstate'                => array(
                'filter'    => true,
                'sorting'   => true,
                'attribute' => true
            )
        ),
        'luftbildern'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['luftbildern'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''",
            'realEstate'                => array(
                'attribute' => true
            )
        ),

        /**
         * Freitexte
         */
        'objekttitel'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objekttitel'],
            'inputType'                 => 'text',
            'search'                    => true,
            'flag'                      => 1,
            'eval'                      => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=> 'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'dreizeiler'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['dreizeiler'],
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
        ),
        'lage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['lage'],
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
        ),
        'ausstattBeschr'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ausstattBeschr'],
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
        ),
        'objektbeschreibung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektbeschreibung'],
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
        ),
        'sonstigeAngaben'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigeAngaben'],
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
        ),
        'objektText'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektText'],
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
        ),

        /**
         * Bieterverfahren
         */
        'beginnAngebotsphase'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['beginnAngebotsphase'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'bieterverfahren',
                'detail'    => true
            )
        ),
        'besichtigungstermin'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['besichtigungstermin'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'bieterverfahren',
                'detail'    => true
            )
        ),
        'besichtigungstermin2'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['besichtigungstermin2'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'bieterverfahren',
                'detail'    => true
            )
        ),
        'beginnBietzeit'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['beginnBietzeit'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'datim', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'bieterverfahren',
                'detail'    => true
            )
        ),
        'endeBietzeit'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['endeBietzeit'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'bieterverfahren',
                'detail'    => true
            )
        ),
        'hoechstgebotZeigen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hoechstgebotZeigen'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'bieterverfahren'
            )
        ),
        'mindestpreis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mindestpreis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'bieterverfahren',
                'detail'    => true
            )
        ),

        /**
         * Versteigerung
         */
        'zwangsversteigerung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zwangsversteigerung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class'=>'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'versteigerung',
                'detail'    => true,
                'attribute' => true,
                'filter'    => true,
                'sorting'   => true
            )
        ),
        'aktenzeichen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aktenzeichen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'versteigerung',
                'detail'    => true
            )
        ),
        'zvtermin'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zvtermin'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'datim', 'tl_class'=> 'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'versteigerung',
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'zusatztermin'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zusatztermin'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'datim', 'tl_class'=> 'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'versteigerung',
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'amtsgericht'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['amtsgericht'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'versteigerung'
            )
        ),
        'verkehrswert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verkehrswert'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'group'     => 'versteigerung'
            )
        ),

        /**
         * Flächen
         */
        'wohnflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wohnflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'nutzflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nutzflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'gesamtflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'ladenflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ladenflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'lagerflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['lagerflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'verkaufsflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verkaufsflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'freiflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['freiflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'bueroflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bueroflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'bueroteilflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bueroteilflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'fensterfront'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['fensterfront'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'order'    => 300
            )
        ),
        'verwaltungsflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verwaltungsflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'gastroflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gastroflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'grz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['grz'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'gfz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gfz'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'bmz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bmz'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'bgf'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bgf'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'grundstuecksflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['grundstuecksflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'sonstflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'anzahlZimmer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlZimmer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlSchlafzimmer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlSchlafzimmer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlBadezimmer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlBadezimmer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlSepWc'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlSepWc'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlBalkone'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlBalkone'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'group'    => 'balkon_terrassen',
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlTerrassen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlTerrassen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'group'    => 'balkon_terrassen',
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlLogia'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlLogia'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'balkonTerrasseFlaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['balkonTerrasseFlaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'anzahlWohnSchlafzimmer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlWohnSchlafzimmer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'gartenflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gartenflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'kellerflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kellerflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 300
            )
        ),
        'fensterfrontQm'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['fensterfrontQm'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'order'    => 300
            )
        ),
        'grundstuecksfront'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['grundstuecksfront'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'order'    => 300
            )
        ),
        'dachbodenflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['dachbodenflaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'order'    => 300
            )
        ),
        'teilbarAb'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['teilbarAb'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'  => true,
                'filter'  => true,
                'order'   => 300
            )
        ),
        'beheizbareFlaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['beheizbareFlaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'order'    => 300
            )
        ),
        'anzahlStellplaetze'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlStellplaetze'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'plaetzeGastraum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['plaetzeGastraum'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlBetten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlBetten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlTagungsraeume'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlTagungsraeume'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'vermietbareFlaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermietbareFlaeche'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlWohneinheiten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlWohneinheiten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'anzahlGewerbeeinheiten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['anzahlGewerbeeinheiten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'einliegerwohnung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['einliegerwohnung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'attribute'=> true,
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'kubatur'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kubatur'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'ausnuetzungsziffer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ausnuetzungsziffer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'flaechevon'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['flaechevon'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),
        'flaechebis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['flaechebis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'area'     => true,
                'filter'   => true,
                'sorting'  => true,
                'order'    => 400
            )
        ),

        /**
         * Ausstattung
         */
        'ausstattKategorie' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ausstattKategorie'],
            'inputType'                 => 'select',
            'options'                   => array('standard', 'gehoben', 'luxus'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'wgGeeignet' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wgGeeignet'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true,
                'sorting'   => true,
            )
        ),
        'raeumeVeraenderbar' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['raeumeVeraenderbar'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'bad' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bad'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('dusche', 'wanne', 'fenster', 'bidet', 'pissoir'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true, 'tl_class'=>'w50 clr'),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true,
                'order'     => 600
            )
        ),
        'kueche' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kueche'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('ebk', 'offen', 'pantry'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true,
                'order'     => 600
            )
        ),
        'boden' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['boden'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('fliesen', 'stein', 'teppich', 'parkett', 'fertigparkett', 'laminat', 'dielen', 'kunststoff', 'estrich', 'doppelboden', 'linoleum', 'marmor', 'terrakotta', 'granit'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'attribute' => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'kamin' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kamin'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'heizungsart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['heizungsart'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('ofen', 'etage', 'zentral', 'fern', 'fussboden'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'befeuerung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['befeuerung'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('oel', 'gas', 'elektro', 'alternativ', 'solar','erdwaerme','luftwp','fern','block','wasser-elektro','pellet','kohle','holz','fluessiggas'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'klimatisiert' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['klimatisiert'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'fahrstuhlart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['fahrstuhlart'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('personen', 'lasten'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'stellplatzart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stellplatzart'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('garage', 'tiefgarage', 'carport', 'freiplatz', 'parkhaus','duplex'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'gartennutzung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gartennutzung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'm12 w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'ausrichtBalkonTerrasse' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ausrichtBalkonTerrasse'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('nord', 'ost', 'sued', 'west', 'nordost','nordwest','suedost','suedwest'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'   => true
            )
        ),
        'moebliert' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['moebliert'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('voll', 'teil'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'rollstuhlgerecht' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['rollstuhlgerecht'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'kabelSatTv' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kabelSatTv'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'dvbt' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['dvbt'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'barrierefrei' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['barrierefrei'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'sauna' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sauna'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'swimmingpool' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['swimmingpool'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'waschTrockenraum' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['waschTrockenraum'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'wintergarten' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wintergarten'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'dvVerkabelung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['dvVerkabelung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'rampe' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['rampe'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'hebebuehne' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hebebuehne'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'kran' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kran'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'gastterrasse' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gastterrasse'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'stromanschlusswert' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stromanschlusswert'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'    => true
            )
        ),
        'kantineCafeteria' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kantineCafeteria'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'teekueche' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['teekueche'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'hallenhoehe' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hallenhoehe'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'    => true,
                'filter'   => true
            )
        ),
        'angeschlGastronomie' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['angeschlGastronomie'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('hotelrestaurant', 'bar'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'brauereibindung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['brauereibindung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'sporteinrichtungen' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sporteinrichtungen'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'wellnessbereich' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wellnessbereich'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'   => true
            )
        ),
        'serviceleistungen' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['serviceleistungen'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('betreutes_wohnen', 'catering', 'reinigung', 'einkauf', 'wachdienst'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'   => true
            )
        ),
        'telefonFerienimmobilie' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['telefonFerienimmobilie'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'breitbandZugang' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['breitbandZugang'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'breitbandGeschw' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['breitbandGeschw'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'    => true,
                'filter'    => true,
                'sorting'   => true
            )
        ),
        'breitbandArt' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['breitbandArt'],
            'inputType'                 => 'select',
            'options'                   => array('DSL', 'SDSL', 'VDSL', 'ADSL', 'SKYDSL', 'IPTV'),
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'umtsEmpfang' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['umtsEmpfang'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true,
                'sorting'   => true,
            )
        ),
        'sicherheitstechnik' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sicherheitstechnik'],
            'inputType'                 => 'checkboxWizard',
            'options'                   => array('alarmanlage', 'kamera', 'polizeiruf'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'attribute' => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'unterkellert' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['unterkellert'],
            'inputType'                 => 'select',
            'options'                   => array('ja', 'nein', 'teil'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'abstellraum' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['abstellraum'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'fahrradraum' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['fahrradraum'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'rolladen' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['rolladen'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'bibliothek' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bibliothek'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'dachboden' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['dachboden'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'gaestewc' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gaestewc'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'kabelkanaele' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kabelkanaele'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'seniorengerecht' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['seniorengerecht'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),

        /**
         * Zustand Angaben
         */
        'baujahr'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['baujahr'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'    => true,
                'sorting'   => true,
                'order'     => 500
            )
        ),
        'letztemodernisierung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['letztemodernisierung'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'detail'   => true,
                'order'    => 500
            )
        ),
        'zustand' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zustand'],
            'inputType'                 => 'select',
            'options'                   => array('erstbezug','teil_vollrenovierungsbed','neuwertig','teil_vollsaniert','teil_vollrenoviert','teil_saniert','voll_saniert','sanierungsbeduerftig','baufaellig','nach_vereinbarung','modernisiert','gepflegt','rohbau','entkernt','abrissobjekt','projektiert'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'alterAttr' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['alter'],
            'inputType'                 => 'select',
            'options'                   => array('altbau','neubau'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'bebaubarNach' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bebaubarNach'],
            'inputType'                 => 'select',
            'options'                   => array('34_nachbarschaft','35_aussengebiet','b_plan','kein_bauland','bauerwartungsland','laenderspezifisch','bauland_ohne_b_plan'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'erschliessung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erschliessung'],
            'inputType'                 => 'select',
            'options'                   => array('unerschlossen','teilerschlossen','vollerschlossen','ortsueblicherschlossen'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'erschliessungUmfang' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erschliessungUmfang'],
            'inputType'                 => 'select',
            'options'                   => array('gas','wasser','strom','tk'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'bauzone'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bauzone'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'altlasten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['altlasten'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'verkaufstatus' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verkaufstatus'],
            'inputType'                 => 'select',
            'options'                   => array('offen','reserviert','verkauft'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'filter'   => true
            )
        ),

        /**
         * Infrastruktur
         */
        'zulieferung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zulieferung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true,
                'sorting'   => true,
            )
        ),
        'ausblick' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ausblick'],
            'inputType'                 => 'select',
            'options'                   => array('ferne','see','berge','meer'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'distanzFlughafen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzFlughafen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzFernbahnhof'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzFernbahnhof'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzAutobahn'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzAutobahn'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzUsBahn'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzUsBahn'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzBus'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzBus'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzKindergarten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzKindergarten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGrundschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGrundschule'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzHauptschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzHauptschule'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzRealschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzRealschule'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGesamtschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGesamtschule'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGymnasium'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGymnasium'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzZentrum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzZentrum'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzEinkaufsmoeglichkeiten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzEinkaufsmoeglichkeiten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGaststaetten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGaststaetten'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportStrand'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportStrand'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSee'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportSee'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportMeer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportMeer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSkigebiet'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportSkigebiet'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSportanlagen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportSportanlagen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportWandergebiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportWandergebiete'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportNaherholung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportNaherholung'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distanz',
                'filter'   => true,
                'sorting'  => true
            )
        ),

        /**
         * Energiepass
         */
        'energiepassEpart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassEpart'],
            'inputType'                 => 'select',
            'options'                   => array('bedarf','verbrauch'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassGueltigBis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassGueltigBis'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassEnergieverbrauchkennwert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassEnergieverbrauchkennwert'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassMitwarmwasser'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassMitwarmwasser'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassEndenergiebedarf'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassEndenergiebedarf'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassPrimaerenergietraeger'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassPrimaerenergietraeger'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassStromwert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassStromwert'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassWaermewert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassWaermewert'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassWertklasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassWertklasse'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassBaujahr'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassBaujahr'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassAusstelldatum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassAusstelldatum'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassJahrgang' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassJahrgang'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''"
        ),
        'energiepassGebaeudeart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassGebaeudeart'],
            'inputType'                 => 'select',
            'options'                   => array('wohn','nichtwohn'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassEpasstext'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassEpasstext'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassHwbwert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassHwbwert'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassHwbklasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassHwbklasse'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassFgeewert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassFgeewert'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassFgeeklasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassFgeeklasse'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),

        /**
         * Verwaltung Objekt
         */
        'objektadresseFreigeben'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektadresseFreigeben'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'verfuegbarAb'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verfuegbarAb'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'abdatum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['abdatum'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'bisdatum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bisdatum'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'minMietdauer' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['minMietdauer'],
            'inputType'                 => 'select',
            'options'                   => array('tag','woche','monat','jahr'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'maxMietdauer' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['maxMietdauer'],
            'inputType'                 => 'select',
            'options'                   => array('tag','woche','monat','jahr'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'versteigerungstermin'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['versteigerungstermin'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'sorting'  => true,
                'order'    => 500
            )
        ),
        'wbsSozialwohnung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wbsSozialwohnung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'vermietet'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermietet'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),
        'gruppennummer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gruppennummer'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''"
        ),
        'zugang'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zugang'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'laufzeit'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['laufzeit'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'maxPersonen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['maxPersonen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>10, 'tl_class'=>'w50'),
            'sql'                       => "int(10) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'nichtraucher'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nichtraucher'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'haustiere'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['haustiere'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'   => true
            )
        ),
        'geschlecht' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['geschlecht'],
            'inputType'                 => 'select',
            'options'                   => array('egal','nur_mann','nur_frau'),
            'reference'                 => &$GLOBALS['TL_LANG']['tl_real_estate'],
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'   => true
            )
        ),
        'denkmalgeschuetzt'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['denkmalgeschuetzt'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'alsFerien'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['alsFerien'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'gewerblicheNutzung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gewerblicheNutzung'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'branchen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['branchen'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'hochhaus'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hochhaus'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),

        /**
         * Verwaltung Tech
         */
        'objektnrIntern'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektnrIntern'],
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'unique' => true
            )
        ),
        'objektnrExtern'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektnrExtern'],
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'unique' => true
            )
        ),
        'aktivVon'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aktivVon'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'aktivBis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aktivBis'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'openimmoObid'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['openimmoObid'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
        ),
        'kennungUrsprung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kennungUrsprung'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'standVom'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['standVom'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "int(10) unsigned NOT NULL default '0'",
        ),
        'weitergabeGenerell'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['weitergabeGenerell'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'weitergabePositiv'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['weitergabePositiv'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'weitergabeNegativ'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['weitergabeNegativ'],
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'sprache' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sprache'],
            'inputType'                 => 'text',
            'filter'                    => true,
            'eval'                      => array('maxlength'=>5, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
        ),

        /**
         * Bilder
         */
        'titleImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['titleImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'imageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['imageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'planImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['planImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'interiorViewImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['interiorViewImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'exteriorViewImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['exteriorViewImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'mapViewImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['mapViewImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'panoramaImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['panoramaImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'epassSkalaImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['epassSkalaImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'logoImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['logoImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'qrImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['qrImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),

        /**
         * Documents
         */
        'documents' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['documents'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),

        /**
         * Links
         */
        'links' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['links'],
            'inputType'               => 'listWizard',
            'exclude'                 => true,
            'eval'                    => array('tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'medien'
            )
        ),
        'anbieterobjekturl' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['anbieterobjekturl'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'eval'                    => array('tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),

        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['published'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'w50 m12 clr'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_real_estate extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Check permissions to edit table tl_real_estate
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Auto-generate a real estate alias if it has not been set yet
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     * @param string        $title
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias($varValue, $dc, $title='')
    {
        // Generate alias if there is none
        if ($varValue == '')
        {
            $title = $dc->activeRecord !== null ? $dc->activeRecord->objekttitel : $title;
            $varValue = System::getContainer()->get('contao.slug.generator')->generate($title);
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_real_estate WHERE alias=? AND id!=?")
            ->execute($varValue, $dc->id);

        // Check whether the real estate alias exists
        if ($objAlias->numRows)
        {
            $varValue .= '-' . $dc->id;
        }

        return $varValue;
    }

    /**
     * Return the edit header button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function editHeader($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_real_estate') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the copy real estate button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function copyRealEstate($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('create', 'provider') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the delete real estate button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function deleteRealEstate($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'provider') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return all provider as array
     *
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getContactPerson(DataContainer $dc)
    {
        $objContactPersons = $this->Database->prepare("SELECT id, name, vorname FROM tl_contact_person WHERE pid=?")->execute($dc->activeRecord->provider);

        if ($objContactPersons->numRows < 1)
        {
            return array();
        }

        $arrContactPersons = array();

        while ($objContactPersons->next())
        {
            $arrContactPersons[$objContactPersons->id] = $objContactPersons->vorname . ' ' . $objContactPersons->name;
        }

        return $arrContactPersons;
    }

    /**
     * Return all provider as array
     *
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getAllProvider(DataContainer $dc)
    {
        $objProviders = $this->Database->execute("SELECT id, anbieternr, firma FROM tl_provider");

        if ($objProviders->numRows < 1)
        {
            return array();
        }

        $arrProviders = array();

        while ($objProviders->next())
        {
            $arrProviders[$objProviders->id] = $objProviders->firma;
        }

        return $arrProviders;
    }

    /**
     * Return the "toggle visibility" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (\strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->hasAccess('tl_real_estate::published', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
    }

    /**
     * Toggle the visibility of a real estate property
     *
     * @param integer       $intId
     * @param boolean       $blnVisible
     * @param DataContainer $dc
     */
    public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        // Trigger the onload_callback
        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['config']['onload_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (\is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        // Check the field access
        if (!$this->User->hasAccess('tl_real_estate::published', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish provider ID ' . $intId . '.');
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_real_estate WHERE id=?")
                ->limit(1)
                ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $objVersions = new Versions('tl_real_estate', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['name']['fields']['published']['save_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (\is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $dc);
                }
            }
        }

        $time = time();

        // Update the database
        $this->Database->prepare("UPDATE tl_real_estate SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['config']['onsubmit_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['config']['onsubmit_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (\is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        $objVersions->create();
    }

    /**
     * Add an image to each record
     *
     * @param array         $row
     * @param string        $label
     * @param DataContainer $dc
     * @param array         $args
     *
     * @return array
     */
    public function addPreviewImageAndInformation($row, $label, DataContainer $dc, $args)
    {
        $objFile = null;

        if ($row['titleImageSRC'] != '') {
            $objFile = \FilesModel::findByUuid($row['titleImageSRC']);
        }

        if ($objFile === null && \Config::get('defaultImage'))
        {
            $objFile = \FilesModel::findByUuid(\Config::get('defaultImage'));
        }

        if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path))
        {
            // add preview image
            $args[0] = \Image::getHtml(\System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/' . $objFile->path, array(75, 50, 'center_top'))->getUrl(TL_ROOT), '', 'class="estate_preview"') . ' ' . $label;
        }

        // add external and internal objektnr
        $args[1] = '<span style="display:block;margin-top:5px">ID: <span style="">'. $args[1] . '</span></span>';
        if ($row['objektnrIntern'])
        {
            $args[1] .= '<span style="display:block;margin-top:5px">Intern: <span style="color:#999">' . $row['objektnrIntern'] . '</span></span>';
        }
        if ($row['objektnrExtern'])
        {
            $args[1] .= '<span style="display:block;margin-top:5px">Extern: <span style="color:#999">' . $row['objektnrExtern'] . '</span></span>';
        }

        // add address information
        $args[2] .= '<span style="color:#999;display:block;margin-top:5px">' . $row['plz'] . ' ' . $row['ort'] . ' · ' . $row['strasse'] . ' ' . $row['hausnummer'] . '</span>';

        // translate date
        $args[5] = date(\Config::get('datimFormat'), $args[5]);

        // Call post_label_callbacks ($row, $label, $dc, $args)
        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks'] as $callback)
            {
                $strClass = $callback[0];
                $strMethod = $callback[1];

                $this->import($strClass);
                $args = $this->$strClass->$strMethod($row, $label, $dc, $args);
            }
        }

        return $args;
    }

}
