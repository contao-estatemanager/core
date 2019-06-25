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
 * Reads and writes filter
 *
 * @property integer $id
 * @property integer $tstamp
 * @property integer $dateAdded
 * @property boolean $published
 * @property string $alias
 * @property string $nutzungsart
 * @property string $vermarktungsartKauf
 * @property string $vermarktungsartMietePacht
 * @property string $vermarktungsartErbpacht
 * @property string $vermarktungsartLeasing
 * @property string $objektart
 * @property string $zimmerTyp
 * @property string $wohnungTyp
 * @property string $hausTyp
 * @property string $grundstTyp
 * @property string $bueroTyp
 * @property string $handelTyp
 * @property string $gastgewTyp
 * @property string $hallenTyp
 * @property string $landTyp
 * @property string $parkenTyp
 * @property string $sonstigeTyp
 * @property string $freizeitTyp
 * @property string $zinsTyp
 * @property string $kaufpreis
 * @property string $kaufpreisnetto
 * @property string $kaufpreisbrutto
 * @property string $nettokaltmiete
 * @property string $kaltmiete
 * @property string $warmmiete
 * @property string $freitextPreis
 * @property string $nebenkosten
 * @property string $heizkostenEnthalten
 * @property string $heizkosten
 * @property string $heizkostennetto
 * @property string $heizkostenust
 * @property string $zzgMehrwertsteuer
 * @property string $mietzuschlaege
 * @property string $hauptmietzinsnetto
 * @property string $hauptmietzinsust
 * @property string $pauschalmiete
 * @property string $betriebskostennetto
 * @property string $betriebskostenust
 * @property string $evbnetto
 * @property string $evbust
 * @property string $gesamtmietenetto
 * @property string $gesamtmieteust
 * @property string $gesamtmietebrutto
 * @property string $gesamtbelastungnetto
 * @property string $gesamtbelastungust
 * @property string $gesamtbelastungbrutto
 * @property string $gesamtkostenprom2von
 * @property string $gesamtkostenprom2bis
 * @property string $monatlichekostennetto
 * @property string $monatlichekostenust
 * @property string $monatlichekostenbrutto
 * @property string $nebenkostenprom2von
 * @property string $nebenkostenprom2bis
 * @property string $ruecklagenetto
 * @property string $ruecklageust
 * @property string $sonstigekostennetto
 * @property string $sonstigekostenust
 * @property string $sonstigemietenetto
 * @property string $sonstigemieteust
 * @property string $summemietenetto
 * @property string $summemieteust
 * @property string $nettomieteprom2von
 * @property string $nettomieteprom2bis
 * @property string $pacht
 * @property string $erbpacht
 * @property string $hausgeld
 * @property string $abstand
 * @property string $preisZeitraumVon
 * @property string $preisZeitraumBis
 * @property string $preisZeiteinheit
 * @property string $mietpreisProQm
 * @property string $kaufpreisProQm
 * @property string $provisionspflichtig
 * @property string $provisionTeilen
 * @property string $provisionTeilenWert
 * @property string $innenCourtage
 * @property string $innenCourtageMwst
 * @property string $aussenCourtage
 * @property string $aussenCourtageMwst
 * @property string $courtageHinweis
 * @property string $provisionnetto
 * @property string $provisionust
 * @property string $provisionbrutto
 * @property string $waehrung
 * @property string $mwstSatz
 * @property string $mwstGesamt
 * @property string $xFache
 * @property string $nettorendite
 * @property string $nettorenditeSoll
 * @property string $nettorenditeIst
 * @property string $mieteinnahmenIst
 * @property string $mieteinnahmenIstPeriode
 * @property string $mieteinnahmenSoll
 * @property string $mieteinnahmenSollPeriode
 * @property string $erschliessungskosten
 * @property string $kaution
 * @property string $kautionText
 * @property string $geschaeftsguthaben
 * @property string $richtpreis
 * @property string $richtpreisprom2
 * @property string $stpCarport
 * @property string $stpCarportMietpreis
 * @property string $stpCarportKaufpreis
 * @property string $stpDuplex
 * @property string $stpDuplexMietpreis
 * @property string $stpDuplexKaufpreis
 * @property string $stpFreiplatz
 * @property string $stpFreiplatzMietpreis
 * @property string $stpFreiplatzKaufpreis
 * @property string $stpGarage
 * @property string $stpGarageMietpreis
 * @property string $stpGarageKaufpreis
 * @property string $stpParkhaus
 * @property string $stpParkhausMietpreis
 * @property string $stpParkhausKaufpreis
 * @property string $stpTiefgarage
 * @property string $stpTiefgarageMietpreis
 * @property string $stpTiefgarageKaufpreis
 * @property string $stpSonstige
 * @property string $stpSonstigeMietpreis
 * @property string $stpSonstigeKaufpreis
 * @property string $stpSonstigePlatzart
 * @property string $stpSonstigeBemerkung
 * @property string $plz
 * @property string $ort
 * @property string $strasse
 * @property string $hausnummer
 * @property string $breitengrad
 * @property string $laengengrad
 * @property string $bundesland
 * @property string $land
 * @property string $flur
 * @property string $flurstueck
 * @property string $gemarkung
 * @property string $etage
 * @property string $anzahlEtagen
 * @property string $lageImBau
 * @property string $wohnungsnr
 * @property string $lageGebiet
 * @property string $gemeindecode
 * @property string $regionalerZusatz
 * @property string $kartenMakro
 * @property string $kartenMikro
 * @property string $virtuelletour
 * @property string $luftbildern
 * @property string $objekttitel
 * @property string $dreizeiler
 * @property string $lage
 * @property string $ausstattBeschr
 * @property string $objektbeschreibung
 * @property string $sonstigeAngaben
 * @property string $objektText
 * @property string $beginnAngebotsphase
 * @property string $besichtigungstermin
 * @property string $besichtigungstermin2
 * @property string $beginnBietzeit
 * @property string $endeBietzeit
 * @property string $hoechstgebotZeigen
 * @property string $mindestpreis
 * @property string $zwangsversteigerung
 * @property string $aktenzeichen
 * @property string $zvtermin
 * @property string $zusatztermin
 * @property string $amtsgericht
 * @property string $verkehrswert
 * @property string $wohnflaeche
 * @property string $nutzflaeche
 * @property string $gesamtflaeche
 * @property string $ladenflaeche
 * @property string $lagerflaeche
 * @property string $verkaufsflaeche
 * @property string $freiflaeche
 * @property string $bueroflaeche
 * @property string $bueroteilflaeche
 * @property string $fensterfront
 * @property string $verwaltungsflaeche
 * @property string $gastroflaeche
 * @property string $grz
 * @property string $gfz
 * @property string $bmz
 * @property string $bgf
 * @property string $grundstuecksflaeche
 * @property string $sonstflaeche
 * @property string $anzahlZimmer
 * @property string $anzahlSchlafzimmer
 * @property string $anzahlBadezimmer
 * @property string $anzahlSepWc
 * @property string $anzahlBalkone
 * @property string $anzahlTerrassen
 * @property string $anzahlLogia
 * @property string $balkonTerrasseFlaeche
 * @property string $anzahlWohnSchlafzimmer
 * @property string $gartenflaeche
 * @property string $kellerflaeche
 * @property string $fensterfrontQm
 * @property string $grundstuecksfront
 * @property string $dachbodenflaeche
 * @property string $teilbarAb
 * @property string $beheizbareFlaeche
 * @property string $anzahlStellplaetze
 * @property string $plaetzeGastraum
 * @property string $anzahlBetten
 * @property string $anzahlTagungsraeume
 * @property string $vermietbareFlaeche
 * @property string $anzahlWohneinheiten
 * @property string $anzahlGewerbeeinheiten
 * @property string $einliegerwohnung
 * @property string $kubatur
 * @property string $ausnuetzungsziffer
 * @property string $flaechevon
 * @property string $flaechebis
 * @property string $ausstattKategorie
 * @property string $wgGeeignet
 * @property string $raeumeVeraenderbar
 * @property string $bad
 * @property string $kueche
 * @property string $boden
 * @property string $kamin
 * @property string $heizungsart
 * @property string $befeuerung
 * @property string $klimatisiert
 * @property string $fahrstuhlart
 * @property string $stellplatzart
 * @property string $gartennutzung
 * @property string $ausrichtBalkonTerrasse
 * @property string $moebliert
 * @property string $rollstuhlgerecht
 * @property string $kabelSatTv
 * @property string $dvbt
 * @property string $barrierefrei
 * @property string $sauna
 * @property string $swimmingpool
 * @property string $waschTrockenraum
 * @property string $wintergarten
 * @property string $dvVerkabelung
 * @property string $rampe
 * @property string $hebebuehne
 * @property string $kran
 * @property string $gastterrasse
 * @property string $stromanschlusswert
 * @property string $kantineCafeteria
 * @property string $teekueche
 * @property string $hallenhoehe
 * @property string $angeschlGastronomie
 * @property string $brauereibindung
 * @property string $sporteinrichtungen
 * @property string $wellnessbereich
 * @property string $serviceleistungen
 * @property string $telefonFerienimmobilie
 * @property string $breitbandZugang
 * @property string $breitbandGeschw
 * @property string $breitbandArt
 * @property string $umtsEmpfang
 * @property string $sicherheitstechnik
 * @property string $unterkellert
 * @property string $abstellraum
 * @property string $fahrradraum
 * @property string $rolladen
 * @property string $bibliothek
 * @property string $dachboden
 * @property string $gaestewc
 * @property string $kabelkanaele
 * @property string $seniorengerecht
 * @property string $baujahr
 * @property string $letztemodernisierung
 * @property string $zustand
 * @property string $alterAttr
 * @property string $bebaubarNach
 * @property string $erschliessung
 * @property string $erschliessungUmfang
 * @property string $bauzone
 * @property string $altlasten
 * @property string $verkaufstatus
 * @property string $zulieferung
 * @property string $ausblick
 * @property string $distanzFlughafen
 * @property string $distanzFernbahnhof
 * @property string $distanzAutobahn
 * @property string $distanzUsBahn
 * @property string $distanzBus
 * @property string $distanzKindergarten
 * @property string $distanzGrundschule
 * @property string $distanzHauptschule
 * @property string $distanzRealschule
 * @property string $distanzGesamtschule
 * @property string $distanzGymnasium
 * @property string $distanzZentrum
 * @property string $distanzEinkaufsmoeglichkeiten
 * @property string $distanzGaststaetten
 * @property string $distanzSportStrand
 * @property string $distanzSportSee
 * @property string $distanzSportMeer
 * @property string $distanzSportSkigebiet
 * @property string $distanzSportSportanlagen
 * @property string $distanzSportWandergebiete
 * @property string $distanzSportNaherholung
 * @property string $energiepassEpart
 * @property string $energiepassGueltigBis
 * @property string $energiepassEnergieverbrauchkennwert
 * @property string $energiepassMitwarmwasser
 * @property string $energiepassEndenergiebedarf
 * @property string $energiepassPrimaerenergietraeger
 * @property string $energiepassStromwert
 * @property string $energiepassWaermewert
 * @property string $energiepassWertklasse
 * @property string $energiepassBaujahr
 * @property string $energiepassAusstelldatum
 * @property string $energiepassJahrgang
 * @property string $energiepassGebaeudeart
 * @property string $energiepassEpasstext
 * @property string $energiepassHwbwert
 * @property string $energiepassHwbklasse
 * @property string $energiepassFgeewert
 * @property string $energiepassFgeeklasse
 * @property string $objektadresseFreigeben
 * @property string $verfuegbarAb
 * @property string $abdatum
 * @property string $bisdatum
 * @property string $minMietdauer
 * @property string $maxMietdauer
 * @property string $versteigerungstermin
 * @property string $wbsSozialwohnung
 * @property string $vermietet
 * @property string $gruppennummer
 * @property string $zugang
 * @property string $laufzeit
 * @property string $maxPersonen
 * @property string $nichtraucher
 * @property string $haustiere
 * @property string $geschlecht
 * @property string $denkmalgeschuetzt
 * @property string $alsFerien
 * @property string $gewerblicheNutzung
 * @property string $branchen
 * @property string $hochhaus
 * @property string $objektnrIntern
 * @property string $objektnrExtern
 * @property string $referenz
 * @property string $aktivVon
 * @property string $aktivBis
 * @property string $openimmoObid
 * @property string $kennungUrsprung
 * @property string $standVom
 * @property string $weitergabeGenerell
 * @property string $weitergabePositiv
 * @property string $weitergabeNegativ
 * @property string $gruppenKennung
 * @property string $master
 * @property string $masterVisible
 * @property string $sprache
 * @property string $titleImageSRC
 * @property string $imageSRC
 * @property string $planImageSRC
 * @property string $interiorViewImageSRC
 * @property string $exteriorViewImageSRC
 * @property string $mapViewImageSRC
 * @property string $panormaImageSRC
 * @property string $epassSkalaImageSRC
 * @property string $logoImageSRC
 * @property string $qrImageSRC
 * @property string $documents
 * @property string $links
 * @property string $anbieterobjekturl
 *
 *
 * @method static RealEstateModel|null findById($id, array $opt=array())
 * @method static RealEstateModel|null findOneBy($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByTstamp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPublished($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAlias($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNutzungsart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartKauf($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartMietePacht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartErbpacht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartLeasing($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjektart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZimmerTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWohnungTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHausTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGrundstTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBueroTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHandelTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGastgewTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHallenTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLandTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByParkenTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstigeTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFreizeitTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZinsTyp($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisnetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisbrutto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNettokaltmiete($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKaltmiete($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWarmmiete($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFreitextPreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNebenkosten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHeizkostenEnthalten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHeizkosten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHeizkostennetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHeizkostenust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZzgMehrwertsteuer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMietzuschlaege($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHauptmietzinsnetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHauptmietzinsust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPauschalmiete($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBetriebskostennetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBetriebskostenust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEvbnetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEvbust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtmietenetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtmieteust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtmietebrutto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtbelastungnetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtbelastungust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtbelastungbrutto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtkostenprom2von($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtkostenprom2bis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMonatlichekostennetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMonatlichekostenust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMonatlichekostenbrutto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNebenkostenprom2von($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNebenkostenprom2bis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRuecklagenetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRuecklageust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstigekostennetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstigekostenust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstigemietenetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstigemieteust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySummemietenetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySummemieteust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNettomieteprom2von($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNettomieteprom2bis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPacht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByErbpacht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHausgeld($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAbstand($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPreisZeitraumVon($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPreisZeitraumBis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPreisZeiteinheit($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMietpreisProQm($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisProQm($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByProvisionspflichtig($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByProvisionTeilen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByProvisionTeilenWert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByInnenCourtage($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByInnenCourtageMwst($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAussenCourtage($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAussenCourtageMwst($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByCourtageHinweis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByProvisionnetto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByProvisionust($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByProvisionbrutto($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWaehrung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMwstSatz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMwstGesamt($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByXFache($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNettorendite($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNettorenditeSoll($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNettorenditeIst($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenIst($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenIstPeriode($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenSoll($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenSollPeriode($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByErschliessungskosten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKaution($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKautionText($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGeschaeftsguthaben($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRichtpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRichtpreisprom2($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpCarport($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpCarportMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpCarportKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpDuplex($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpDuplexMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpDuplexKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpFreiplatz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpFreiplatzMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpFreiplatzKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpGarage($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpGarageMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpGarageKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpParkhaus($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpParkhausMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpParkhausKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpTiefgarage($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpTiefgarageMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpTiefgarageKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstige($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigeMietpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigeKaufpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigePlatzart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigeBemerkung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPlz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByOrt($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStrasse($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHausnummer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBreitengrad($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLaengengrad($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBundesland($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLand($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFlur($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFlurstueck($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGemarkung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEtage($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlEtagen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLageImBau($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWohnungsnr($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLageGebiet($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGemeindecode($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRegionalerZusatz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKartenMakro($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKartenMikro($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVirtuelletour($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLuftbildern($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjekttitel($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDreizeiler($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLage($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAusstattBeschr($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjektbeschreibung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstigeAngaben($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjektText($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBeginnAngebotsphase($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBesichtigungstermin($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBesichtigungstermin2($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBeginnBietzeit($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEndeBietzeit($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHoechstgebotZeigen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMindestpreis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZwangsversteigerung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAktenzeichen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZvtermin($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZusatztermin($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAmtsgericht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVerkehrswert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWohnflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNutzflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGesamtflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLadenflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLagerflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVerkaufsflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFreiflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBueroflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBueroteilflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFensterfront($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVerwaltungsflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGastroflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGrz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGfz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBmz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBgf($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGrundstuecksflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySonstflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlZimmer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlSchlafzimmer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlBadezimmer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlSepWc($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlBalkone($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlTerrassen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlLogia($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBalkonTerrasseFlaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlWohnSchlafzimmer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGartenflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKellerflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFensterfrontQm($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGrundstuecksfront($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDachbodenflaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByTeilbarAb($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBeheizbareFlaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlStellplaetze($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPlaetzeGastraum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlBetten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlTagungsraeume($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVermietbareFlaeche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlWohneinheiten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlGewerbeeinheiten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEinliegerwohnung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKubatur($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAusnuetzungsziffer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFlaechevon($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFlaechebis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAusstattKategorie($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWgGeeignet($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRaeumeVeraenderbar($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBad($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKueche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBoden($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKamin($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHeizungsart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBefeuerung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKlimatisiert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFahrstuhlart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStellplatzart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGartennutzung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAusrichtBalkonTerrasse($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMoebliert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRollstuhlgerecht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKabelSatTv($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDvbt($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBarrierefrei($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySauna($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySwimmingpool($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWaschTrockenraum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWintergarten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDvVerkabelung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRampe($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHebebuehne($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKran($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGastterrasse($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStromanschlusswert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKantineCafeteria($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByTeekueche($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHallenhoehe($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAngeschlGastronomie($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBrauereibindung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySporteinrichtungen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWellnessbereich($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByServiceleistungen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByTelefonFerienimmobilie($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBreitbandZugang($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBreitbandGeschw($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBreitbandArt($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByUmtsEmpfang($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySicherheitstechnik($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByUnterkellert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAbstellraum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByFahrradraum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByRolladen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBibliothek($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDachboden($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGaestewc($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKabelkanaele($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySeniorengerecht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBaujahr($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLetztemodernisierung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZustand($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAlterAttr($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBebaubarNach($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByErschliessung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByErschliessungUmfang($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBauzone($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAltlasten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVerkaufstatus($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZulieferung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAusblick($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzFlughafen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzFernbahnhof($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzAutobahn($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzUsBahn($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzBus($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzKindergarten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGrundschule($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzHauptschule($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzRealschule($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGesamtschule($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGymnasium($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzZentrum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzEinkaufsmoeglichkeiten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGaststaetten($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportStrand($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportSee($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportMeer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportSkigebiet($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportSportanlagen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportWandergebiete($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportNaherholung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEpart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassGueltigBis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEnergieverbrauchkennwert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassMitwarmwasser($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEndenergiebedarf($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassPrimaerenergietraeger($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassStromwert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassWaermewert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassWertklasse($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassBaujahr($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassAusstelldatum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassJahrgang($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassGebaeudeart($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEpasstext($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassHwbwert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassHwbklasse($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassFgeewert($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassFgeeklasse($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjektadresseFreigeben($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVerfuegbarAb($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAbdatum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBisdatum($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMinMietdauer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMaxMietdauer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVersteigerungstermin($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWbsSozialwohnung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByVermietet($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGruppennummer($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByZugang($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLaufzeit($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMaxPersonen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByNichtraucher($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHaustiere($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGeschlecht($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDenkmalgeschuetzt($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAlsFerien($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGewerblicheNutzung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByBranchen($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByHochhaus($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjektnrIntern($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByObjektnrExtern($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByReferenz($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAktivVon($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAktivBis($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByOpenimmoObid($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByKennungUrsprung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByStandVom($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWeitergabeGenerell($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWeitergabePositiv($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByWeitergabeNegativ($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByGruppenKennung($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMaster($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMasterVisible($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneBySprache($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByTitleImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPlanImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByInteriorViewImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByExteriorViewImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByMapViewImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByPanormaImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByEpassSkalaImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLogoImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByQrImageSRC($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByDocuments($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByLinks($col, $val, $opt=array())
 * @method static RealEstateModel|null findOneByAnbieterobjekturl($col, $val, $opt=array())
 *
 *
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findMultipleByIds($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByTstamp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDateAdded($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPublished($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAlias($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNutzungsart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartKauf($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartMietePacht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartErbpacht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartLeasing($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjektart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZimmerTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWohnungTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHausTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGrundstTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBueroTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHandelTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGastgewTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHallenTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLandTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByParkenTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstigeTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFreizeitTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZinsTyp($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisnetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisbrutto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNettokaltmiete($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKaltmiete($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWarmmiete($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFreitextPreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNebenkosten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHeizkostenEnthalten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHeizkosten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHeizkostennetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHeizkostenust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZzgMehrwertsteuer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMietzuschlaege($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHauptmietzinsnetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHauptmietzinsust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPauschalmiete($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBetriebskostennetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBetriebskostenust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEvbnetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEvbust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtmietenetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtmieteust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtmietebrutto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtbelastungnetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtbelastungust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtbelastungbrutto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtkostenprom2von($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtkostenprom2bis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMonatlichekostennetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMonatlichekostenust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMonatlichekostenbrutto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNebenkostenprom2von($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNebenkostenprom2bis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRuecklagenetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRuecklageust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstigekostennetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstigekostenust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstigemietenetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstigemieteust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySummemietenetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySummemieteust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNettomieteprom2von($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNettomieteprom2bis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPacht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByErbpacht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHausgeld($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAbstand($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPreisZeitraumVon($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPreisZeitraumBis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPreisZeiteinheit($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMietpreisProQm($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisProQm($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByProvisionspflichtig($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByProvisionTeilen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByProvisionTeilenWert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByInnenCourtage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByInnenCourtageMwst($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAussenCourtage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAussenCourtageMwst($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByCourtageHinweis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByProvisionnetto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByProvisionust($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByProvisionbrutto($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWaehrung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMwstSatz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMwstGesamt($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByXFache($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNettorendite($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNettorenditeSoll($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNettorenditeIst($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenIst($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenIstPeriode($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenSoll($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenSollPeriode($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByErschliessungskosten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKaution($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKautionText($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGeschaeftsguthaben($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRichtpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRichtpreisprom2($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpCarport($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpCarportMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpCarportKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpDuplex($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpDuplexMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpDuplexKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpFreiplatz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpFreiplatzMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpFreiplatzKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpGarage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpGarageMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpGarageKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpParkhaus($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpParkhausMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpParkhausKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpTiefgarage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpTiefgarageMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpTiefgarageKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstige($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigeMietpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigeKaufpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigePlatzart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigeBemerkung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPlz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByOrt($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStrasse($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHausnummer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBreitengrad($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLaengengrad($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBundesland($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLand($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFlur($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFlurstueck($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGemarkung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEtage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlEtagen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLageImBau($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWohnungsnr($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLageGebiet($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGemeindecode($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRegionalerZusatz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKartenMakro($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKartenMikro($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVirtuelletour($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLuftbildern($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjekttitel($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDreizeiler($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLage($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAusstattBeschr($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjektbeschreibung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstigeAngaben($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjektText($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBeginnAngebotsphase($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBesichtigungstermin($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBesichtigungstermin2($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBeginnBietzeit($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEndeBietzeit($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHoechstgebotZeigen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMindestpreis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZwangsversteigerung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAktenzeichen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZvtermin($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZusatztermin($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAmtsgericht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVerkehrswert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWohnflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNutzflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGesamtflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLadenflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLagerflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVerkaufsflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFreiflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBueroflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBueroteilflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFensterfront($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVerwaltungsflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGastroflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGrz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGfz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBmz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBgf($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGrundstuecksflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySonstflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlZimmer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlSchlafzimmer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlBadezimmer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlSepWc($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlBalkone($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlTerrassen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlLogia($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBalkonTerrasseFlaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlWohnSchlafzimmer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGartenflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKellerflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFensterfrontQm($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGrundstuecksfront($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDachbodenflaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByTeilbarAb($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBeheizbareFlaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlStellplaetze($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPlaetzeGastraum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlBetten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlTagungsraeume($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVermietbareFlaeche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlWohneinheiten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlGewerbeeinheiten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEinliegerwohnung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKubatur($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAusnuetzungsziffer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFlaechevon($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFlaechebis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAusstattKategorie($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWgGeeignet($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRaeumeVeraenderbar($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBad($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKueche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBoden($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKamin($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHeizungsart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBefeuerung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKlimatisiert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFahrstuhlart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStellplatzart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGartennutzung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAusrichtBalkonTerrasse($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMoebliert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRollstuhlgerecht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKabelSatTv($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDvbt($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBarrierefrei($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySauna($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySwimmingpool($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWaschTrockenraum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWintergarten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDvVerkabelung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRampe($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHebebuehne($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKran($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGastterrasse($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStromanschlusswert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKantineCafeteria($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByTeekueche($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHallenhoehe($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAngeschlGastronomie($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBrauereibindung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySporteinrichtungen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWellnessbereich($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByServiceleistungen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByTelefonFerienimmobilie($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBreitbandZugang($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBreitbandGeschw($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBreitbandArt($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByUmtsEmpfang($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySicherheitstechnik($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByUnterkellert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAbstellraum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByFahrradraum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByRolladen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBibliothek($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDachboden($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGaestewc($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKabelkanaele($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySeniorengerecht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBaujahr($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLetztemodernisierung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZustand($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAlterAttr($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBebaubarNach($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByErschliessung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByErschliessungUmfang($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBauzone($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAltlasten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVerkaufstatus($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZulieferung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAusblick($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzFlughafen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzFernbahnhof($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzAutobahn($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzUsBahn($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzBus($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzKindergarten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGrundschule($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzHauptschule($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzRealschule($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGesamtschule($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGymnasium($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzZentrum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzEinkaufsmoeglichkeiten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGaststaetten($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportStrand($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportSee($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportMeer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportSkigebiet($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportSportanlagen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportWandergebiete($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportNaherholung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEpart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassGueltigBis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEnergieverbrauchkennwert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassMitwarmwasser($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEndenergiebedarf($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassPrimaerenergietraeger($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassStromwert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassWaermewert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassWertklasse($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassBaujahr($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassAusstelldatum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassJahrgang($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassGebaeudeart($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEpasstext($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassHwbwert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassHwbklasse($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassFgeewert($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassFgeeklasse($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjektadresseFreigeben($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVerfuegbarAb($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAbdatum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBisdatum($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMinMietdauer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMaxMietdauer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVersteigerungstermin($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWbsSozialwohnung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByVermietet($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGruppennummer($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByZugang($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLaufzeit($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMaxPersonen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByNichtraucher($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHaustiere($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGeschlecht($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDenkmalgeschuetzt($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAlsFerien($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGewerblicheNutzung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByBranchen($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByHochhaus($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjektnrIntern($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByObjektnrExtern($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByReferenz($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAktivVon($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAktivBis($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByOpenimmoObid($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByKennungUrsprung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByStandVom($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWeitergabeGenerell($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWeitergabePositiv($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByWeitergabeNegativ($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByGruppenKennung($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMaster($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMasterVisible($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findBySprache($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByTitleImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPlanImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByInteriorViewImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByExteriorViewImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByMapViewImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByPanormaImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByEpassSkalaImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLogoImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByQrImageSRC($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByDocuments($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByLinks($val, array $opt=array())
 * @method static \Model\Collection|RealEstateModel[]|RealEstateModel|null findByAnbieterobjekturl($val, array $opt=array())
 *
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($id, array $opt=array())
 * @method static integer countByDateAdded($id, array $opt=array())
 * @method static integer countByPublished$id, array $opt=array())
 * @method static integer countByAlias($id, array $opt=array())
 * @method static integer countByNutzungsart($id, array $opt=array())
 * @method static integer countByVermarktungsartKauf($id, array $opt=array())
 * @method static integer countByVermarktungsartMietePacht($id, array $opt=array())
 * @method static integer countByVermarktungsartErbpacht($id, array $opt=array())
 * @method static integer countByVermarktungsartLeasing($id, array $opt=array())
 * @method static integer countByObjektart($id, array $opt=array())
 * @method static integer countByZimmerTyp($id, array $opt=array())
 * @method static integer countByWohnungTyp($id, array $opt=array())
 * @method static integer countByHausTyp($id, array $opt=array())
 * @method static integer countByGrundstTyp($id, array $opt=array())
 * @method static integer countByBueroTyp($id, array $opt=array())
 * @method static integer countByHandelTyp($id, array $opt=array())
 * @method static integer countByGastgewTyp($id, array $opt=array())
 * @method static integer countByHallenTyp($id, array $opt=array())
 * @method static integer countByLandTyp($id, array $opt=array())
 * @method static integer countByParkenTyp($id, array $opt=array())
 * @method static integer countBySonstigeTyp($id, array $opt=array())
 * @method static integer countByFreizeitTyp($id, array $opt=array())
 * @method static integer countByZinsTyp($id, array $opt=array())
 * @method static integer countByKaufpreis($id, array $opt=array())
 * @method static integer countByKaufpreisnetto($id, array $opt=array())
 * @method static integer countByKaufpreisbrutto($id, array $opt=array())
 * @method static integer countByNettokaltmiete($id, array $opt=array())
 * @method static integer countByKaltmiete($id, array $opt=array())
 * @method static integer countByWarmmiete($id, array $opt=array())
 * @method static integer countByFreitextPreis($id, array $opt=array())
 * @method static integer countByNebenkosten($id, array $opt=array())
 * @method static integer countByHeizkostenEnthalten($id, array $opt=array())
 * @method static integer countByHeizkosten($id, array $opt=array())
 * @method static integer countByHeizkostennetto($id, array $opt=array())
 * @method static integer countByHeizkostenust($id, array $opt=array())
 * @method static integer countByZzgMehrwertsteuer($id, array $opt=array())
 * @method static integer countByMietzuschlaege($id, array $opt=array())
 * @method static integer countByHauptmietzinsnetto($id, array $opt=array())
 * @method static integer countByHauptmietzinsust($id, array $opt=array())
 * @method static integer countByPauschalmiete($id, array $opt=array())
 * @method static integer countByBetriebskostennetto($id, array $opt=array())
 * @method static integer countByBetriebskostenust($id, array $opt=array())
 * @method static integer countByEvbnetto($id, array $opt=array())
 * @method static integer countByEvbust($id, array $opt=array())
 * @method static integer countByGesamtmietenetto($id, array $opt=array())
 * @method static integer countByGesamtmieteust($id, array $opt=array())
 * @method static integer countByGesamtmietebrutto($id, array $opt=array())
 * @method static integer countByGesamtbelastungnetto($id, array $opt=array())
 * @method static integer countByGesamtbelastungust($id, array $opt=array())
 * @method static integer countByGesamtbelastungbrutto($id, array $opt=array())
 * @method static integer countByGesamtkostenprom2von($id, array $opt=array())
 * @method static integer countByGesamtkostenprom2bis($id, array $opt=array())
 * @method static integer countByMonatlichekostennetto($id, array $opt=array())
 * @method static integer countByMonatlichekostenust($id, array $opt=array())
 * @method static integer countByMonatlichekostenbrutto($id, array $opt=array())
 * @method static integer countByNebenkostenprom2von($id, array $opt=array())
 * @method static integer countByNebenkostenprom2bis($id, array $opt=array())
 * @method static integer countByRuecklagenetto($id, array $opt=array())
 * @method static integer countByRuecklageust($id, array $opt=array())
 * @method static integer countBySonstigekostennetto($id, array $opt=array())
 * @method static integer countBySonstigekostenust($id, array $opt=array())
 * @method static integer countBySonstigemietenetto($id, array $opt=array())
 * @method static integer countBySonstigemieteust($id, array $opt=array())
 * @method static integer countBySummemietenetto($id, array $opt=array())
 * @method static integer countBySummemieteust($id, array $opt=array())
 * @method static integer countByNettomieteprom2von($id, array $opt=array())
 * @method static integer countByNettomieteprom2bis($id, array $opt=array())
 * @method static integer countByPacht($id, array $opt=array())
 * @method static integer countByErbpacht($id, array $opt=array())
 * @method static integer countByHausgeld($id, array $opt=array())
 * @method static integer countByAbstand($id, array $opt=array())
 * @method static integer countByPreisZeitraumVon($id, array $opt=array())
 * @method static integer countByPreisZeitraumBis($id, array $opt=array())
 * @method static integer countByPreisZeiteinheit($id, array $opt=array())
 * @method static integer countByMietpreisProQm($id, array $opt=array())
 * @method static integer countByKaufpreisProQm($id, array $opt=array())
 * @method static integer countByProvisionspflichtig($id, array $opt=array())
 * @method static integer countByProvisionTeilen($id, array $opt=array())
 * @method static integer countByProvisionTeilenWert($id, array $opt=array())
 * @method static integer countByInnenCourtage($id, array $opt=array())
 * @method static integer countByInnenCourtageMwst($id, array $opt=array())
 * @method static integer countByAussenCourtage($id, array $opt=array())
 * @method static integer countByAussenCourtageMwst($id, array $opt=array())
 * @method static integer countByCourtageHinweis($id, array $opt=array())
 * @method static integer countByProvisionnetto($id, array $opt=array())
 * @method static integer countByProvisionust($id, array $opt=array())
 * @method static integer countByProvisionbrutto($id, array $opt=array())
 * @method static integer countByWaehrung($id, array $opt=array())
 * @method static integer countByMwstSatz($id, array $opt=array())
 * @method static integer countByMwstGesamt($id, array $opt=array())
 * @method static integer countByXFache($id, array $opt=array())
 * @method static integer countByNettorendite($id, array $opt=array())
 * @method static integer countByNettorenditeSoll($id, array $opt=array())
 * @method static integer countByNettorenditeIst($id, array $opt=array())
 * @method static integer countByMieteinnahmenIst($id, array $opt=array())
 * @method static integer countByMieteinnahmenIstPeriode($id, array $opt=array())
 * @method static integer countByMieteinnahmenSoll($id, array $opt=array())
 * @method static integer countByMieteinnahmenSollPeriode($id, array $opt=array())
 * @method static integer countByErschliessungskosten($id, array $opt=array())
 * @method static integer countByKaution($id, array $opt=array())
 * @method static integer countByKautionText($id, array $opt=array())
 * @method static integer countByGeschaeftsguthaben($id, array $opt=array())
 * @method static integer countByRichtpreis($id, array $opt=array())
 * @method static integer countByRichtpreisprom2($id, array $opt=array())
 * @method static integer countByStpCarport($id, array $opt=array())
 * @method static integer countByStpCarportMietpreis($id, array $opt=array())
 * @method static integer countByStpCarportKaufpreis($id, array $opt=array())
 * @method static integer countByStpDuplex($id, array $opt=array())
 * @method static integer countByStpDuplexMietpreis($id, array $opt=array())
 * @method static integer countByStpDuplexKaufpreis($id, array $opt=array())
 * @method static integer countByStpFreiplatz($id, array $opt=array())
 * @method static integer countByStpFreiplatzMietpreis($id, array $opt=array())
 * @method static integer countByStpFreiplatzKaufpreis($id, array $opt=array())
 * @method static integer countByStpGarage($id, array $opt=array())
 * @method static integer countByStpGarageMietpreis($id, array $opt=array())
 * @method static integer countByStpGarageKaufpreis($id, array $opt=array())
 * @method static integer countByStpParkhaus($id, array $opt=array())
 * @method static integer countByStpParkhausMietpreis($id, array $opt=array())
 * @method static integer countByStpParkhausKaufpreis($id, array $opt=array())
 * @method static integer countByStpTiefgarage($id, array $opt=array())
 * @method static integer countByStpTiefgarageMietpreis($id, array $opt=array())
 * @method static integer countByStpTiefgarageKaufpreis($id, array $opt=array())
 * @method static integer countByStpSonstige($id, array $opt=array())
 * @method static integer countByStpSonstigeMietpreis($id, array $opt=array())
 * @method static integer countByStpSonstigeKaufpreis($id, array $opt=array())
 * @method static integer countByStpSonstigePlatzart($id, array $opt=array())
 * @method static integer countByStpSonstigeBemerkung($id, array $opt=array())
 * @method static integer countByPlz($id, array $opt=array())
 * @method static integer countByOrt($id, array $opt=array())
 * @method static integer countByStrasse($id, array $opt=array())
 * @method static integer countByHausnummer($id, array $opt=array())
 * @method static integer countByBreitengrad($id, array $opt=array())
 * @method static integer countByLaengengrad($id, array $opt=array())
 * @method static integer countByBundesland($id, array $opt=array())
 * @method static integer countByLand($id, array $opt=array())
 * @method static integer countByFlur($id, array $opt=array())
 * @method static integer countByFlurstueck($id, array $opt=array())
 * @method static integer countByGemarkung($id, array $opt=array())
 * @method static integer countByEtage($id, array $opt=array())
 * @method static integer countByAnzahlEtagen($id, array $opt=array())
 * @method static integer countByLageImBau($id, array $opt=array())
 * @method static integer countByWohnungsnr($id, array $opt=array())
 * @method static integer countByLageGebiet($id, array $opt=array())
 * @method static integer countByGemeindecode($id, array $opt=array())
 * @method static integer countByRegionalerZusatz($id, array $opt=array())
 * @method static integer countByKartenMakro($id, array $opt=array())
 * @method static integer countByKartenMikro($id, array $opt=array())
 * @method static integer countByVirtuelletour($id, array $opt=array())
 * @method static integer countByLuftbildern($id, array $opt=array())
 * @method static integer countByObjekttitel($id, array $opt=array())
 * @method static integer countByDreizeiler($id, array $opt=array())
 * @method static integer countByLage($id, array $opt=array())
 * @method static integer countByAusstattBeschr($id, array $opt=array())
 * @method static integer countByObjektbeschreibung($id, array $opt=array())
 * @method static integer countBySonstigeAngaben($id, array $opt=array())
 * @method static integer countByObjektText($id, array $opt=array())
 * @method static integer countByBeginnAngebotsphase($id, array $opt=array())
 * @method static integer countByBesichtigungstermin($id, array $opt=array())
 * @method static integer countByBesichtigungstermin2($id, array $opt=array())
 * @method static integer countByBeginnBietzeit($id, array $opt=array())
 * @method static integer countByEndeBietzeit($id, array $opt=array())
 * @method static integer countByHoechstgebotZeigen($id, array $opt=array())
 * @method static integer countByMindestpreis($id, array $opt=array())
 * @method static integer countByZwangsversteigerung($id, array $opt=array())
 * @method static integer countByAktenzeichen($id, array $opt=array())
 * @method static integer countByZvtermin($id, array $opt=array())
 * @method static integer countByZusatztermin($id, array $opt=array())
 * @method static integer countByAmtsgericht($id, array $opt=array())
 * @method static integer countByVerkehrswert($id, array $opt=array())
 * @method static integer countByWohnflaeche($id, array $opt=array())
 * @method static integer countByNutzflaeche($id, array $opt=array())
 * @method static integer countByGesamtflaeche($id, array $opt=array())
 * @method static integer countByLadenflaeche($id, array $opt=array())
 * @method static integer countByLagerflaeche($id, array $opt=array())
 * @method static integer countByVerkaufsflaeche($id, array $opt=array())
 * @method static integer countByFreiflaeche($id, array $opt=array())
 * @method static integer countByBueroflaeche($id, array $opt=array())
 * @method static integer countByBueroteilflaeche($id, array $opt=array())
 * @method static integer countByFensterfront($id, array $opt=array())
 * @method static integer countByVerwaltungsflaeche($id, array $opt=array())
 * @method static integer countByGastroflaeche($id, array $opt=array())
 * @method static integer countByGrz($id, array $opt=array())
 * @method static integer countByGfz($id, array $opt=array())
 * @method static integer countByBmz($id, array $opt=array())
 * @method static integer countByBgf($id, array $opt=array())
 * @method static integer countByGrundstuecksflaeche($id, array $opt=array())
 * @method static integer countBySonstflaeche($id, array $opt=array())
 * @method static integer countByAnzahlZimmer($id, array $opt=array())
 * @method static integer countByAnzahlSchlafzimmer($id, array $opt=array())
 * @method static integer countByAnzahlBadezimmer($id, array $opt=array())
 * @method static integer countByAnzahlSepWc($id, array $opt=array())
 * @method static integer countByAnzahlBalkone($id, array $opt=array())
 * @method static integer countByAnzahlTerrassen($id, array $opt=array())
 * @method static integer countByAnzahlLogia($id, array $opt=array())
 * @method static integer countByBalkonTerrasseFlaeche($id, array $opt=array())
 * @method static integer countByAnzahlWohnSchlafzimmer($id, array $opt=array())
 * @method static integer countByGartenflaeche($id, array $opt=array())
 * @method static integer countByKellerflaeche($id, array $opt=array())
 * @method static integer countByFensterfrontQm($id, array $opt=array())
 * @method static integer countByGrundstuecksfront($id, array $opt=array())
 * @method static integer countByDachbodenflaeche($id, array $opt=array())
 * @method static integer countByTeilbarAb($id, array $opt=array())
 * @method static integer countByBeheizbareFlaeche($id, array $opt=array())
 * @method static integer countByAnzahlStellplaetze($id, array $opt=array())
 * @method static integer countByPlaetzeGastraum($id, array $opt=array())
 * @method static integer countByAnzahlBetten($id, array $opt=array())
 * @method static integer countByAnzahlTagungsraeume($id, array $opt=array())
 * @method static integer countByVermietbareFlaeche($id, array $opt=array())
 * @method static integer countByAnzahlWohneinheiten($id, array $opt=array())
 * @method static integer countByAnzahlGewerbeeinheiten($id, array $opt=array())
 * @method static integer countByEinliegerwohnung($id, array $opt=array())
 * @method static integer countByKubatur($id, array $opt=array())
 * @method static integer countByAusnuetzungsziffer($id, array $opt=array())
 * @method static integer countByFlaechevon($id, array $opt=array())
 * @method static integer countByFlaechebis($id, array $opt=array())
 * @method static integer countByAusstattKategorie($id, array $opt=array())
 * @method static integer countByWgGeeignet($id, array $opt=array())
 * @method static integer countByRaeumeVeraenderbar($id, array $opt=array())
 * @method static integer countByBad($id, array $opt=array())
 * @method static integer countByKueche($id, array $opt=array())
 * @method static integer countByBoden($id, array $opt=array())
 * @method static integer countByKamin($id, array $opt=array())
 * @method static integer countByHeizungsart($id, array $opt=array())
 * @method static integer countByBefeuerung($id, array $opt=array())
 * @method static integer countByKlimatisiert($id, array $opt=array())
 * @method static integer countByFahrstuhlart($id, array $opt=array())
 * @method static integer countByStellplatzart($id, array $opt=array())
 * @method static integer countByGartennutzung($id, array $opt=array())
 * @method static integer countByAusrichtBalkonTerrasse($id, array $opt=array())
 * @method static integer countByMoebliert($id, array $opt=array())
 * @method static integer countByRollstuhlgerecht($id, array $opt=array())
 * @method static integer countByKabelSatTv($id, array $opt=array())
 * @method static integer countByDvbt($id, array $opt=array())
 * @method static integer countByBarrierefrei($id, array $opt=array())
 * @method static integer countBySauna($id, array $opt=array())
 * @method static integer countBySwimmingpool($id, array $opt=array())
 * @method static integer countByWaschTrockenraum($id, array $opt=array())
 * @method static integer countByWintergarten($id, array $opt=array())
 * @method static integer countByDvVerkabelung($id, array $opt=array())
 * @method static integer countByRampe($id, array $opt=array())
 * @method static integer countByHebebuehne($id, array $opt=array())
 * @method static integer countByKran($id, array $opt=array())
 * @method static integer countByGastterrasse($id, array $opt=array())
 * @method static integer countByStromanschlusswert($id, array $opt=array())
 * @method static integer countByKantineCafeteria($id, array $opt=array())
 * @method static integer countByTeekueche($id, array $opt=array())
 * @method static integer countByHallenhoehe($id, array $opt=array())
 * @method static integer countByAngeschlGastronomie($id, array $opt=array())
 * @method static integer countByBrauereibindung($id, array $opt=array())
 * @method static integer countBySporteinrichtungen($id, array $opt=array())
 * @method static integer countByWellnessbereich($id, array $opt=array())
 * @method static integer countByServiceleistungen($id, array $opt=array())
 * @method static integer countByTelefonFerienimmobilie($id, array $opt=array())
 * @method static integer countByBreitbandZugang($id, array $opt=array())
 * @method static integer countByBreitbandGeschw($id, array $opt=array())
 * @method static integer countByBreitbandArt($id, array $opt=array())
 * @method static integer countByUmtsEmpfang($id, array $opt=array())
 * @method static integer countBySicherheitstechnik($id, array $opt=array())
 * @method static integer countByUnterkellert($id, array $opt=array())
 * @method static integer countByAbstellraum($id, array $opt=array())
 * @method static integer countByFahrradraum($id, array $opt=array())
 * @method static integer countByRolladen($id, array $opt=array())
 * @method static integer countByBibliothek($id, array $opt=array())
 * @method static integer countByDachboden($id, array $opt=array())
 * @method static integer countByGaestewc($id, array $opt=array())
 * @method static integer countByKabelkanaele($id, array $opt=array())
 * @method static integer countBySeniorengerecht($id, array $opt=array())
 * @method static integer countByBaujahr($id, array $opt=array())
 * @method static integer countByLetztemodernisierung($id, array $opt=array())
 * @method static integer countByZustand($id, array $opt=array())
 * @method static integer countByAlterAttr($id, array $opt=array())
 * @method static integer countByBebaubarNach($id, array $opt=array())
 * @method static integer countByErschliessung($id, array $opt=array())
 * @method static integer countByErschliessungUmfang($id, array $opt=array())
 * @method static integer countByBauzone($id, array $opt=array())
 * @method static integer countByAltlasten($id, array $opt=array())
 * @method static integer countByVerkaufstatus($id, array $opt=array())
 * @method static integer countByZulieferung($id, array $opt=array())
 * @method static integer countByAusblick($id, array $opt=array())
 * @method static integer countByDistanzFlughafen($id, array $opt=array())
 * @method static integer countByDistanzFernbahnhof($id, array $opt=array())
 * @method static integer countByDistanzAutobahn($id, array $opt=array())
 * @method static integer countByDistanzUsBahn($id, array $opt=array())
 * @method static integer countByDistanzBus($id, array $opt=array())
 * @method static integer countByDistanzKindergarten($id, array $opt=array())
 * @method static integer countByDistanzGrundschule($id, array $opt=array())
 * @method static integer countByDistanzHauptschule($id, array $opt=array())
 * @method static integer countByDistanzRealschule($id, array $opt=array())
 * @method static integer countByDistanzGesamtschule($id, array $opt=array())
 * @method static integer countByDistanzGymnasium($id, array $opt=array())
 * @method static integer countByDistanzZentrum($id, array $opt=array())
 * @method static integer countByDistanzEinkaufsmoeglichkeiten($id, array $opt=array())
 * @method static integer countByDistanzGaststaetten($id, array $opt=array())
 * @method static integer countByDistanzSportStrand($id, array $opt=array())
 * @method static integer countByDistanzSportSee($id, array $opt=array())
 * @method static integer countByDistanzSportMeer($id, array $opt=array())
 * @method static integer countByDistanzSportSkigebiet($id, array $opt=array())
 * @method static integer countByDistanzSportSportanlagen($id, array $opt=array())
 * @method static integer countByDistanzSportWandergebiete($id, array $opt=array())
 * @method static integer countByDistanzSportNaherholung($id, array $opt=array())
 * @method static integer countByEnergiepassEpart($id, array $opt=array())
 * @method static integer countByEnergiepassGueltigBis($id, array $opt=array())
 * @method static integer countByEnergiepassEnergieverbrauchkennwert($id, array $opt=array())
 * @method static integer countByEnergiepassMitwarmwasser($id, array $opt=array())
 * @method static integer countByEnergiepassEndenergiebedarf($id, array $opt=array())
 * @method static integer countByEnergiepassPrimaerenergietraeger($id, array $opt=array())
 * @method static integer countByEnergiepassStromwert($id, array $opt=array())
 * @method static integer countByEnergiepassWaermewert($id, array $opt=array())
 * @method static integer countByEnergiepassWertklasse($id, array $opt=array())
 * @method static integer countByEnergiepassBaujahr($id, array $opt=array())
 * @method static integer countByEnergiepassAusstelldatum($id, array $opt=array())
 * @method static integer countByEnergiepassJahrgang($id, array $opt=array())
 * @method static integer countByEnergiepassGebaeudeart($id, array $opt=array())
 * @method static integer countByEnergiepassEpasstext($id, array $opt=array())
 * @method static integer countByEnergiepassHwbwert($id, array $opt=array())
 * @method static integer countByEnergiepassHwbklasse($id, array $opt=array())
 * @method static integer countByEnergiepassFgeewert($id, array $opt=array())
 * @method static integer countByEnergiepassFgeeklasse($id, array $opt=array())
 * @method static integer countByObjektadresseFreigeben($id, array $opt=array())
 * @method static integer countByVerfuegbarAb($id, array $opt=array())
 * @method static integer countByAbdatum($id, array $opt=array())
 * @method static integer countByBisdatum($id, array $opt=array())
 * @method static integer countByMinMietdauer($id, array $opt=array())
 * @method static integer countByMaxMietdauer($id, array $opt=array())
 * @method static integer countByVersteigerungstermin($id, array $opt=array())
 * @method static integer countByWbsSozialwohnung($id, array $opt=array())
 * @method static integer countByVermietet($id, array $opt=array())
 * @method static integer countByGruppennummer($id, array $opt=array())
 * @method static integer countByZugang($id, array $opt=array())
 * @method static integer countByLaufzeit($id, array $opt=array())
 * @method static integer countByMaxPersonen($id, array $opt=array())
 * @method static integer countByNichtraucher($id, array $opt=array())
 * @method static integer countByHaustiere($id, array $opt=array())
 * @method static integer countByGeschlecht($id, array $opt=array())
 * @method static integer countByDenkmalgeschuetzt($id, array $opt=array())
 * @method static integer countByAlsFerien($id, array $opt=array())
 * @method static integer countByGewerblicheNutzung($id, array $opt=array())
 * @method static integer countByBranchen($id, array $opt=array())
 * @method static integer countByHochhaus($id, array $opt=array())
 * @method static integer countByObjektnrIntern($id, array $opt=array())
 * @method static integer countByObjektnrExtern($id, array $opt=array())
 * @method static integer countByReferenz($id, array $opt=array())
 * @method static integer countByAktivVon($id, array $opt=array())
 * @method static integer countByAktivBis($id, array $opt=array())
 * @method static integer countByOpenimmoObid($id, array $opt=array())
 * @method static integer countByKennungUrsprung($id, array $opt=array())
 * @method static integer countByStandVom($id, array $opt=array())
 * @method static integer countByWeitergabeGenerell($id, array $opt=array())
 * @method static integer countByWeitergabePositiv($id, array $opt=array())
 * @method static integer countByWeitergabeNegativ($id, array $opt=array())
 * @method static integer countByGruppenKennung($id, array $opt=array())
 * @method static integer countByMaster($id, array $opt=array())
 * @method static integer countByMasterVisible($id, array $opt=array())
 * @method static integer countBySprache($id, array $opt=array())
 * @method static integer countByTitleImageSRC($id, array $opt=array())
 * @method static integer countByImageSRC($id, array $opt=array())
 * @method static integer countByPlanImageSRC($id, array $opt=array())
 * @method static integer countByInteriorViewImageSRC($id, array $opt=array())
 * @method static integer countByExteriorViewImageSRC($id, array $opt=array())
 * @method static integer countByMapViewImageSRC($id, array $opt=array())
 * @method static integer countByPanormaImageSRC($id, array $opt=array())
 * @method static integer countByEpassSkalaImageSRC($id, array $opt=array())
 * @method static integer countByLogoImageSRC($id, array $opt=array())
 * @method static integer countByQrImageSRC($id, array $opt=array())
 * @method static integer countByDocuments($id, array $opt=array())
 * @method static integer countByLinks($id, array $opt=array())
 * @method static integer countByAnbieterobjekturl($id, array $opt=array())
 *
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */

class RealEstateModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_real_estate';

    /**
     * Find published real estate items
     *
     * @param integer $intLimit    An optional limit
     * @param integer $intOffset   An optional offset
     * @param array   $arrOptions  An optional options array
     *
     * @return \Model\Collection|RealEstateModel[]|RealEstateModel|null A collection of models or null if there are no real estates
     */
    public static function findPublishedBy($intLimit=0, $intOffset=0, array $arrOptions=array())
    {
        $arrOptions['limit']  = $intLimit;
        $arrOptions['offset'] = $intOffset;

        return static::findBy(null, null, $arrOptions);
    }

    /**
     * Find published real estate items
     *
     * @param mixed $varId       The numeric ID or alias name
     * @param array $arrOptions  An optional options array
     *
     * @return RealEstateModel|null The model or null if there are no real estate
     */
    public static function findPublishedByIdOrAlias($varId, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = !is_numeric($varId) ? array("$t.alias=?") : array("$t.id=?");

        return static::findOneBy($arrColumns, $varId, $arrOptions);
    }
}
