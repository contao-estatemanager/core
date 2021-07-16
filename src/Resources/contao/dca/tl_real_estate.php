<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// load real estate value language file
Contao\System::loadLanguageFile('tl_real_estate_value');
Contao\System::loadLanguageFile('tl_real_estate_label');

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
            'fields'                  => array('tstamp DESC'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,sort,limit'
        ),
        'label' => array
        (
            'fields'                  => array('id', 'objekttitel', 'objektart', 'nutzungsart', 'dateAdded', 'tstamp'),
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
                                         '{real_estate_meta_legend},metaTitle,robots,metaDescription,serpPreview;'.
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
            'sorting'                 => true,
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['tstamp'],
            'sorting'                 => true,
            'flag'                    => 2,
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
            'search'                  => true,
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
            'filter'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_real_estate', 'getAllProvider'),
            'eval'                    => array('submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'foreignKey'              => 'tl_provider.firma',
            'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),
            'sql'                     => "varchar(32) NOT NULL default ''",
        ),
        'contactPerson' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['contactPerson'],
            'exclude'                 => true,
            'filter'                  => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'filter'                    => true,
            'options'                   => array
            (
                'wohnen'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_wohnen'],
                'gewerbe' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_gewerbe'],
                'anlage'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_anlage'],
                'waz'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_waz']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(7) NOT NULL default ''",
            'realEstate'                => array(
                'detail'  => true,
                'order'   => 100
            )
        ),
        'vermarktungsartKauf'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['vermarktungsartKauf'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                   => true,
            'inputType'                 => 'select',
            'filter'                    => true,
            'options'                   => array
            (
                'zimmer'                        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_zimmer'],
                'wohnung'                       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_wohnung'],
                'haus'                          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_haus'],
                'grundstueck'                   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_grundstueck'],
                'buero_praxen'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_buero_praxen'],
                'einzelhandel'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_einzelhandel'],
                'gastgewerbe'                   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_gastgewerbe'],
                'hallen_lager_prod'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_hallen_lager_prod'],
                'land_und_forstwirtschaft'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_land_und_forstwirtschaft'],
                'parken'                        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_parken'],
                'sonstige'                      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_sonstige'],
                'freizeitimmobilie_gewerblich'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_freizeitimmobilie_gewerblich'],
                'zinshaus_renditeobjekt'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['objektart_zinshaus_renditeobjekt']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(28) NOT NULL default ''",
            'realEstate'                => array(
                'detail'  => true,
                'order'   => 100
            )
        ),

        // Objekttypen
        'zimmerTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zimmerTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'zimmer'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zimmerTyp_zimmer'],
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'wohnungTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wohnungTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'dachgeschoss'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_dachgeschoss'],
                'maisonette'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_maisonette'],
                'loft-studio-atelier'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_loft-studio-atelier'],
                'penthouse'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_penthouse'],
                'terrassen'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_terrassen'],
                'etage'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_etage'],
                'erdgeschoss'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_erdgeschoss'],
                'souterrain'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_souterrain'],
                'apartment'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_apartment'],
                'ferienwohnung'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_ferienwohnung'],
                'galerie'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_galerie'],
                'rohdachboden'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_rohdachboden'],
                'attikawohnung'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_attikawohnung'],
                'keine_angabe'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['wohnungTyp_keine_angabe']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(19) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'hausTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hausTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'reihenhaus'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_reihenhaus'],
                'reihenend'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_reihenend'],
                'reihenmittel'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_reihenmittel'],
                'reiheneck'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_reiheneck'],
                'doppelhaushaelfte'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_doppelhaushaelfte'],
                'einfamilienhaus'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_einfamilienhaus'],
                'stadthaus'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_stadthaus'],
                'bungalow'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_bungalow'],
                'villa'                     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_villa'],
                'resthof'                   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_resthof'],
                'bauernhaus'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_bauernhaus'],
                'landhaus'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_landhaus'],
                'schloss'                   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_schloss'],
                'zweifamilienhaus'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_zweifamilienhaus'],
                'mehrfamilienhaus'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_mehrfamilienhaus'],
                'ferienhaus'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_ferienhaus'],
                'berghuette'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_berghuette'],
                'chalet'                    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_chalet'],
                'strandhaus'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_strandhaus'],
                'laube-datsche-gartenhaus'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_laube-datsche-gartenhaus'],
                'apartmenthaus'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_apartmenthaus'],
                'burg'                      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_burg'],
                'herrenhaus'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_herrenhaus'],
                'finca'                     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_finca'],
                'rustico'                   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_rustico'],
                'fertighaus'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_fertighaus'],
                'keine_angabe'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hausTyp_keine_angabe']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(24) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'grundstTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['grundstTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'wohnen'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_wohnen'],
                'gewerbe'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_gewerbe'],
                'industrie'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_industrie'],
                'land_forstwirschaft'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_land_forstwirschaft'],
                'freizeit'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_freizeit'],
                'gemischt'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_gemischt'],
                'gewerbepark'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_gewerbepark'],
                'sondernutzung'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_sondernutzung'],
                'seeliegenschaft'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['grundstTyp_seeliegenschaft']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(19) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'bueroTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bueroTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'bueroflaeche'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_bueroflaeche'],
                'buerohaus'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_buerohaus'],
                'buerozentrum'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_buerozentrum'],
                'loft_atelier'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_loft_atelier'],
                'praxis'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_praxis'],
                'praxisflaeche'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_praxisflaeche'],
                'praxishaus'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_praxishaus'],
                'ausstellungsflaeche'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_ausstellungsflaeche'],
                'coworking'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_coworking'],
                'shared_office'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bueroTyp_shared_office']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(19) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'handelTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['handelTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'ladenlokal'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_ladenlokal'],
                'einzelhandelsladen'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_einzelhandelsladen'],
                'verbrauchermarkt'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_verbrauchermarkt'],
                'einkaufszentrum'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_einkaufszentrum'],
                'kaufhaus'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_kaufhaus'],
                'factory_outlet'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_factory_outlet'],
                'kiosk'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_kiosk'],
                'verkaufsflaeche'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_verkaufsflaeche'],
                'ausstellungsflaeche'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['handelTyp_ausstellungsflaeche']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(19) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'gastgewTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gastgewTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'gastronomie'                   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_gastronomie'],
                'gastronomie_und_wohnung'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_gastronomie_und_wohnung'],
                'pensionen'                     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_pensionen'],
                'hotels'                        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_hotels'],
                'weitere_beherbergungsbetriebe' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_weitere_beherbergungsbetriebe'],
                'bar'                           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_bar'],
                'cafe'                          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_cafe'],
                'discothek'                     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_discothek'],
                'restaurant'                    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_restaurant'],
                'raucherlokal'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_raucherlokal'],
                'einraumlokal'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['gastgewTyp_einraumlokal']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(29) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'hallenTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hallenTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'halle'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_halle'],
                'industriehalle'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_industriehalle'],
                'lager'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_lager'],
                'lagerflaechen'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_lagerflaechen'],
                'lager_mit_freiflaeche' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_lager_mit_freiflaeche'],
                'hochregallager'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_hochregallager'],
                'speditionslager'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_speditionslager'],
                'produktion'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_produktion'],
                'werkstatt'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_werkstatt'],
                'service'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_service'],
                'freiflaechen'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_freiflaechen'],
                'kuehlhaus'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['hallenTyp_kuehlhaus']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(21) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'landTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['landTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'landwirtschaftliche_betriebe'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_landwirtschaftliche_betriebe'],
                'bauernhof'                             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_bauernhof'],
                'aussiedlerhof'                         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_aussiedlerhof'],
                'gartenbau'                             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_gartenbau'],
                'ackerbau'                              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_ackerbau'],
                'weinbau'                               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_weinbau'],
                'viehwirtschaft'                        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_viehwirtschaft'],
                'jagd_und_forstwirtschaft'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_jagd_und_forstwirtschaft'],
                'teich_und_fischwirtschaft'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_teich_und_fischwirtschaft'],
                'scheunen'                              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_scheunen'],
                'reiterhoefe'                           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_reiterhoefe'],
                'sonstige_landwirtschaftsimmobilien'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_sonstige_landwirtschaftsimmobilien'],
                'anwesen'                               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_anwesen'],
                'jagdrevier'                            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['landTyp_jagdrevier']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(34) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'parkenTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['parkenTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'stellplatz'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_stellplatz'],
                'carport'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_carport'],
                'doppelgarage'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_doppelgarage'],
                'duplex'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_duplex'],
                'tiefgarage'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_tiefgarage'],
                'bootsliegeplatz'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_bootsliegeplatz'],
                'einzelgarage'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_einzelgarage'],
                'parkhaus'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_parkhaus'],
                'tiefgaragenstellplatz' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_tiefgaragenstellplatz'],
                'parkplatz_strom'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['parkenTyp_parkplatz_strom']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(21) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'sonstigeTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigeTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'parkhaus'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sonstigeTyp_parkhaus'],
                'garagen'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sonstigeTyp_garagen'],
                'tankstelle'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sonstigeTyp_tankstelle'],
                'krankenhaus'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sonstigeTyp_krankenhaus'],
                'sonstige'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sonstigeTyp_sonstige']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(11) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'freizeitTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['freizeitTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'sportanlagen'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['freizeitTyp_sportanlagen'],
                'vergnuegungsparks_und_center'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['freizeitTyp_vergnuegungsparks_und_center'],
                'freizeitanlagen'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['freizeitTyp_freizeitanlagen']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(28) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'zinsTyp' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zinsTyp'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'mehrfamilienhaus'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_mehrfamilienhaus'],
                'wohn_und_geschaeftshaus'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_wohn_und_geschaeftshaus'],
                'geschaeftshaus'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_geschaeftshaus'],
                'buerogebaeude'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_buerogebaeude'],
                'sb_maerkte'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_sb_maerkte'],
                'einkaufscentren'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_einkaufscentren'],
                'wohnanlagen'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_wohnanlagen'],
                'verbrauchermaerkte'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_verbrauchermaerkte'],
                'industrieanlagen'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_industrieanlagen'],
                'pflegeheim'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_pflegeheim'],
                'sanatorium'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_sanatorium'],
                'seniorenheim'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_seniorenheim'],
                'betreutes-wohnen'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zinsTyp_betreutes-wohnen']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(23) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),

        /**
         * Meta-Data
         */
        // Meta title
        'metaTitle' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['metaTitle'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),

        // Robots-Tag
        'robots' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['robots'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('index,follow', 'index,nofollow', 'noindex,follow', 'noindex,nofollow'),
            'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''"
        ),

        // Meta description
        'metaDescription' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['metaDescription'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('style'=>'height:60px', 'decodeEntities'=>true, 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),

        // Search engine preview
        'serpPreview' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['MSC']['serpPreview'],
            'exclude'                 => true,
            'inputType'               => 'serpPreview',
            'eval'                    => array('url_callback'=>static function () { return 'http://[your-domain.com]/[alias]/'; }, 'titleFields'=>array('metaTitle', 'objekttitel'), 'descriptionFields'=>array('metaDescription', 'objektbeschreibung')),
            'sql'                     => null
        ),

        /**
         * Preise
         */
        'kaufpreisAufAnfrage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreisAufAnfrage'],
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),

        // Kaufpreis
        'kaufpreis' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kaufpreis'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Zusatzkosten
        'nebenkosten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nebenkosten'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'zzgMehrwertsteuer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zzgMehrwertsteuer'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'pauschalmiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['pauschalmiete'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'evbnetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['evbnetto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtmietenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtmietenetto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtmietebrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtmietebrutto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtbelastungbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gesamtbelastungbrutto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'monatlichekostenbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['monatlichekostenbrutto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'sonstigekostennetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigekostennetto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'sonstigemietenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigemietenetto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'summemietenetto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ruecklagenetto'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'nettomieteprom2von'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettomieteprom2von'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'tag'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['preisZeiteinheit_tag'],
                'woche' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['preisZeiteinheit_woche'],
                'monat' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['preisZeiteinheit_monat'],
                'jahr'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['preisZeiteinheit_jahr']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 820
            )
        ),
        'mietpreisProQm'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mietpreisProQm'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'absolut'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['provisionTeilenWert_absolut'],
                'prozent'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['provisionTeilenWert_prozent'],
                'text'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['provisionTeilenWert_text']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(7) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'innenCourtage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['innenCourtage'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'innenCourtageMwst'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['innenCourtageMwst'],
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),
        'aussenCourtage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aussenCourtage'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'courtageHinweis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['courtageHinweis'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'aussenCourtageMwst'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aussenCourtageMwst'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'provisionbrutto'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['provisionbrutto'],
            'exclude'                 => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "varchar(20) NOT NULL default ''",
        ),
        'mwstSatz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mwstSatz'],
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'mwstGesamt'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mwstGesamt'],
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'xFache'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['xFache'],
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "text NOT NULL default ''"
        ),
        'nettorendite'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['nettorendite'],
            'exclude'                   => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'tag'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenIstPeriode_tag'],
                'woche' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenIstPeriode_woche'],
                'monat' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenIstPeriode_monat'],
                'jahr'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenIstPeriode_jahr']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'mieteinnahmenSoll'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['mieteinnahmenSoll'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'tag'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenSollPeriode_tag'],
                'woche' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenSollPeriode_woche'],
                'monat' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenSollPeriode_monat'],
                'jahr'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['mieteinnahmenSollPeriode_jahr']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 825
            )
        ),
        'erschliessungskosten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erschliessungskosten'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 831
            )
        ),
        'geschaeftsguthaben'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['geschaeftsguthaben'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'richtpreisprom2'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['richtpreisprom2'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array(
                'freiplatz'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_freiplatz'],
                'garage'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_garage'],
                'tiefgarage'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_tiefgarage'],
                'carport'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_carport'],
                'duplex'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_duplex'],
                'parkhaus'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_parkhaus'],
                'sonstiges'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stpSonstigePlatzart_sonstiges']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''",
        ),
        'stpSonstigeBemerkung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stpSonstigeBemerkung'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),

        /**
         * Geo / Adressinformationen
         */
        'plz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['plz'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(8) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 200
            )
        ),
        'ort'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ort'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 201
            )
        ),
        'strasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['strasse'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 203
            )
        ),
        'hausnummer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hausnummer'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(14) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 204
            )
        ),
        'breitengrad'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['breitengrad'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'laengengrad'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['laengengrad'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'bundesland'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bundesland'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'order'   => 210
            )
        ),
        'land'  => array // ToDo: Isokürzel als Selectfeld
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['land'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'filter'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'filter'   => true,
                'sorting'  => true,
                'order'    => 210
            )
        ),
        'flur'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['flur'],
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'flurstueck'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['flurstueck'],
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'gemarkung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gemarkung'],
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'etage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['etage'],
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'links'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageImBau_links'],
                'rechts'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageImBau_rechts'],
                'vorne'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageImBau_vorne'],
                'hinten'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageImBau_hinten']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'filter'   => true,
                'detail'   => true
            )
        ),
        'wohnungsnr'  => array // ToDo: Bei Adressfreigabe falls vohanden aufnehmen?!
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wohnungsnr'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 210
            )
        ),
        'lageGebiet'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['lageGebiet'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'wohn'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_wohn'],
                'gewerbe'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_gewerbe'],
                'industrie'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_industrie'],
                'misch'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_misch'],
                'neubau'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_neubau'],
                'ortslage'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_ortslage'],
                'siedlung'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_siedlung'],
                'stadtrand'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_stadtrand'],
                'stadtteil'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_stadtteil'],
                'stadtzentrum'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_stadtzentrum'],
                'nebenzentrum'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_nebenzentrum'],
                '1a'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_1a'],
                '1b'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['lageGebiet_1b']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(12) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'gemeindecode'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gemeindecode'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'regionalerZusatz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['regionalerZusatz'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 202
            )
        ),
        'kartenMakro'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kartenMakro'],
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'kartenMikro'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kartenMikro'],
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''",
        ),
        'virtuelletour'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['virtuelletour'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'flag'                      => 1,
            'eval'                      => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=> 'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'objektbeschreibung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektbeschreibung'],
            'exclude'                 => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'ausstattBeschr'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['ausstattBeschr'],
            'exclude'                 => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'lage'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['lage'],
            'exclude'                 => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'sonstigeAngaben'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sonstigeAngaben'],
            'exclude'                 => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'objektText'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektText'],
            'exclude'                 => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'dreizeiler'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['dreizeiler'],
            'exclude'                 => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),

        /**
         * Bieterverfahren
         */
        'beginnAngebotsphase'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['beginnAngebotsphase'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'versteigerung',
                'detail'    => true
            )
        ),
        'zvtermin'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zvtermin'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'datim', 'tl_class'=> 'w50', 'datepicker'=>true),
            'sql'                       => "text NOT NULL default ''",
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'datim', 'tl_class'=> 'w50', 'datepicker'=>true),
            'sql'                       => "text NOT NULL default ''",
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'versteigerung'
            )
        ),
        'verkehrswert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verkehrswert'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''"
        ),
        'gfz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gfz'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''"
        ),
        'bmz'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bmz'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'bgf'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bgf'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'grundstuecksflaeche'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['grundstuecksflaeche'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'standard'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausstattKategorie_standard'],
                'gehoben'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausstattKategorie_gehoben'],
                'luxus'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausstattKategorie_luxus']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(8) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'wgGeeignet' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['wgGeeignet'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'dusche'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bad_dusche'],
                'wanne'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bad_wanne'],
                'fenster'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bad_fenster'],
                'bidet'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bad_bidet'],
                'pissoir'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bad_pissoir']
            ),
            'eval'                      => array('multiple'=>true, 'tl_class'=>'w50 clr'),
            'sql'                       => "text NOT NULL default ''",
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'ebk'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['kueche_ebk'],
                'offen'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['kueche_offen'],
                'pantry'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['kueche_pantry']
            ),
            'eval'                      => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                       => "text NOT NULL default ''",
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'fliesen'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_fliesen'],
                'stein'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_stein'],
                'teppich'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_teppich'],
                'parkett'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_parkett'],
                'fertigparkett' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_fertigparkett'],
                'laminat'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_laminat'],
                'dielen'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_dielen'],
                'kunststoff'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_kunststoff'],
                'estrich'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_estrich'],
                'doppelboden'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_doppelboden'],
                'linoleum'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_linoleum'],
                'marmor'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_marmor'],
                'terrakotta'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_terrakotta'],
                'granit'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['boden_granit']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'ofen'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['heizungsart_ofen'],
                'etage'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['heizungsart_etage'],
                'zentral'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['heizungsart_zentral'],
                'fern'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['heizungsart_fern'],
                'fussboden' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['heizungsart_fussboden']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'befeuerung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['befeuerung'],
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'oel'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_oel'],
                'gas'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_gas'],
                'elektro'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_elektro'],
                'alternativ'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_alternativ'],
                'solar'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_solar'],
                'erdwaerme'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_erdwaerme'],
                'luftwp'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_luftwp'],
                'fern'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_fern'],
                'block'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_block'],
                'wasser-elektro'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_wasser-elektro'],
                'pellet'            => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_pellet'],
                'kohle'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_kohle'],
                'holz'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_holz'],
                'fluessiggas'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['befeuerung_fluessiggas']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'klimatisiert' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['klimatisiert'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'personen'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['fahrstuhlart_personen'],
                'lasten'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['fahrstuhlart_lasten']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'stellplatzart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['stellplatzart'],
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'garage'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stellplatzart_garage'],
                'tiefgarage'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stellplatzart_tiefgarage'],
                'carport'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stellplatzart_carport'],
                'freiplatz'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stellplatzart_freiplatz'],
                'parkhaus'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stellplatzart_parkhaus'],
                'duplex'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['stellplatzart_duplex']
            ),
            'eval'                      => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'gartennutzung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gartennutzung'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'nord'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_nord'],
                'ost'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_ost'],
                'sued'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_sued'],
                'west'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_west'],
                'nordost'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_nordost'],
                'nordwest'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_nordwest'],
                'suedost'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_suedost'],
                'suedwest'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausrichtBalkonTerrasse_suedwest']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'   => true
            )
        ),
        'moebliert' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['moebliert'],
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'voll'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['moebliert_voll'],
                'teil'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['moebliert_teil']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'rollstuhlgerecht' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['rollstuhlgerecht'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'    => true
            )
        ),
        'kantineCafeteria' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kantineCafeteria'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'hotelrestaurant'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['angeschlGastronomie_hotelrestaurant'],
                'bar'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['angeschlGastronomie_bar']
            ),
            'eval'                      => array('multiple'=>true, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'brauereibindung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['brauereibindung'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'betreutes_wohnen'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['serviceleistungen_betreutes_wohnen'],
                'catering'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['serviceleistungen_catering'],
                'reinigung'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['serviceleistungen_reinigung'],
                'einkauf'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['serviceleistungen_einkauf'],
                'wachdienst'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['serviceleistungen_wachdienst']
            ),
            'eval'                      => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'   => true
            )
        ),
        'telefonFerienimmobilie' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['telefonFerienimmobilie'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'alarmanlage'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sicherheitstechnik_alarmanlage'],
                'kamera'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sicherheitstechnik_kamera'],
                'polizeiruf'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sicherheitstechnik_polizeiruf']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "text NOT NULL default ''",
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'ja'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['unterkellert_ja'],
                'nein'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['unterkellert_nein'],
                'teil'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['unterkellert_teil']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(4) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'abstellraum' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['abstellraum'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''",
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'erstbezug'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_erstbezug'],
                'teil_vollrenovierungsbed'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_teil_vollrenovierungsbed'],
                'neuwertig'                 => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_neuwertig'],
                'teil_vollsaniert'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_teil_vollsaniert'],
                'teil_vollrenoviert'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_teil_vollrenoviert'],
                'teil_saniert'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_teil_saniert'],
                'voll_saniert'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_voll_saniert'],
                'sanierungsbeduerftig'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_sanierungsbeduerftig'],
                'baufaellig'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_baufaellig'],
                'nach_vereinbarung'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_nach_vereinbarung'],
                'modernisiert'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_modernisiert'],
                'gepflegt'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_gepflegt'],
                'rohbau'                    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_rohbau'],
                'entkernt'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_entkernt'],
                'abrissobjekt'              => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_abrissobjekt'],
                'projektiert'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zustand_projektiert']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(24) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'alterAttr' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['alter'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'altbau'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['alterAttr_altbau'],
                'neubau'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['alterAttr_neubau']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'bebaubarNach' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bebaubarNach'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                '34_nachbarschaft'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_34_nachbarschaft'],
                '35_aussengebiet'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_35_aussengebiet'],
                'b_plan'                => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_b_plan'],
                'kein_bauland'          => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_kein_bauland'],
                'bauerwartungsland'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_bauerwartungsland'],
                'laenderspezifisch'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_laenderspezifisch'],
                'bauland_ohne_b_plan'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['bebaubarNach_bauland_ohne_b_plan']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(19) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'erschliessung' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erschliessung'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'unerschlossen'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_unerschlossen'],
                'teilerschlossen'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_teilerschlossen'],
                'vollerschlossen'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_vollerschlossen'],
                'ortsueblicherschlossen'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_ortsueblicherschlossen']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(22) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'erschliessungUmfang' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['erschliessungUmfang'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'gas'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_gas'],
                'wasser'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_wasser'],
                'strom'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_strom'],
                'tk'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_tk']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'bauzone'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['bauzone'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'altlasten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['altlasten'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'offen'         => &$GLOBALS['TL_LANG']['tl_real_estate_value']['verkaufstatus_offen'],
                'reserviert'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['verkaufstatus_reserviert'],
                'verkauft'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['verkaufstatus_verkauft']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''",
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'ferne' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausblick_ferne'],
                'see'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausblick_see'],
                'berge' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausblick_berg'],
                'meer'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['ausblick_meer']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'distanzFlughafen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzFlughafen'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzFernbahnhof'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzFernbahnhof'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzAutobahn'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzAutobahn'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzUsBahn'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzUsBahn'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzBus'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzBus'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzKindergarten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzKindergarten'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGrundschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGrundschule'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzHauptschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzHauptschule'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzRealschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzRealschule'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGesamtschule'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGesamtschule'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGymnasium'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGymnasium'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzZentrum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzZentrum'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzEinkaufsmoeglichkeiten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzEinkaufsmoeglichkeiten'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGaststaetten'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzGaststaetten'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportStrand'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportStrand'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSee'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportSee'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportMeer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportMeer'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSkigebiet'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportSkigebiet'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSportanlagen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportSportanlagen'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportWandergebiete'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportWandergebiete'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportNaherholung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['distanzSportNaherholung'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'bedarf'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['energiepassEpart_bedarf'],
                'verbrauch' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['energiepassEpart_verbrauch']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(9) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassGueltigBis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassGueltigBis'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassEnergieverbrauchkennwert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassEnergieverbrauchkennwert'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassMitwarmwasser'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassMitwarmwasser'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassPrimaerenergietraeger'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassPrimaerenergietraeger'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassBaujahr'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassBaujahr'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassAusstelldatum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassAusstelldatum'],
            'exclude'                 => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'energiepassGebaeudeart' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassGebaeudeart'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'wohn'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['energiepassGebaeudeart_wohn'],
                'nichtwohn' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['energiepassGebaeudeart_nichtwohn']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(9) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassEpasstext'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassEpasstext'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassHwbwert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassHwbwert'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassHwbklasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassHwbklasse'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassFgeewert'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassFgeewert'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassFgeeklasse'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['energiepassFgeeklasse'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
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
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'verfuegbarAb'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['verfuegbarAb'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'abdatum'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['abdatum'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'tag'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['minMietdauer_tag'],
                'woche' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['minMietdauer_woche'],
                'monat' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['minMietdauer_monat'],
                'jahr'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['minMietdauer_jahr']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'maxMietdauer' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['maxMietdauer'],
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'tag'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['maxMietdauer_tag'],
                'woche' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['maxMietdauer_woche'],
                'monat' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['maxMietdauer_monat'],
                'jahr'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['maxMietdauer_jahr']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'versteigerungstermin'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['versteigerungstermin'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),
        'gruppennummer'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['gruppennummer'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''"
        ),
        'zugang'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['zugang'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'laufzeit'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['laufzeit'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'maxPersonen'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['maxPersonen'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'egal'      => &$GLOBALS['TL_LANG']['tl_real_estate_value']['geschlecht_egal'],
                'nur_mann'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['geschlecht_nur_mann'],
                'nur_frau'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['geschlecht_nur_frau']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(8) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'   => true
            )
        ),
        'denkmalgeschuetzt'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['denkmalgeschuetzt'],
            'exclude'                 => true,
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
            'exclude'                 => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'hochhaus'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['hochhaus'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
            'realEstate'                => array(
                'unique' => true
            )
        ),
        'objektnrExtern'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['objektnrExtern'],
            'exclude'                 => true,
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
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'aktivBis'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['aktivBis'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'openimmoObid'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['openimmoObid'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'kennungUrsprung'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['kennungUrsprung'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'standVom'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['standVom'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "int(10) unsigned NOT NULL default '0'",
        ),
        'weitergabeGenerell'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['weitergabeGenerell'],
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'weitergabePositiv'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['weitergabePositiv'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'weitergabeNegativ'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['weitergabeNegativ'],
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "text NOT NULL default ''",
        ),
        'sprache' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['sprache'],
            'exclude'                 => true,
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
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'imageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['imageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'planImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['planImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'interiorViewImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['interiorViewImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'exteriorViewImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['exteriorViewImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'mapViewImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['mapViewImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'panoramaImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['panoramaImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'epassSkalaImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['epassSkalaImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'logoImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['logoImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'qrImageSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['qrImageSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
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
                'group'    => 'document'
            )
        ),

        /**
         * Links
         */
        'links' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['links'],
            'exclude'                 => true,
            'inputType'               => 'listWizard',
            'eval'                    => array('tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'link'
            )
        ),
        'anbieterobjekturl' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['anbieterobjekturl'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50 clr'),
            'sql'                     => "text NOT NULL default ''",
        ),

        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate']['published'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'w50 m12 clr'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class tl_real_estate extends Contao\Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * Check permissions to edit table tl_real_estate
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission(): void
    {
        if ($this->User->isAdmin)
        {
            return;
        }

        // Check permissions to add real estates
        if (!$this->User->hasAccess('create', 'realestatep'))
        {
            $GLOBALS['TL_DCA']['tl_real_estate']['config']['closed'] = true;
            $GLOBALS['TL_DCA']['tl_real_estate']['config']['notCreatable'] = true;
            $GLOBALS['TL_DCA']['tl_real_estate']['config']['notCopyable'] = true;
        }

        // Check permissions to delete real estates
        if (!$this->User->hasAccess('delete', 'realestatep'))
        {
            $GLOBALS['TL_DCA']['tl_real_estate']['config']['notDeletable'] = true;
        }
    }

    /**
     * Auto-generate a real estate alias if it has not been set yet
     *
     * @param mixed                $varValue
     * @param mixed                $dc
     * @param string               $title
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias($varValue, $dc, string $title=''): string
    {
        // Generate alias if there is none
        if ($varValue == '')
        {
            $title = $dc->activeRecord !== null ? $dc->activeRecord->objekttitel : $title;
            $varValue = Contao\System::getContainer()->get('contao.slug.generator')->generate($title);
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
    public function editHeader(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->canEditFieldsOf('tl_real_estate') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function copyRealEstate(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('create', 'realestatep') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function deleteRealEstate(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('delete', 'realestatep') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return all provider as array
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getContactPerson(Contao\DataContainer $dc): array
    {
        $arrContactPersons = array();

        if ($dc->activeRecord === null)
        {
            $objContactPersons = $this->Database->execute("SELECT id, name, vorname FROM tl_contact_person");

            if ($objContactPersons->numRows < 1)
            {
                return array();
            }

            while ($objContactPersons->next())
            {
                $arrContactPersons[$objContactPersons->id] = $objContactPersons->vorname . ' ' . $objContactPersons->name;
            }

            return $arrContactPersons;
        }

        $objContactPersons = $this->Database->prepare("SELECT id, name, vorname FROM tl_contact_person WHERE pid=?")->execute($dc->activeRecord->provider);

        if ($objContactPersons->numRows < 1)
        {
            return array();
        }

        while ($objContactPersons->next())
        {
            $arrContactPersons[$objContactPersons->id] = $objContactPersons->vorname . ' ' . $objContactPersons->name;
        }

        return $arrContactPersons;
    }

    /**
     * Return all provider as array
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getAllProvider(Contao\DataContainer $dc): array
    {
        $objProviders = $this->Database->execute("SELECT id, anbieternr, firma FROM tl_provider");

        if ($objProviders->numRows < 1)
        {
            return array();
        }

        $arrProviders = array();

        while ($objProviders->next())
        {
            $arrProviders[$objProviders->id] = $objProviders->firma . ' (' . $objProviders->anbieternr . ')';
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
    public function toggleIcon(array $row, ?string $href, string $label, string $title, string $icon, string $attributes): string
    {
        if (strlen(Contao\Input::get('tid')))
        {
            $this->toggleVisibility(Contao\Input::get('tid'), (Contao\Input::get('state') == 1), (@func_get_arg(12) ?: null));
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

        return '<a href="'.$this->addToUrl($href).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
    }

    /**
     * Toggle the visibility of a real estate property
     *
     * @param integer              $intId
     * @param boolean              $blnVisible
     * @param Contao\DataContainer $dc
     */
    public function toggleVisibility(int $intId, bool $blnVisible, Contao\DataContainer $dc=null): void
    {
        // Set the ID and action
        Contao\Input::setGet('id', $intId);
        Contao\Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        // Trigger the onload_callback
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['config']['onload_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
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

        $objVersions = new Contao\Versions('tl_real_estate', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['name']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
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
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['config']['onsubmit_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['config']['onsubmit_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
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
     * @param array                $row
     * @param string               $label
     * @param Contao\DataContainer $dc
     * @param array                $args
     *
     * @return array
     */
    public function addPreviewImageAndInformation(array $row, string $label, Contao\DataContainer $dc, array $args): array
    {
        $objFile = null;

        if ($row['titleImageSRC'] != '') {
            $objFile = Contao\FilesModel::findByUuid($row['titleImageSRC']);
        }

        if (($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path)) && Contao\Config::get('defaultImage'))
        {
            $objFile = Contao\FilesModel::findByUuid(Contao\Config::get('defaultImage'));
        }

        // open information block
        $args[0] = '<div class="object-information">';

        if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path))
        {
            // add preview image
            $args[0] .= '<div class="image">' . Contao\Image::getHtml(Contao\System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/' . $objFile->path, array(118, 75, 'center_center'))->getUrl(TL_ROOT), '', 'class="estate_preview"') . '</div>';
        }

        $args[0] .= '<div class="info">';
        $args[0] .=     '<div><span>ID:</span> <span>'. $row['id'] . '</span></div>';
        $args[0] .=     '<div><span>Intern:</span> <span>' . $row['objektnrIntern'] . '</span></div>';
        $args[0] .=     '<div><span>Extern:</span> <span>' . $row['objektnrExtern'] . '</span></div>';
        $args[0] .= '</div>';

        // close information block
        $args[0] .= '</div>';

        // add address information
        $args[1] .= '<div style="color:#999;display:block;margin-top:5px">' . $row['plz'] . ' ' . $row['ort'] . ' · ' . $row['strasse'] . ' ' . $row['hausnummer'] . '</div>';

        // extend object type
        $args[2] .= '<div style="color:#999;display:block;margin-top:5px">' . $this->getTranslatedType($row) . '</div>';

        $args[3] = $this->getTranslatedMarketingtype($row);
        $args[3] .= '<div style="color:#999;display:block;margin-top:5px">' . ContaoEstateManager\Translator::translateValue('nutzungsart_'.$row['nutzungsart']) . '</div>';

        // translate date
        $args[5] = date(Contao\Config::get('datimFormat'), $args[5]);

        // Call post_label_callbacks ($row, $label, $dc, $args)
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks']))
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

    /**
     * Retrieve translated type
     *
     * @param array $row
     *
     * @return string
     */
    private function getTranslatedType(array $row): string
    {
        $subpalette = $GLOBALS['TL_DCA']['tl_real_estate']['subpalettes']['objektart_'.$row['objektart']];
        $type = $row[$subpalette];

        if (empty($type))
        {
            return '';
        }

        return ContaoEstateManager\Translator::translateValue($subpalette . '_' . $type);
    }

    /**
     * Retrieve translated marketing types
     *
     * @param array $row
     *
     * @return string
     */
    private function getTranslatedMarketingtype(array $row): string
    {
        $arrMarketingTypes = array();
        $availableMarketingTypes = array('vermarktungsartKauf', 'vermarktungsartMietePacht', 'vermarktungsartErbpacht', 'vermarktungsartLeasing');

        foreach ($availableMarketingTypes as $marketingType)
        {
            if ($row[$marketingType] === '1')
            {
                $arrMarketingTypes[] = $marketingType;
            }
        }

        foreach ($arrMarketingTypes as $index => $marktingType)
        {
            $arrMarketingTypes[$index] = ContaoEstateManager\Translator::translateLabel($marktingType);
        }

        return implode(' / ', $arrMarketingTypes);
    }
}
