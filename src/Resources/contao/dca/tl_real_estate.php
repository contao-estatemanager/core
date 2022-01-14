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
Contao\System::loadLanguageFile('tl_real_estate_countries');
Contao\System::loadLanguageFile('tl_real_estate_languages');

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
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
            ),
            'copy' => array
            (
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
            ),
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
            ),
            'toggle' => array
            (
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_real_estate\')"',
                'button_callback'     => array('tl_real_estate', 'toggleIcon')
            ),
            'show' => array
            (
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
                                         '{real_estate_price_legend:hide},kaufpreis,kaufpreisnetto,kaufpreisbrutto,kaltmiete,nettokaltmiete,warmmiete,freitextPreis,nebenkosten,heizkostenEnthalten,heizkosten,heizkostennetto,heizkostenust,zzgMehrwertsteuer,mietzuschlaege,pauschalmiete,hauptmietzinsnetto,hauptmietzinsust,betriebskostennetto,betriebskostenust,evbnetto,evbust,gesamtmietenetto,gesamtmieteust,gesamtmietebrutto,gesamtbelastungnetto,gesamtbelastungust,gesamtbelastungbrutto,gesamtkostenprom2von,gesamtkostenprom2bis,monatlichekostennetto,monatlichekostenust,monatlichekostenbrutto,nebenkostenprom2von,nebenkostenprom2bis,ruecklagenetto,ruecklageust,sonstigekostennetto,sonstigekostenust,sonstigemietenetto,sonstigemieteust,summemietenetto,summemieteust,nettomieteprom2von,nettomieteprom2bis,pacht,erbpacht,hausgeld,abstand,preisZeitraumVon,preisZeitraumBis,preisZeiteinheit,mietpreisProQm,kaufpreisProQm,provisionspflichtig,innenCourtage,innenCourtageMwst,aussenCourtage,aussenCourtageMwst,courtageHinweis,provisionnetto,provisionust,provisionbrutto,mwstSatz,mwstGesamt,xFache,nettorendite,nettorenditeSoll,nettorenditeIst,mieteinnahmenIst,mieteinnahmenIstPeriode,mieteinnahmenSoll,mieteinnahmenSollPeriode,erschliessungskosten,kaution,kautionText,geschaeftsguthaben,richtpreis,richtpreisprom2;'.
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
        'weitergabeGenerell'                     => 'weitergabePositiv,weitergabeNegativ'
    ),
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sorting'                 => true,
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sorting'                 => true,
            'flag'                    => 2,
            'sql'                     => "int(10) unsigned NOT NULL default 0",
            'realEstate'              => array(
                'sorting'   => true
            )
        ),
        'dateAdded' => array
        (
            'default'                 => time(),
            'sorting'                 => true,
            'flag'                    => 6,
            'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default 0",
            'realEstate'              => array(
                'sorting'   => true
            )
        ),
        'alias' => array
        (
            'exclude'                   => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) COLLATE utf8_bin NOT NULL default ''"
        ),
        'provider' => array
        (
            'exclude'                   => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'eval'                    => array('submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'foreignKey'              => 'tl_provider.firma',
            'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),
            'sql'                     => "varchar(64) NOT NULL default ''", // ToDo: use int(10)
        ),
        'contactPerson' => array
        (
            'exclude'                   => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'foreignKey'              => 'tl_contact_person.name',
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default 0",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'anbieternr' => array
        (
            'exclude'                   => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),

         // Objektkategorien
        'nutzungsart' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'filter'                    => true,
            'options'                   => array
            (
                'wohnen'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_wohnen'],
                'gewerbe' => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_gewerbe'],
                'anlage'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_anlage'],
                'waz'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['nutzungsart_waz']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
            'sql'                       => "varchar(7) NOT NULL default ''",
            'realEstate'                => array(
                'detail'  => true,
                'order'   => 100
            )
        ),
        'vermarktungsartKauf'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'vermarktungsartMietePacht'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'vermarktungsartErbpacht'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'vermarktungsartLeasing'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'vermarktungsart'
            )
        ),
        'objektart' => array
        (
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
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'  => true,
                'order'   => 100
            )
        ),

        // Objekttypen
        'zimmerTyp' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'zimmer'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['zimmerTyp_zimmer'],
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'wohnungTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'hausTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'grundstTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'bueroTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'handelTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'gastgewTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'hallenTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'landTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'parkenTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'sonstigeTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'freizeitTyp' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'sportanlagen'                  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['freizeitTyp_sportanlagen'],
                'vergnuegungsparks_und_center'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['freizeitTyp_vergnuegungsparks_und_center'],
                'freizeitanlagen'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['freizeitTyp_freizeitanlagen']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'filter' => true,
                'group'  => 'objekttyp'
            )
        ),
        'zinsTyp' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
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
            'exclude'                   => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),

        // Robots-Tag
        'robots' => array
        (
            'exclude'                   => true,
            'inputType'               => 'select',
            'options'                 => array('index,follow', 'index,nofollow', 'noindex,follow', 'noindex,nofollow'),
            'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''"
        ),

        // Meta description
        'metaDescription' => array
        (
            'exclude'                   => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('style'=>'height:60px', 'decodeEntities'=>true, 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),

        // Search engine preview
        'serpPreview' => array
        (
            'exclude'                   => true,
            'inputType'               => 'serpPreview',
            'eval'                    => array('url_callback'=>static function () { return 'http://[your-domain.com]/[alias]/'; }, 'titleFields'=>array('metaTitle', 'objekttitel'), 'descriptionFields'=>array('metaDescription', 'objektbeschreibung')),
            'sql'                     => null
        ),

        /**
         * Preise
         */
        'kaufpreisAufAnfrage'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),

        // Kaufpreis
        'kaufpreis' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50 clr'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 800
            )
        ),

        // Zusatzkosten
        'nebenkosten'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'zzgMehrwertsteuer'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'pauschalmiete'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'evbnetto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtmietenetto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtmietebrutto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'gesamtbelastungbrutto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'monatlichekostenbrutto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'sonstigekostennetto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'sonstigemietenetto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'summemietenetto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'nettomieteprom2von'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
        'innenCourtage'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'innenCourtageMwst'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),
        'aussenCourtage'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                       => "text NULL",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 830
            )
        ),
        'aussenCourtageMwst'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'provisionbrutto'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 8, 'tl_class' => 'w50'),
            'sql'                       => "varchar(8) NOT NULL default ''",
        ),
        'mwstSatz'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'mwstGesamt'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'xFache'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "text NULL"
        ),
        'nettorendite'  => array
        (
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'price'    => true,
                'order'    => 831
            )
        ),
        'geschaeftsguthaben'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength' => 20, 'tl_class' => 'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
        ),
        'richtpreisprom2'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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

            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "text NULL"
        ),

        /**
         * Geo / Adressinformationen
         */
        'plz'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 201
            )
        ),
        'strasse'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 203
            )
        ),
        'hausnummer'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(16) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 204
            )
        ),
        'breitengrad'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
        ),
        'laengengrad'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
        ),
        'bundesland'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'order'   => 210
            )
        ),
        'land'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'filter'                    => true,
			'options_callback' => static function ()
			{
				return array_keys($GLOBALS['TL_LANG']['tl_real_estate_countries']);
			},
			'reference'					=> &$GLOBALS['TL_LANG']['tl_real_estate_countries'],
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(3) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'filter'   => true,
                'sorting'  => true,
                'order'    => 210
            )
        ),
        'flur'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'flurstueck'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'gemarkung'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'etage'  => array
        (
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
        'wohnungsnr'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 210
            )
        ),
        'lageGebiet'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'regionalerZusatz'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'address',
                'order'   => 202
            )
        ),
        'kartenMakro'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'kartenMikro'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''",
        ),
        'virtuelletour'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'flag'                      => 1,
            'eval'                      => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=> 'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'objektbeschreibung'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'ausstattBeschr'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'lage'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'sonstigeAngaben'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'objektText'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'textarea',
            'eval'                      => array('tl_class'=>'clr'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'group'     => 'text'
            )
        ),
        'dreizeiler'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
            'realEstate'                => array(
                'group'     => 'bieterverfahren'
            )
        ),
        'mindestpreis'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'group'     => 'versteigerung'
            )
        ),
        'verkehrswert'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'gfz'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'bmz'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'bgf'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'grundstuecksflaeche'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'ausnuetzungsziffer'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "decimal(10,2) NULL default NULL",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'flaechevon'  => array
        (

            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
        'bad' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'ebk'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['kueche_ebk'],
                'offen'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['kueche_offen'],
                'pantry'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['kueche_pantry']
            ),
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
            'exclude'                   => true,
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
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'attribute' => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'kamin' => array
        (
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
        'heizungsart' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'befeuerung' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(255) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'klimatisiert' => array
        (
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
        'fahrstuhlart' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'personen'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['fahrstuhlart_personen'],
                'lasten'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['fahrstuhlart_lasten']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'stellplatzart' => array
        (
            'exclude'                   => true,
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
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'gartennutzung' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'   => true
            )
        ),
        'moebliert' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'voll'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['moebliert_voll'],
                'teil'  => &$GLOBALS['TL_LANG']['tl_real_estate_value']['moebliert_teil']
            ),
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
        'kabelSatTv' => array
        (
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
        'dvbt' => array
        (
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
        'barrierefrei' => array
        (
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
        'sauna' => array
        (
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
        'swimmingpool' => array
        (
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
        'waschTrockenraum' => array
        (
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
        'wintergarten' => array
        (
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
        'dvVerkabelung' => array
        (
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
        'rampe' => array
        (
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
        'hebebuehne' => array
        (
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
        'kran' => array
        (
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
        'gastterrasse' => array
        (
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
        'stromanschlusswert' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('tl_class' => 'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'filter'    => true
            )
        ),
        'kantineCafeteria' => array
        (
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
        'teekueche' => array
        (
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
        'hallenhoehe' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'hotelrestaurant'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['angeschlGastronomie_hotelrestaurant'],
                'bar'               => &$GLOBALS['TL_LANG']['tl_real_estate_value']['angeschlGastronomie_bar']
            ),
            'eval'                      => array('multiple'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'    => true
            )
        ),
        'brauereibindung' => array
        (
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
        'sporteinrichtungen' => array
        (
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
        'wellnessbereich' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'sql'                       => "varchar(128) NOT NULL default ''",
            'realEstate'                => array(
                'detail'    => true,
                'attribute' => true,
                'filter'   => true
            )
        ),
        'telefonFerienimmobilie' => array
        (
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
        'breitbandZugang' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'checkboxWizard',
            'options'                   => array
            (
                'alarmanlage'   => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sicherheitstechnik_alarmanlage'],
                'kamera'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sicherheitstechnik_kamera'],
                'polizeiruf'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['sicherheitstechnik_polizeiruf']
            ),
            'eval'                      => array('multiple'=>true),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'attribute' => true,
                'filter'   => true,
                'order'    => 600
            )
        ),
        'unterkellert' => array
        (
            'exclude'                   => true,
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
        'fahrradraum' => array
        (
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
        'rolladen' => array
        (
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
        'bibliothek' => array
        (
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
        'dachboden' => array
        (
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
        'gaestewc' => array
        (
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
        'kabelkanaele' => array
        (
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
        'seniorengerecht' => array
        (
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

        /**
         * Zustand Angaben
         */
        'baujahr'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'alterAttr' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'erschliessung' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'unerschlossen'             => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_unerschlossen'],
                'teilerschlossen'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_teilerschlossen'],
                'vollerschlossen'           => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_vollerschlossen'],
                'ortsueblicherschlossen'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessung_ortsueblicherschlossen']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'erschliessungUmfang' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'options'                   => array
            (
                'gas'       => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_gas'],
                'wasser'    => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_wasser'],
                'strom'     => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_strom'],
                'tk'        => &$GLOBALS['TL_LANG']['tl_real_estate_value']['erschliessungUmfang_tk']
            ),
            'eval'                      => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'bauzone'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'altlasten'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "text NULL default NULL",
            'realEstate'                => array(
                'detail'   => true
            )
        ),
        'verkaufstatus' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'   => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzFernbahnhof'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzAutobahn'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzUsBahn'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzBus'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzKindergarten'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGrundschule'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzHauptschule'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzRealschule'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGesamtschule'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGymnasium'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzZentrum'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzEinkaufsmoeglichkeiten'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzGaststaetten'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportStrand'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSee'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportMeer'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSkigebiet'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportSportanlagen'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportWandergebiete'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'group'    => 'distance',
                'filter'   => true,
                'sorting'  => true
            )
        ),
        'distanzSportNaherholung'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassEnergieverbrauchkennwert'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassMitwarmwasser'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassPrimaerenergietraeger'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassWaermewert'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassWertklasse'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassBaujahr'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassAusstelldatum'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''"
        ),
        'energiepassGebaeudeart' => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "text NULL",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassHwbwert'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassHwbklasse'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>6, 'tl_class'=>'w50'),
            'sql'                       => "varchar(6) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassFgeewert'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'energie'  => true,
                'order'    => 700
            )
        ),
        'energiepassFgeeklasse'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
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
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'verfuegbarAb'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'abdatum'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'"
        ),
        'gruppennummer'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''"
        ),
        'zugang'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
        ),
        'laufzeit'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true
            )
        ),
        'maxPersonen'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>10, 'tl_class'=>'w50'),
            'sql'                       => "int(10) NOT NULL default 0",
            'realEstate'                => array(
                'detail'   => true,
                'filter'   => true,
                'order'    => 500
            )
        ),
        'nichtraucher'  => array
        (
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
        'haustiere'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
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
        'alsFerien'  => array
        (
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
        'gewerblicheNutzung'  => array
        (
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''",
        ),
        'hochhaus'  => array
        (
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

        /**
         * Verwaltung Tech
         */
        'objektnrIntern'  => array
        (
            'exclude'                   => true,
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
            'exclude'                   => true,
            'inputType'                 => 'text',
            'search'                    => true,
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'unique' => true
            )
        ),
        'aktivVon'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'aktivBis'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''"
        ),
        'openimmoObid'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
        ),
        'kennungUrsprung'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                       => "varchar(64) NOT NULL default ''",
        ),
        'standVom'  => array
        (
            'exclude'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'date', 'tl_class'=>'w50', 'datepicker'=>true),
            'sql'                       => "varchar(10) NOT NULL default ''",
        ),
        'weitergabeGenerell'  => array
        (
            'exclude'                 => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'weitergabePositiv'  => array
        (
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'weitergabeNegativ'  => array
        (
            'exclude'                 => true,
            'inputType'                 => 'text',
            'eval'                      => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                       => "varchar(32) NOT NULL default ''",
        ),
        'sprache' => array
        (
            'exclude'                   => true,
            'inputType'                 => 'select',
            'filter'                    => true,
			'options_callback' => static function ()
			{
				return array_keys($GLOBALS['TL_LANG']['tl_real_estate_languages']);
			},
			'reference'					=> &$GLOBALS['TL_LANG']['tl_real_estate_languages'],
            'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'rgxp'=>'language', 'maxlength'=>5, 'tl_class'=>'w50'),
            'sql'                       => "varchar(5) NOT NULL default ''",
        ),

        /**
         * Bilder
         */
        'titleImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'imageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'planImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'interiorViewImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'exteriorViewImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'mapViewImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'panoramaImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'epassSkalaImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'logoImageSRC' => array
        (
            'exclude'                   => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'image'
            )
        ),
        'qrImageSRC' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'              => array(
                'group'    => 'image'
            )
        ),

        /**
         * Documents
         */
        'documents' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'fieldType'=>'checkbox', 'multiple'=>true),
            'sql'                     => "blob NULL",
            'realEstate'              => array(
                'group'    => 'document'
            )
        ),

        /**
         * Links
         */
        'links' => array
        (
            'exclude'                   => true,
            'inputType'               => 'listWizard',
            'eval'                    => array('tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'realEstate'                => array(
                'group'    => 'link'
            )
        ),
        'anbieterobjekturl' => array
        (

            'exclude'                   => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),

        'published' => array
        (
            'exclude'                   => true,
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
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['config']['onload_callback'] ?? null))
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
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']['published']['save_callback'] ?? null))
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
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['config']['onsubmit_callback'] ?? null))
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
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks'] ?? null))
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
        $subpalette = $GLOBALS['TL_DCA']['tl_real_estate']['subpalettes']['objektart_'.$row['objektart']] ?? null;

        if(!$subpalette)
        {
            return '';
        }

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
