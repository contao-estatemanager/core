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
 * Reads and writes real estate records
 *
 * @property integer $id
 * @property integer $tstamp
 * @property integer $dateAdded
 * @property string  $alias
 * @property string  $provider
 * @property integer $contactPerson
 * @property string  $anbieternr
 * @property string  $nutzungsart
 * @property boolean $vermarktungsartKauf
 * @property boolean $vermarktungsartMietePacht
 * @property boolean $vermarktungsartErbpacht
 * @property boolean $vermarktungsartLeasing
 * @property string  $objektart
 * @property string  $zimmerTyp
 * @property string  $wohnungTyp
 * @property string  $hausTyp
 * @property string  $grundstTyp
 * @property string  $bueroTyp
 * @property string  $handelTyp
 * @property string  $gastgewTyp
 * @property string  $hallenTyp
 * @property string  $landTyp
 * @property string  $parkenTyp
 * @property string  $sonstigeTyp
 * @property string  $freizeitTyp
 * @property string  $zinsTyp
 * @property boolean $kaufpreisAufAnfrage
 * @property string  $kaufpreis
 * @property string  $kaufpreisnetto
 * @property string  $kaufpreisbrutto
 * @property string  $nettokaltmiete
 * @property string  $kaltmiete
 * @property string  $warmmiete
 * @property string  $freitextPreis
 * @property string  $nebenkosten
 * @property string  $heizkosten
 * @property boolean $heizkostenEnthalten
 * @property string  $heizkostennetto
 * @property string  $heizkostenust
 * @property boolean $zzgMehrwertsteuer
 * @property string  $mietzuschlaege
 * @property string  $hauptmietzinsnetto
 * @property string  $hauptmietzinsust
 * @property string  $pauschalmiete
 * @property string  $betriebskostennetto
 * @property string  $betriebskostenust
 * @property string  $evbnetto
 * @property string  $evbust
 * @property string  $gesamtmietenetto
 * @property string  $gesamtmieteust
 * @property string  $gesamtmietebrutto
 * @property string  $gesamtbelastungnetto
 * @property string  $gesamtbelastungust
 * @property string  $gesamtbelastungbrutto
 * @property string  $gesamtkostenprom2von
 * @property string  $gesamtkostenprom2bis
 * @property string  $monatlichekostennetto
 * @property string  $monatlichekostenust
 * @property string  $monatlichekostenbrutto
 * @property string  $nebenkostenprom2von
 * @property string  $nebenkostenprom2bis
 * @property string  $ruecklagenetto
 * @property string  $ruecklageust
 * @property string  $sonstigekostennetto
 * @property string  $sonstigekostenust
 * @property string  $sonstigemietenetto
 * @property string  $sonstigemieteust
 * @property string  $summemietenetto
 * @property string  $summemieteust
 * @property string  $nettomieteprom2von
 * @property string  $nettomieteprom2bis
 * @property string  $pacht
 * @property string  $erbpacht
 * @property string  $hausgeld
 * @property string  $abstand
 * @property string  $preisZeitraumVon
 * @property string  $preisZeitraumBis
 * @property string  $preisZeiteinheit
 * @property string  $mietpreisProQm
 * @property string  $kaufpreisProQm
 * @property boolean $provisionspflichtig
 * @property boolean $provisionTeilen
 * @property string  $provisionTeilenWert
 * @property string  $innenCourtage
 * @property boolean $innenCourtageMwst
 * @property string  $aussenCourtage
 * @property string  $courtageHinweis
 * @property boolean $aussenCourtageMwst
 * @property string  $provisionnetto
 * @property string  $provisionust
 * @property string  $provisionbrutto
 * @property string  $waehrung
 * @property string  $mwstSatz
 * @property string  $mwstGesamt
 * @property string  $xFache
 * @property string  $nettorendite
 * @property string  $nettorenditeSoll
 * @property string  $nettorenditeIst
 * @property string  $mieteinnahmenIst
 * @property string  $mieteinnahmenIstPeriode
 * @property string  $mieteinnahmenSoll
 * @property string  $mieteinnahmenSollPeriode
 * @property string  $erschliessungskosten
 * @property string  $kaution
 * @property string  $kautionText
 * @property string  $geschaeftsguthaben
 * @property string  $richtpreis
 * @property string  $richtpreisprom2
 * @property integer $stpCarport
 * @property string  $stpCarportMietpreis
 * @property string  $stpCarportKaufpreis
 * @property integer $stpDuplex
 * @property string  $stpDuplexMietpreis
 * @property string  $stpDuplexKaufpreis
 * @property integer $stpFreiplatz
 * @property string  $stpFreiplatzMietpreis
 * @property string  $stpFreiplatzKaufpreis
 * @property integer $stpGarage
 * @property string  $stpGarageMietpreis
 * @property string  $stpGarageKaufpreis
 * @property integer $stpParkhaus
 * @property string  $stpParkhausMietpreis
 * @property string  $stpParkhausKaufpreis
 * @property integer $stpTiefgarage
 * @property string  $stpTiefgarageMietpreis
 * @property string  $stpTiefgarageKaufpreis
 * @property integer $stpSonstige
 * @property string  $stpSonstigeMietpreis
 * @property string  $stpSonstigeKaufpreis
 * @property string  $stpSonstigePlatzart
 * @property string  $stpSonstigeBemerkung
 * @property string  $plz
 * @property string  $ort
 * @property string  $strasse
 * @property string  $hausnummer
 * @property string  $breitengrad
 * @property string  $laengengrad
 * @property string  $bundesland
 * @property string  $land
 * @property string  $flur
 * @property string  $flurstueck
 * @property string  $gemarkung
 * @property integer $etage
 * @property integer $anzahlEtagen
 * @property string  $lageImBau
 * @property string  $wohnungsnr
 * @property string  $lageGebiet
 * @property string  $gemeindecode
 * @property string  $regionalerZusatz
 * @property boolean $kartenMakro
 * @property boolean $kartenMikro
 * @property boolean $virtuelletour
 * @property boolean $luftbildern
 * @property string  $objekttitel
 * @property string  $objektbeschreibung
 * @property string  $ausstattBeschr
 * @property string  $lage
 * @property string  $sonstigeAngaben
 * @property string  $objektText
 * @property string  $dreizeiler
 * @property string  $beginnAngebotsphase
 * @property string  $besichtigungstermin
 * @property string  $besichtigungstermin2
 * @property string  $beginnBietzeit
 * @property string  $endeBietzeit
 * @property boolean $hoechstgebotZeigen
 * @property string  $mindestpreis
 * @property boolean $zwangsversteigerung
 * @property string  $aktenzeichen
 * @property string  $zvtermin
 * @property string  $zusatztermin
 * @property string  $amtsgericht
 * @property string  $verkehrswert
 * @property string  $wohnflaeche
 * @property string  $nutzflaeche
 * @property string  $gesamtflaeche
 * @property string  $ladenflaeche
 * @property string  $lagerflaeche
 * @property string  $verkaufsflaeche
 * @property string  $freiflaeche
 * @property string  $bueroflaeche
 * @property string  $bueroteilflaeche
 * @property string  $fensterfront
 * @property string  $verwaltungsflaeche
 * @property string  $gastroflaeche
 * @property string  $grz
 * @property string  $gfz
 * @property string  $bmz
 * @property string  $bgf
 * @property string  $grundstuecksflaeche
 * @property string  $sonstflaeche
 * @property string  $anzahlZimmer
 * @property string  $anzahlSchlafzimmer
 * @property string  $anzahlBadezimmer
 * @property string  $anzahlSepWc
 * @property string  $anzahlBalkone
 * @property string  $anzahlTerrassen
 * @property string  $anzahlLogia
 * @property string  $balkonTerrasseFlaeche
 * @property string  $anzahlWohnSchlafzimmer
 * @property string  $gartenflaeche
 * @property string  $kellerflaeche
 * @property string  $fensterfrontQm
 * @property string  $grundstuecksfront
 * @property string  $dachbodenflaeche
 * @property string  $teilbarAb
 * @property string  $beheizbareFlaeche
 * @property string  $anzahlStellplaetze
 * @property string  $plaetzeGastraum
 * @property string  $anzahlBetten
 * @property string  $anzahlTagungsraeume
 * @property string  $vermietbareFlaeche
 * @property string  $anzahlWohneinheiten
 * @property string  $anzahlGewerbeeinheiten
 * @property boolean $einliegerwohnung
 * @property string  $kubatur
 * @property string  $ausnuetzungsziffer
 * @property string  $flaechevon
 * @property string  $flaechebis
 * @property string  $ausstattKategorie
 * @property boolean $wgGeeignet
 * @property boolean $raeumeVeraenderbar
 * @property string  $bad
 * @property string  $kueche
 * @property string  $boden
 * @property boolean $kamin
 * @property string  $heizungsart
 * @property string  $befeuerung
 * @property boolean $klimatisiert
 * @property string  $fahrstuhlart
 * @property string  $stellplatzart
 * @property boolean $gartennutzung
 * @property string  $ausrichtBalkonTerrasse
 * @property string  $moebliert
 * @property boolean $rollstuhlgerecht
 * @property boolean $kabelSatTv
 * @property boolean $dvbt
 * @property boolean $barrierefrei
 * @property boolean $sauna
 * @property boolean $swimmingpool
 * @property boolean $waschTrockenraum
 * @property boolean $wintergarten
 * @property boolean $dvVerkabelung
 * @property boolean $rampe
 * @property boolean $hebebuehne
 * @property boolean $kran
 * @property boolean $gastterrasse
 * @property string  $stromanschlusswert
 * @property boolean $kantineCafeteria
 * @property boolean $teekueche
 * @property string  $hallenhoehe
 * @property string  $angeschlGastronomie
 * @property boolean $brauereibindung
 * @property boolean $sporteinrichtungen
 * @property boolean $wellnessbereich
 * @property string  $serviceleistungen
 * @property boolean $telefonFerienimmobilie
 * @property boolean $breitbandZugang
 * @property string  $breitbandGeschw
 * @property string  $breitbandArt
 * @property boolean $umtsEmpfang
 * @property string  $sicherheitstechnik
 * @property string  $unterkellert
 * @property boolean $abstellraum
 * @property boolean $fahrradraum
 * @property boolean $rolladen
 * @property boolean $bibliothek
 * @property boolean $dachboden
 * @property boolean $gaestewc
 * @property boolean $kabelkanaele
 * @property boolean $seniorengerecht
 * @property string  $baujahr
 * @property string  $letztemodernisierung
 * @property string  $zustand
 * @property string  $alterAttr
 * @property string  $bebaubarNach
 * @property string  $erschliessung
 * @property string  $erschliessungUmfang
 * @property string  $bauzone
 * @property string  $altlasten
 * @property string  $verkaufstatus
 * @property boolean $zulieferung
 * @property string  $ausblick
 * @property string  $distanzFlughafen
 * @property string  $distanzFernbahnhof
 * @property string  $distanzAutobahn
 * @property string  $distanzUsBahn
 * @property string  $distanzBus
 * @property string  $distanzKindergarten
 * @property string  $distanzGrundschule
 * @property string  $distanzHauptschule
 * @property string  $distanzRealschule
 * @property string  $distanzGesamtschule
 * @property string  $distanzGymnasium
 * @property string  $distanzZentrum
 * @property string  $distanzEinkaufsmoeglichkeiten
 * @property string  $distanzGaststaetten
 * @property string  $distanzSportStrand
 * @property string  $distanzSportSee
 * @property string  $distanzSportMeer
 * @property string  $distanzSportSkigebiet
 * @property string  $distanzSportSportanlagen
 * @property string  $distanzSportWandergebiete
 * @property string  $distanzSportNaherholung
 * @property string  $energiepassEpart
 * @property string  $energiepassGueltigBis
 * @property string  $energiepassEnergieverbrauchkennwert
 * @property boolean $energiepassMitwarmwasser
 * @property string  $energiepassEndenergiebedarf
 * @property string  $energiepassPrimaerenergietraeger
 * @property string  $energiepassStromwert
 * @property string  $energiepassWaermewert
 * @property string  $energiepassWertklasse
 * @property string  $energiepassBaujahr
 * @property string  $energiepassAusstelldatum
 * @property string  $energiepassJahrgang
 * @property string  $energiepassGebaeudeart
 * @property string  $energiepassEpasstext
 * @property string  $energiepassHwbwert
 * @property string  $energiepassHwbklasse
 * @property string  $energiepassFgeewert
 * @property string  $energiepassFgeeklasse
 * @property boolean $objektadresseFreigeben
 * @property string  $verfuegbarAb
 * @property string  $abdatum
 * @property string  $bisdatum
 * @property string  $minMietdauer
 * @property string  $maxMietdauer
 * @property string  $versteigerungstermin
 * @property boolean $wbsSozialwohnung
 * @property boolean $vermietet
 * @property string  $gruppennummer
 * @property string  $zugang
 * @property string  $laufzeit
 * @property integer $maxPersonen
 * @property boolean $nichtraucher
 * @property boolean $haustiere
 * @property string  $geschlecht
 * @property boolean $denkmalgeschuetzt
 * @property boolean $alsFerien
 * @property boolean $gewerblicheNutzung
 * @property string  $branchen
 * @property boolean $hochhaus
 * @property string  $objektnrIntern
 * @property string  $objektnrExtern
 * @property string  $aktivVon
 * @property string  $aktivBis
 * @property string  $openimmoObid
 * @property string  $kennungUrsprung
 * @property integer $standVom
 * @property boolean $weitergabeGenerell
 * @property string  $weitergabePositiv
 * @property string  $weitergabeNegativ
 * @property string  $sprache
 * @property string  $titleImageSRC
 * @property string  $imageSRC
 * @property string  $planImageSRC
 * @property string  $interiorViewImageSRC
 * @property string  $exteriorViewImageSRC
 * @property string  $mapViewImageSRC
 * @property string  $panoramaImageSRC
 * @property string  $epassSkalaImageSRC
 * @property string  $logoImageSRC
 * @property string  $qrImageSRC
 * @property string  $documents
 * @property string  $links
 * @property string  $anbieterobjekturl
 * @property boolean $published
 *
 * @method static RealEstateModel|null findById($id, array $opt=array())
 * @method static RealEstateModel|null findByPk($id, array $opt=array())
 * @method static RealEstateModel|null findByIdOrAlias($val, array $opt=array())
 * @method static RealEstateModel|null findOneBy($col, $val, array $opt=array())
 * @method static RealEstateModel|null findOneByTstamp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDateAdded($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAlias($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvider($val, array $opt=array())
 * @method static RealEstateModel|null findOneByContactPerson($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnbieternr($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNutzungsart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartKauf($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartMietePacht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartErbpacht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVermarktungsartLeasing($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjektart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZimmerTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWohnungTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHausTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGrundstTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBueroTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHandelTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGastgewTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHallenTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLandTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByParkenTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstigeTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFreizeitTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZinsTyp($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisAufAnfrage($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisnetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisbrutto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNettokaltmiete($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaltmiete($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWarmmiete($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFreitextPreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNebenkosten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHeizkosten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHeizkostenEnthalten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHeizkostennetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHeizkostenust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZzgMehrwertsteuer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMietzuschlaege($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHauptmietzinsnetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHauptmietzinsust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPauschalmiete($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBetriebskostennetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBetriebskostenust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEvbnetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEvbust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtmietenetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtmieteust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtmietebrutto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtbelastungnetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtbelastungust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtbelastungbrutto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtkostenprom2von($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtkostenprom2bis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMonatlichekostennetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMonatlichekostenust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMonatlichekostenbrutto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNebenkostenprom2von($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNebenkostenprom2bis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRuecklagenetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRuecklageust($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstigekostennetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstigekostenust($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstigemietenetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstigemieteust($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySummemietenetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySummemieteust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNettomieteprom2von($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNettomieteprom2bis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPacht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByErbpacht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHausgeld($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAbstand($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPreisZeitraumVon($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPreisZeitraumBis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPreisZeiteinheit($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMietpreisProQm($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaufpreisProQm($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvisionspflichtig($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvisionTeilen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvisionTeilenWert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByInnenCourtage($val, array $opt=array())
 * @method static RealEstateModel|null findOneByInnenCourtageMwst($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAussenCourtage($val, array $opt=array())
 * @method static RealEstateModel|null findOneByCourtageHinweis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAussenCourtageMwst($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvisionnetto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvisionust($val, array $opt=array())
 * @method static RealEstateModel|null findOneByProvisionbrutto($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWaehrung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMwstSatz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMwstGesamt($val, array $opt=array())
 * @method static RealEstateModel|null findOneByXFache($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNettorendite($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNettorenditeSoll($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNettorenditeIst($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenIst($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenIstPeriode($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenSoll($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMieteinnahmenSollPeriode($val, array $opt=array())
 * @method static RealEstateModel|null findOneByErschliessungskosten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKaution($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKautionText($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGeschaeftsguthaben($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRichtpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRichtpreisprom2($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpCarport($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpCarportMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpCarportKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpDuplex($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpDuplexMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpDuplexKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpFreiplatz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpFreiplatzMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpFreiplatzKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpGarage($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpGarageMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpGarageKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpParkhaus($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpParkhausMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpParkhausKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpTiefgarage($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpTiefgarageMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpTiefgarageKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstige($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigeMietpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigeKaufpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigePlatzart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStpSonstigeBemerkung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPlz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByOrt($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStrasse($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHausnummer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBreitengrad($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLaengengrad($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBundesland($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLand($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFlur($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFlurstueck($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGemarkung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEtage($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlEtagen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLageImBau($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWohnungsnr($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLageGebiet($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGemeindecode($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRegionalerZusatz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKartenMakro($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKartenMikro($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVirtuelletour($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLuftbildern($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjekttitel($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjektbeschreibung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAusstattBeschr($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLage($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstigeAngaben($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjektText($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDreizeiler($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBeginnAngebotsphase($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBesichtigungstermin($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBesichtigungstermin2($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBeginnBietzeit($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEndeBietzeit($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHoechstgebotZeigen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMindestpreis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZwangsversteigerung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAktenzeichen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZvtermin($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZusatztermin($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAmtsgericht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVerkehrswert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWohnflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNutzflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGesamtflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLadenflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLagerflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVerkaufsflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFreiflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBueroflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBueroteilflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFensterfront($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVerwaltungsflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGastroflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGrz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGfz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBmz($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBgf($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGrundstuecksflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySonstflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlZimmer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlSchlafzimmer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlBadezimmer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlSepWc($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlBalkone($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlTerrassen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlLogia($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBalkonTerrasseFlaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlWohnSchlafzimmer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGartenflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKellerflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFensterfrontQm($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGrundstuecksfront($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDachbodenflaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByTeilbarAb($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBeheizbareFlaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlStellplaetze($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPlaetzeGastraum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlBetten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlTagungsraeume($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVermietbareFlaeche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlWohneinheiten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnzahlGewerbeeinheiten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEinliegerwohnung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKubatur($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAusnuetzungsziffer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFlaechevon($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFlaechebis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAusstattKategorie($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWgGeeignet($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRaeumeVeraenderbar($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBad($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKueche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBoden($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKamin($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHeizungsart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBefeuerung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKlimatisiert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFahrstuhlart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStellplatzart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGartennutzung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAusrichtBalkonTerrasse($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMoebliert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRollstuhlgerecht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKabelSatTv($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDvbt($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBarrierefrei($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySauna($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySwimmingpool($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWaschTrockenraum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWintergarten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDvVerkabelung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRampe($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHebebuehne($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKran($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGastterrasse($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStromanschlusswert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKantineCafeteria($val, array $opt=array())
 * @method static RealEstateModel|null findOneByTeekueche($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHallenhoehe($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAngeschlGastronomie($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBrauereibindung($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySporteinrichtungen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWellnessbereich($val, array $opt=array())
 * @method static RealEstateModel|null findOneByServiceleistungen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByTelefonFerienimmobilie($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBreitbandZugang($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBreitbandGeschw($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBreitbandArt($val, array $opt=array())
 * @method static RealEstateModel|null findOneByUmtsEmpfang($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySicherheitstechnik($val, array $opt=array())
 * @method static RealEstateModel|null findOneByUnterkellert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAbstellraum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByFahrradraum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByRolladen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBibliothek($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDachboden($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGaestewc($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKabelkanaele($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySeniorengerecht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBaujahr($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLetztemodernisierung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZustand($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAlterAttr($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBebaubarNach($val, array $opt=array())
 * @method static RealEstateModel|null findOneByErschliessung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByErschliessungUmfang($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBauzone($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAltlasten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVerkaufstatus($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZulieferung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAusblick($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzFlughafen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzFernbahnhof($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzAutobahn($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzUsBahn($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzBus($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzKindergarten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGrundschule($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzHauptschule($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzRealschule($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGesamtschule($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGymnasium($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzZentrum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzEinkaufsmoeglichkeiten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzGaststaetten($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportStrand($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportSee($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportMeer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportSkigebiet($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportSportanlagen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportWandergebiete($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDistanzSportNaherholung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEpart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassGueltigBis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEnergieverbrauchkennwert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassMitwarmwasser($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEndenergiebedarf($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassPrimaerenergietraeger($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassStromwert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassWaermewert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassWertklasse($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassBaujahr($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassAusstelldatum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassJahrgang($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassGebaeudeart($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassEpasstext($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassHwbwert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassHwbklasse($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassFgeewert($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEnergiepassFgeeklasse($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjektadresseFreigeben($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVerfuegbarAb($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAbdatum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBisdatum($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMinMietdauer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMaxMietdauer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVersteigerungstermin($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWbsSozialwohnung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByVermietet($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGruppennummer($val, array $opt=array())
 * @method static RealEstateModel|null findOneByZugang($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLaufzeit($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMaxPersonen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByNichtraucher($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHaustiere($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGeschlecht($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDenkmalgeschuetzt($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAlsFerien($val, array $opt=array())
 * @method static RealEstateModel|null findOneByGewerblicheNutzung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByBranchen($val, array $opt=array())
 * @method static RealEstateModel|null findOneByHochhaus($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjektnrIntern($val, array $opt=array())
 * @method static RealEstateModel|null findOneByObjektnrExtern($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAktivVon($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAktivBis($val, array $opt=array())
 * @method static RealEstateModel|null findOneByOpenimmoObid($val, array $opt=array())
 * @method static RealEstateModel|null findOneByKennungUrsprung($val, array $opt=array())
 * @method static RealEstateModel|null findOneByStandVom($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWeitergabeGenerell($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWeitergabePositiv($val, array $opt=array())
 * @method static RealEstateModel|null findOneByWeitergabeNegativ($val, array $opt=array())
 * @method static RealEstateModel|null findOneBySprache($val, array $opt=array())
 * @method static RealEstateModel|null findOneByTitleImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPlanImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByInteriorViewImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByExteriorViewImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByMapViewImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPanoramaImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByEpassSkalaImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLogoImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByQrImageSRC($val, array $opt=array())
 * @method static RealEstateModel|null findOneByDocuments($val, array $opt=array())
 * @method static RealEstateModel|null findOneByLinks($val, array $opt=array())
 * @method static RealEstateModel|null findOneByAnbieterobjekturl($val, array $opt=array())
 * @method static RealEstateModel|null findOneByPublished($val, array $opt=array())
 *
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDateAdded($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAlias($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvider($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByContactPerson($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnbieternr($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNutzungsart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartKauf($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartMietePacht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartErbpacht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVermarktungsartLeasing($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjektart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZimmerTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWohnungTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHausTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGrundstTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBueroTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHandelTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGastgewTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHallenTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLandTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByParkenTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstigeTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFreizeitTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZinsTyp($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisAufAnfrage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisnetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisbrutto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNettokaltmiete($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaltmiete($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWarmmiete($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFreitextPreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNebenkosten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHeizkosten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHeizkostenEnthalten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHeizkostennetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHeizkostenust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZzgMehrwertsteuer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMietzuschlaege($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHauptmietzinsnetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHauptmietzinsust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPauschalmiete($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBetriebskostennetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBetriebskostenust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEvbnetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEvbust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtmietenetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtmieteust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtmietebrutto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtbelastungnetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtbelastungust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtbelastungbrutto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtkostenprom2von($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtkostenprom2bis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMonatlichekostennetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMonatlichekostenust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMonatlichekostenbrutto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNebenkostenprom2von($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNebenkostenprom2bis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRuecklagenetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRuecklageust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstigekostennetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstigekostenust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstigemietenetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstigemieteust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySummemietenetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySummemieteust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNettomieteprom2von($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNettomieteprom2bis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPacht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByErbpacht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHausgeld($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAbstand($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPreisZeitraumVon($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPreisZeitraumBis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPreisZeiteinheit($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMietpreisProQm($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaufpreisProQm($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvisionspflichtig($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvisionTeilen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvisionTeilenWert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByInnenCourtage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByInnenCourtageMwst($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAussenCourtage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByCourtageHinweis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAussenCourtageMwst($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvisionnetto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvisionust($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByProvisionbrutto($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWaehrung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMwstSatz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMwstGesamt($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByXFache($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNettorendite($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNettorenditeSoll($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNettorenditeIst($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenIst($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenIstPeriode($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenSoll($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMieteinnahmenSollPeriode($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByErschliessungskosten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKaution($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKautionText($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGeschaeftsguthaben($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRichtpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRichtpreisprom2($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpCarport($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpCarportMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpCarportKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpDuplex($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpDuplexMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpDuplexKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpFreiplatz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpFreiplatzMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpFreiplatzKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpGarage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpGarageMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpGarageKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpParkhaus($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpParkhausMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpParkhausKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpTiefgarage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpTiefgarageMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpTiefgarageKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstige($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigeMietpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigeKaufpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigePlatzart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStpSonstigeBemerkung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPlz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByOrt($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStrasse($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHausnummer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBreitengrad($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLaengengrad($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBundesland($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLand($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFlur($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFlurstueck($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGemarkung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEtage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlEtagen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLageImBau($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWohnungsnr($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLageGebiet($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGemeindecode($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRegionalerZusatz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKartenMakro($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKartenMikro($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVirtuelletour($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLuftbildern($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjekttitel($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjektbeschreibung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAusstattBeschr($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLage($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstigeAngaben($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjektText($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDreizeiler($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBeginnAngebotsphase($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBesichtigungstermin($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBesichtigungstermin2($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBeginnBietzeit($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEndeBietzeit($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHoechstgebotZeigen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMindestpreis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZwangsversteigerung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAktenzeichen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZvtermin($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZusatztermin($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAmtsgericht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVerkehrswert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWohnflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNutzflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGesamtflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLadenflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLagerflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVerkaufsflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFreiflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBueroflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBueroteilflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFensterfront($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVerwaltungsflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGastroflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGrz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGfz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBmz($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBgf($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGrundstuecksflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySonstflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlZimmer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlSchlafzimmer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlBadezimmer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlSepWc($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlBalkone($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlTerrassen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlLogia($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBalkonTerrasseFlaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlWohnSchlafzimmer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGartenflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKellerflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFensterfrontQm($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGrundstuecksfront($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDachbodenflaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByTeilbarAb($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBeheizbareFlaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlStellplaetze($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPlaetzeGastraum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlBetten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlTagungsraeume($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVermietbareFlaeche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlWohneinheiten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnzahlGewerbeeinheiten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEinliegerwohnung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKubatur($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAusnuetzungsziffer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFlaechevon($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFlaechebis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAusstattKategorie($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWgGeeignet($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRaeumeVeraenderbar($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBad($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKueche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBoden($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKamin($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHeizungsart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBefeuerung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKlimatisiert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFahrstuhlart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStellplatzart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGartennutzung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAusrichtBalkonTerrasse($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMoebliert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRollstuhlgerecht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKabelSatTv($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDvbt($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBarrierefrei($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySauna($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySwimmingpool($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWaschTrockenraum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWintergarten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDvVerkabelung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRampe($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHebebuehne($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKran($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGastterrasse($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStromanschlusswert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKantineCafeteria($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByTeekueche($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHallenhoehe($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAngeschlGastronomie($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBrauereibindung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySporteinrichtungen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWellnessbereich($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByServiceleistungen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByTelefonFerienimmobilie($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBreitbandZugang($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBreitbandGeschw($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBreitbandArt($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByUmtsEmpfang($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySicherheitstechnik($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByUnterkellert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAbstellraum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByFahrradraum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByRolladen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBibliothek($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDachboden($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGaestewc($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKabelkanaele($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySeniorengerecht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBaujahr($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLetztemodernisierung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZustand($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAlterAttr($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBebaubarNach($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByErschliessung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByErschliessungUmfang($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBauzone($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAltlasten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVerkaufstatus($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZulieferung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAusblick($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzFlughafen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzFernbahnhof($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzAutobahn($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzUsBahn($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzBus($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzKindergarten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGrundschule($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzHauptschule($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzRealschule($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGesamtschule($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGymnasium($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzZentrum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzEinkaufsmoeglichkeiten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzGaststaetten($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportStrand($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportSee($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportMeer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportSkigebiet($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportSportanlagen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportWandergebiete($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDistanzSportNaherholung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEpart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassGueltigBis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEnergieverbrauchkennwert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassMitwarmwasser($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEndenergiebedarf($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassPrimaerenergietraeger($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassStromwert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassWaermewert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassWertklasse($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassBaujahr($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassAusstelldatum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassJahrgang($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassGebaeudeart($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassEpasstext($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassHwbwert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassHwbklasse($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassFgeewert($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEnergiepassFgeeklasse($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjektadresseFreigeben($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVerfuegbarAb($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAbdatum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBisdatum($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMinMietdauer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMaxMietdauer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVersteigerungstermin($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWbsSozialwohnung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByVermietet($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGruppennummer($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByZugang($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLaufzeit($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMaxPersonen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByNichtraucher($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHaustiere($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGeschlecht($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDenkmalgeschuetzt($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAlsFerien($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByGewerblicheNutzung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByBranchen($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByHochhaus($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjektnrIntern($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByObjektnrExtern($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAktivVon($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAktivBis($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByOpenimmoObid($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByKennungUrsprung($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByStandVom($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWeitergabeGenerell($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWeitergabePositiv($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByWeitergabeNegativ($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBySprache($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByTitleImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPlanImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByInteriorViewImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByExteriorViewImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByMapViewImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPanoramaImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByEpassSkalaImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLogoImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByQrImageSRC($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByDocuments($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByLinks($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByAnbieterobjekturl($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findByPublished($val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|RealEstateModel[]|RealEstateModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByDateAdded($val, array $opt=array())
 * @method static integer countByAlias($val, array $opt=array())
 * @method static integer countByProvider($val, array $opt=array())
 * @method static integer countByContactPerson($val, array $opt=array())
 * @method static integer countByAnbieternr($val, array $opt=array())
 * @method static integer countByNutzungsart($val, array $opt=array())
 * @method static integer countByVermarktungsartKauf($val, array $opt=array())
 * @method static integer countByVermarktungsartMietePacht($val, array $opt=array())
 * @method static integer countByVermarktungsartErbpacht($val, array $opt=array())
 * @method static integer countByVermarktungsartLeasing($val, array $opt=array())
 * @method static integer countByObjektart($val, array $opt=array())
 * @method static integer countByZimmerTyp($val, array $opt=array())
 * @method static integer countByWohnungTyp($val, array $opt=array())
 * @method static integer countByHausTyp($val, array $opt=array())
 * @method static integer countByGrundstTyp($val, array $opt=array())
 * @method static integer countByBueroTyp($val, array $opt=array())
 * @method static integer countByHandelTyp($val, array $opt=array())
 * @method static integer countByGastgewTyp($val, array $opt=array())
 * @method static integer countByHallenTyp($val, array $opt=array())
 * @method static integer countByLandTyp($val, array $opt=array())
 * @method static integer countByParkenTyp($val, array $opt=array())
 * @method static integer countBySonstigeTyp($val, array $opt=array())
 * @method static integer countByFreizeitTyp($val, array $opt=array())
 * @method static integer countByZinsTyp($val, array $opt=array())
 * @method static integer countByKaufpreisAufAnfrage($val, array $opt=array())
 * @method static integer countByKaufpreis($val, array $opt=array())
 * @method static integer countByKaufpreisnetto($val, array $opt=array())
 * @method static integer countByKaufpreisbrutto($val, array $opt=array())
 * @method static integer countByNettokaltmiete($val, array $opt=array())
 * @method static integer countByKaltmiete($val, array $opt=array())
 * @method static integer countByWarmmiete($val, array $opt=array())
 * @method static integer countByFreitextPreis($val, array $opt=array())
 * @method static integer countByNebenkosten($val, array $opt=array())
 * @method static integer countByHeizkosten($val, array $opt=array())
 * @method static integer countByHeizkostenEnthalten($val, array $opt=array())
 * @method static integer countByHeizkostennetto($val, array $opt=array())
 * @method static integer countByHeizkostenust($val, array $opt=array())
 * @method static integer countByZzgMehrwertsteuer($val, array $opt=array())
 * @method static integer countByMietzuschlaege($val, array $opt=array())
 * @method static integer countByHauptmietzinsnetto($val, array $opt=array())
 * @method static integer countByHauptmietzinsust($val, array $opt=array())
 * @method static integer countByPauschalmiete($val, array $opt=array())
 * @method static integer countByBetriebskostennetto($val, array $opt=array())
 * @method static integer countByBetriebskostenust($val, array $opt=array())
 * @method static integer countByEvbnetto($val, array $opt=array())
 * @method static integer countByEvbust($val, array $opt=array())
 * @method static integer countByGesamtmietenetto($val, array $opt=array())
 * @method static integer countByGesamtmieteust($val, array $opt=array())
 * @method static integer countByGesamtmietebrutto($val, array $opt=array())
 * @method static integer countByGesamtbelastungnetto($val, array $opt=array())
 * @method static integer countByGesamtbelastungust($val, array $opt=array())
 * @method static integer countByGesamtbelastungbrutto($val, array $opt=array())
 * @method static integer countByGesamtkostenprom2von($val, array $opt=array())
 * @method static integer countByGesamtkostenprom2bis($val, array $opt=array())
 * @method static integer countByMonatlichekostennetto($val, array $opt=array())
 * @method static integer countByMonatlichekostenust($val, array $opt=array())
 * @method static integer countByMonatlichekostenbrutto($val, array $opt=array())
 * @method static integer countByNebenkostenprom2von($val, array $opt=array())
 * @method static integer countByNebenkostenprom2bis($val, array $opt=array())
 * @method static integer countByRuecklagenetto($val, array $opt=array())
 * @method static integer countByRuecklageust($val, array $opt=array())
 * @method static integer countBySonstigekostennetto($val, array $opt=array())
 * @method static integer countBySonstigekostenust($val, array $opt=array())
 * @method static integer countBySonstigemietenetto($val, array $opt=array())
 * @method static integer countBySonstigemieteust($val, array $opt=array())
 * @method static integer countBySummemietenetto($val, array $opt=array())
 * @method static integer countBySummemieteust($val, array $opt=array())
 * @method static integer countByNettomieteprom2von($val, array $opt=array())
 * @method static integer countByNettomieteprom2bis($val, array $opt=array())
 * @method static integer countByPacht($val, array $opt=array())
 * @method static integer countByErbpacht($val, array $opt=array())
 * @method static integer countByHausgeld($val, array $opt=array())
 * @method static integer countByAbstand($val, array $opt=array())
 * @method static integer countByPreisZeitraumVon($val, array $opt=array())
 * @method static integer countByPreisZeitraumBis($val, array $opt=array())
 * @method static integer countByPreisZeiteinheit($val, array $opt=array())
 * @method static integer countByMietpreisProQm($val, array $opt=array())
 * @method static integer countByKaufpreisProQm($val, array $opt=array())
 * @method static integer countByProvisionspflichtig($val, array $opt=array())
 * @method static integer countByProvisionTeilen($val, array $opt=array())
 * @method static integer countByProvisionTeilenWert($val, array $opt=array())
 * @method static integer countByInnenCourtage($val, array $opt=array())
 * @method static integer countByInnenCourtageMwst($val, array $opt=array())
 * @method static integer countByAussenCourtage($val, array $opt=array())
 * @method static integer countByCourtageHinweis($val, array $opt=array())
 * @method static integer countByAussenCourtageMwst($val, array $opt=array())
 * @method static integer countByProvisionnetto($val, array $opt=array())
 * @method static integer countByProvisionust($val, array $opt=array())
 * @method static integer countByProvisionbrutto($val, array $opt=array())
 * @method static integer countByWaehrung($val, array $opt=array())
 * @method static integer countByMwstSatz($val, array $opt=array())
 * @method static integer countByMwstGesamt($val, array $opt=array())
 * @method static integer countByXFache($val, array $opt=array())
 * @method static integer countByNettorendite($val, array $opt=array())
 * @method static integer countByNettorenditeSoll($val, array $opt=array())
 * @method static integer countByNettorenditeIst($val, array $opt=array())
 * @method static integer countByMieteinnahmenIst($val, array $opt=array())
 * @method static integer countByMieteinnahmenIstPeriode($val, array $opt=array())
 * @method static integer countByMieteinnahmenSoll($val, array $opt=array())
 * @method static integer countByMieteinnahmenSollPeriode($val, array $opt=array())
 * @method static integer countByErschliessungskosten($val, array $opt=array())
 * @method static integer countByKaution($val, array $opt=array())
 * @method static integer countByKautionText($val, array $opt=array())
 * @method static integer countByGeschaeftsguthaben($val, array $opt=array())
 * @method static integer countByRichtpreis($val, array $opt=array())
 * @method static integer countByRichtpreisprom2($val, array $opt=array())
 * @method static integer countByStpCarport($val, array $opt=array())
 * @method static integer countByStpCarportMietpreis($val, array $opt=array())
 * @method static integer countByStpCarportKaufpreis($val, array $opt=array())
 * @method static integer countByStpDuplex($val, array $opt=array())
 * @method static integer countByStpDuplexMietpreis($val, array $opt=array())
 * @method static integer countByStpDuplexKaufpreis($val, array $opt=array())
 * @method static integer countByStpFreiplatz($val, array $opt=array())
 * @method static integer countByStpFreiplatzMietpreis($val, array $opt=array())
 * @method static integer countByStpFreiplatzKaufpreis($val, array $opt=array())
 * @method static integer countByStpGarage($val, array $opt=array())
 * @method static integer countByStpGarageMietpreis($val, array $opt=array())
 * @method static integer countByStpGarageKaufpreis($val, array $opt=array())
 * @method static integer countByStpParkhaus($val, array $opt=array())
 * @method static integer countByStpParkhausMietpreis($val, array $opt=array())
 * @method static integer countByStpParkhausKaufpreis($val, array $opt=array())
 * @method static integer countByStpTiefgarage($val, array $opt=array())
 * @method static integer countByStpTiefgarageMietpreis($val, array $opt=array())
 * @method static integer countByStpTiefgarageKaufpreis($val, array $opt=array())
 * @method static integer countByStpSonstige($val, array $opt=array())
 * @method static integer countByStpSonstigeMietpreis($val, array $opt=array())
 * @method static integer countByStpSonstigeKaufpreis($val, array $opt=array())
 * @method static integer countByStpSonstigePlatzart($val, array $opt=array())
 * @method static integer countByStpSonstigeBemerkung($val, array $opt=array())
 * @method static integer countByPlz($val, array $opt=array())
 * @method static integer countByOrt($val, array $opt=array())
 * @method static integer countByStrasse($val, array $opt=array())
 * @method static integer countByHausnummer($val, array $opt=array())
 * @method static integer countByBreitengrad($val, array $opt=array())
 * @method static integer countByLaengengrad($val, array $opt=array())
 * @method static integer countByBundesland($val, array $opt=array())
 * @method static integer countByLand($val, array $opt=array())
 * @method static integer countByFlur($val, array $opt=array())
 * @method static integer countByFlurstueck($val, array $opt=array())
 * @method static integer countByGemarkung($val, array $opt=array())
 * @method static integer countByEtage($val, array $opt=array())
 * @method static integer countByAnzahlEtagen($val, array $opt=array())
 * @method static integer countByLageImBau($val, array $opt=array())
 * @method static integer countByWohnungsnr($val, array $opt=array())
 * @method static integer countByLageGebiet($val, array $opt=array())
 * @method static integer countByGemeindecode($val, array $opt=array())
 * @method static integer countByRegionalerZusatz($val, array $opt=array())
 * @method static integer countByKartenMakro($val, array $opt=array())
 * @method static integer countByKartenMikro($val, array $opt=array())
 * @method static integer countByVirtuelletour($val, array $opt=array())
 * @method static integer countByLuftbildern($val, array $opt=array())
 * @method static integer countByObjekttitel($val, array $opt=array())
 * @method static integer countByObjektbeschreibung($val, array $opt=array())
 * @method static integer countByAusstattBeschr($val, array $opt=array())
 * @method static integer countByLage($val, array $opt=array())
 * @method static integer countBySonstigeAngaben($val, array $opt=array())
 * @method static integer countByObjektText($val, array $opt=array())
 * @method static integer countByDreizeiler($val, array $opt=array())
 * @method static integer countByBeginnAngebotsphase($val, array $opt=array())
 * @method static integer countByBesichtigungstermin($val, array $opt=array())
 * @method static integer countByBesichtigungstermin2($val, array $opt=array())
 * @method static integer countByBeginnBietzeit($val, array $opt=array())
 * @method static integer countByEndeBietzeit($val, array $opt=array())
 * @method static integer countByHoechstgebotZeigen($val, array $opt=array())
 * @method static integer countByMindestpreis($val, array $opt=array())
 * @method static integer countByZwangsversteigerung($val, array $opt=array())
 * @method static integer countByAktenzeichen($val, array $opt=array())
 * @method static integer countByZvtermin($val, array $opt=array())
 * @method static integer countByZusatztermin($val, array $opt=array())
 * @method static integer countByAmtsgericht($val, array $opt=array())
 * @method static integer countByVerkehrswert($val, array $opt=array())
 * @method static integer countByWohnflaeche($val, array $opt=array())
 * @method static integer countByNutzflaeche($val, array $opt=array())
 * @method static integer countByGesamtflaeche($val, array $opt=array())
 * @method static integer countByLadenflaeche($val, array $opt=array())
 * @method static integer countByLagerflaeche($val, array $opt=array())
 * @method static integer countByVerkaufsflaeche($val, array $opt=array())
 * @method static integer countByFreiflaeche($val, array $opt=array())
 * @method static integer countByBueroflaeche($val, array $opt=array())
 * @method static integer countByBueroteilflaeche($val, array $opt=array())
 * @method static integer countByFensterfront($val, array $opt=array())
 * @method static integer countByVerwaltungsflaeche($val, array $opt=array())
 * @method static integer countByGastroflaeche($val, array $opt=array())
 * @method static integer countByGrz($val, array $opt=array())
 * @method static integer countByGfz($val, array $opt=array())
 * @method static integer countByBmz($val, array $opt=array())
 * @method static integer countByBgf($val, array $opt=array())
 * @method static integer countByGrundstuecksflaeche($val, array $opt=array())
 * @method static integer countBySonstflaeche($val, array $opt=array())
 * @method static integer countByAnzahlZimmer($val, array $opt=array())
 * @method static integer countByAnzahlSchlafzimmer($val, array $opt=array())
 * @method static integer countByAnzahlBadezimmer($val, array $opt=array())
 * @method static integer countByAnzahlSepWc($val, array $opt=array())
 * @method static integer countByAnzahlBalkone($val, array $opt=array())
 * @method static integer countByAnzahlTerrassen($val, array $opt=array())
 * @method static integer countByAnzahlLogia($val, array $opt=array())
 * @method static integer countByBalkonTerrasseFlaeche($val, array $opt=array())
 * @method static integer countByAnzahlWohnSchlafzimmer($val, array $opt=array())
 * @method static integer countByGartenflaeche($val, array $opt=array())
 * @method static integer countByKellerflaeche($val, array $opt=array())
 * @method static integer countByFensterfrontQm($val, array $opt=array())
 * @method static integer countByGrundstuecksfront($val, array $opt=array())
 * @method static integer countByDachbodenflaeche($val, array $opt=array())
 * @method static integer countByTeilbarAb($val, array $opt=array())
 * @method static integer countByBeheizbareFlaeche($val, array $opt=array())
 * @method static integer countByAnzahlStellplaetze($val, array $opt=array())
 * @method static integer countByPlaetzeGastraum($val, array $opt=array())
 * @method static integer countByAnzahlBetten($val, array $opt=array())
 * @method static integer countByAnzahlTagungsraeume($val, array $opt=array())
 * @method static integer countByVermietbareFlaeche($val, array $opt=array())
 * @method static integer countByAnzahlWohneinheiten($val, array $opt=array())
 * @method static integer countByAnzahlGewerbeeinheiten($val, array $opt=array())
 * @method static integer countByEinliegerwohnung($val, array $opt=array())
 * @method static integer countByKubatur($val, array $opt=array())
 * @method static integer countByAusnuetzungsziffer($val, array $opt=array())
 * @method static integer countByFlaechevon($val, array $opt=array())
 * @method static integer countByFlaechebis($val, array $opt=array())
 * @method static integer countByAusstattKategorie($val, array $opt=array())
 * @method static integer countByWgGeeignet($val, array $opt=array())
 * @method static integer countByRaeumeVeraenderbar($val, array $opt=array())
 * @method static integer countByBad($val, array $opt=array())
 * @method static integer countByKueche($val, array $opt=array())
 * @method static integer countByBoden($val, array $opt=array())
 * @method static integer countByKamin($val, array $opt=array())
 * @method static integer countByHeizungsart($val, array $opt=array())
 * @method static integer countByBefeuerung($val, array $opt=array())
 * @method static integer countByKlimatisiert($val, array $opt=array())
 * @method static integer countByFahrstuhlart($val, array $opt=array())
 * @method static integer countByStellplatzart($val, array $opt=array())
 * @method static integer countByGartennutzung($val, array $opt=array())
 * @method static integer countByAusrichtBalkonTerrasse($val, array $opt=array())
 * @method static integer countByMoebliert($val, array $opt=array())
 * @method static integer countByRollstuhlgerecht($val, array $opt=array())
 * @method static integer countByKabelSatTv($val, array $opt=array())
 * @method static integer countByDvbt($val, array $opt=array())
 * @method static integer countByBarrierefrei($val, array $opt=array())
 * @method static integer countBySauna($val, array $opt=array())
 * @method static integer countBySwimmingpool($val, array $opt=array())
 * @method static integer countByWaschTrockenraum($val, array $opt=array())
 * @method static integer countByWintergarten($val, array $opt=array())
 * @method static integer countByDvVerkabelung($val, array $opt=array())
 * @method static integer countByRampe($val, array $opt=array())
 * @method static integer countByHebebuehne($val, array $opt=array())
 * @method static integer countByKran($val, array $opt=array())
 * @method static integer countByGastterrasse($val, array $opt=array())
 * @method static integer countByStromanschlusswert($val, array $opt=array())
 * @method static integer countByKantineCafeteria($val, array $opt=array())
 * @method static integer countByTeekueche($val, array $opt=array())
 * @method static integer countByHallenhoehe($val, array $opt=array())
 * @method static integer countByAngeschlGastronomie($val, array $opt=array())
 * @method static integer countByBrauereibindung($val, array $opt=array())
 * @method static integer countBySporteinrichtungen($val, array $opt=array())
 * @method static integer countByWellnessbereich($val, array $opt=array())
 * @method static integer countByServiceleistungen($val, array $opt=array())
 * @method static integer countByTelefonFerienimmobilie($val, array $opt=array())
 * @method static integer countByBreitbandZugang($val, array $opt=array())
 * @method static integer countByBreitbandGeschw($val, array $opt=array())
 * @method static integer countByBreitbandArt($val, array $opt=array())
 * @method static integer countByUmtsEmpfang($val, array $opt=array())
 * @method static integer countBySicherheitstechnik($val, array $opt=array())
 * @method static integer countByUnterkellert($val, array $opt=array())
 * @method static integer countByAbstellraum($val, array $opt=array())
 * @method static integer countByFahrradraum($val, array $opt=array())
 * @method static integer countByRolladen($val, array $opt=array())
 * @method static integer countByBibliothek($val, array $opt=array())
 * @method static integer countByDachboden($val, array $opt=array())
 * @method static integer countByGaestewc($val, array $opt=array())
 * @method static integer countByKabelkanaele($val, array $opt=array())
 * @method static integer countBySeniorengerecht($val, array $opt=array())
 * @method static integer countByBaujahr($val, array $opt=array())
 * @method static integer countByLetztemodernisierung($val, array $opt=array())
 * @method static integer countByZustand($val, array $opt=array())
 * @method static integer countByAlterAttr($val, array $opt=array())
 * @method static integer countByBebaubarNach($val, array $opt=array())
 * @method static integer countByErschliessung($val, array $opt=array())
 * @method static integer countByErschliessungUmfang($val, array $opt=array())
 * @method static integer countByBauzone($val, array $opt=array())
 * @method static integer countByAltlasten($val, array $opt=array())
 * @method static integer countByVerkaufstatus($val, array $opt=array())
 * @method static integer countByZulieferung($val, array $opt=array())
 * @method static integer countByAusblick($val, array $opt=array())
 * @method static integer countByDistanzFlughafen($val, array $opt=array())
 * @method static integer countByDistanzFernbahnhof($val, array $opt=array())
 * @method static integer countByDistanzAutobahn($val, array $opt=array())
 * @method static integer countByDistanzUsBahn($val, array $opt=array())
 * @method static integer countByDistanzBus($val, array $opt=array())
 * @method static integer countByDistanzKindergarten($val, array $opt=array())
 * @method static integer countByDistanzGrundschule($val, array $opt=array())
 * @method static integer countByDistanzHauptschule($val, array $opt=array())
 * @method static integer countByDistanzRealschule($val, array $opt=array())
 * @method static integer countByDistanzGesamtschule($val, array $opt=array())
 * @method static integer countByDistanzGymnasium($val, array $opt=array())
 * @method static integer countByDistanzZentrum($val, array $opt=array())
 * @method static integer countByDistanzEinkaufsmoeglichkeiten($val, array $opt=array())
 * @method static integer countByDistanzGaststaetten($val, array $opt=array())
 * @method static integer countByDistanzSportStrand($val, array $opt=array())
 * @method static integer countByDistanzSportSee($val, array $opt=array())
 * @method static integer countByDistanzSportMeer($val, array $opt=array())
 * @method static integer countByDistanzSportSkigebiet($val, array $opt=array())
 * @method static integer countByDistanzSportSportanlagen($val, array $opt=array())
 * @method static integer countByDistanzSportWandergebiete($val, array $opt=array())
 * @method static integer countByDistanzSportNaherholung($val, array $opt=array())
 * @method static integer countByEnergiepassEpart($val, array $opt=array())
 * @method static integer countByEnergiepassGueltigBis($val, array $opt=array())
 * @method static integer countByEnergiepassEnergieverbrauchkennwert($val, array $opt=array())
 * @method static integer countByEnergiepassMitwarmwasser($val, array $opt=array())
 * @method static integer countByEnergiepassEndenergiebedarf($val, array $opt=array())
 * @method static integer countByEnergiepassPrimaerenergietraeger($val, array $opt=array())
 * @method static integer countByEnergiepassStromwert($val, array $opt=array())
 * @method static integer countByEnergiepassWaermewert($val, array $opt=array())
 * @method static integer countByEnergiepassWertklasse($val, array $opt=array())
 * @method static integer countByEnergiepassBaujahr($val, array $opt=array())
 * @method static integer countByEnergiepassAusstelldatum($val, array $opt=array())
 * @method static integer countByEnergiepassJahrgang($val, array $opt=array())
 * @method static integer countByEnergiepassGebaeudeart($val, array $opt=array())
 * @method static integer countByEnergiepassEpasstext($val, array $opt=array())
 * @method static integer countByEnergiepassHwbwert($val, array $opt=array())
 * @method static integer countByEnergiepassHwbklasse($val, array $opt=array())
 * @method static integer countByEnergiepassFgeewert($val, array $opt=array())
 * @method static integer countByEnergiepassFgeeklasse($val, array $opt=array())
 * @method static integer countByObjektadresseFreigeben($val, array $opt=array())
 * @method static integer countByVerfuegbarAb($val, array $opt=array())
 * @method static integer countByAbdatum($val, array $opt=array())
 * @method static integer countByBisdatum($val, array $opt=array())
 * @method static integer countByMinMietdauer($val, array $opt=array())
 * @method static integer countByMaxMietdauer($val, array $opt=array())
 * @method static integer countByVersteigerungstermin($val, array $opt=array())
 * @method static integer countByWbsSozialwohnung($val, array $opt=array())
 * @method static integer countByVermietet($val, array $opt=array())
 * @method static integer countByGruppennummer($val, array $opt=array())
 * @method static integer countByZugang($val, array $opt=array())
 * @method static integer countByLaufzeit($val, array $opt=array())
 * @method static integer countByMaxPersonen($val, array $opt=array())
 * @method static integer countByNichtraucher($val, array $opt=array())
 * @method static integer countByHaustiere($val, array $opt=array())
 * @method static integer countByGeschlecht($val, array $opt=array())
 * @method static integer countByDenkmalgeschuetzt($val, array $opt=array())
 * @method static integer countByAlsFerien($val, array $opt=array())
 * @method static integer countByGewerblicheNutzung($val, array $opt=array())
 * @method static integer countByBranchen($val, array $opt=array())
 * @method static integer countByHochhaus($val, array $opt=array())
 * @method static integer countByObjektnrIntern($val, array $opt=array())
 * @method static integer countByObjektnrExtern($val, array $opt=array())
 * @method static integer countByAktivVon($val, array $opt=array())
 * @method static integer countByAktivBis($val, array $opt=array())
 * @method static integer countByOpenimmoObid($val, array $opt=array())
 * @method static integer countByKennungUrsprung($val, array $opt=array())
 * @method static integer countByStandVom($val, array $opt=array())
 * @method static integer countByWeitergabeGenerell($val, array $opt=array())
 * @method static integer countByWeitergabePositiv($val, array $opt=array())
 * @method static integer countByWeitergabeNegativ($val, array $opt=array())
 * @method static integer countBySprache($val, array $opt=array())
 * @method static integer countByTitleImageSRC($val, array $opt=array())
 * @method static integer countByImageSRC($val, array $opt=array())
 * @method static integer countByPlanImageSRC($val, array $opt=array())
 * @method static integer countByInteriorViewImageSRC($val, array $opt=array())
 * @method static integer countByExteriorViewImageSRC($val, array $opt=array())
 * @method static integer countByMapViewImageSRC($val, array $opt=array())
 * @method static integer countByPanoramaImageSRC($val, array $opt=array())
 * @method static integer countByEpassSkalaImageSRC($val, array $opt=array())
 * @method static integer countByLogoImageSRC($val, array $opt=array())
 * @method static integer countByQrImageSRC($val, array $opt=array())
 * @method static integer countByDocuments($val, array $opt=array())
 * @method static integer countByLinks($val, array $opt=array())
 * @method static integer countByAnbieterobjekturl($val, array $opt=array())
 * @method static integer countByPublished($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 * @author Fabian Ekert <https://github.com/eki89>
 */

class RealEstateModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_real_estate';

    /**
     * Find published real estate items
     *
     * @param array   $arrColumns  An optional columns array
     * @param array   $arrValues   An optional values array
     * @param array   $arrOptions  An optional options array
     *
     * @return Model\Collection|RealEstateModel[]|RealEstateModel|null A collection of models or null if there are no real estates
     */
    public static function findPublishedBy($arrColumns, $arrValues, array $arrOptions=array())
    {
        $t = static::$strTable;

        if (!static::isPreviewMode($arrOptions) && !static::showUnpublished($arrOptions))
        {
            $arrColumns[] = "$t.published='1'";
        }

        return static::findBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Count published real estate items
     *
     * @param array   $arrColumns  An optional columns array
     * @param array   $arrValues   An optional values array
     * @param array   $arrOptions  An optional options array
     *
     * @return integer The number of real estate rows
     */
    public static function countPublishedBy($arrColumns, $arrValues, array $arrOptions=array())
    {
        $t = static::$strTable;

        if (!static::isPreviewMode($arrOptions) && !static::showUnpublished($arrOptions))
        {
            $arrColumns[] = "$t.published='1'";
        }

        return static::countBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Find all published real estate items by their IDs
     *
     * @param array $arrIds     An array of page IDs
     * @param array $arrOptions An optional options array
     *
     * @return Model\Collection|RealEstateModel[]|RealEstateModel|null A collection of models or null if there are no real estates
     */
    public static function findPublishedByIds($arrIds, array $arrOptions=array())
    {
        if (empty($arrIds) || !is_array($arrIds))
        {
            return null;
        }

        $t = static::$strTable;
        $arrColumns = array("$t.id IN(" . implode(',', array_map('\intval', $arrIds)) . ")");

        if (!static::isPreviewMode($arrOptions) && !static::showUnpublished($arrOptions))
        {
            $arrColumns[] = "$t.published='1'";
        }

        return static::findBy($arrColumns, null, $arrOptions);
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

        if (!static::isPreviewMode($arrOptions) && !static::showUnpublished($arrOptions))
        {
            $arrColumns[] = "$t.published='1'";
        }

        return static::findOneBy($arrColumns, $varId, $arrOptions);
    }

    /**
     * Find published real estate items
     *
     * @param mixed $varValue    The objektnrIntern value
     * @param array $arrOptions  An optional options array
     *
     * @return RealEstateModel|null The model or null if there are no real estate
     */
    public static function findPublishedByObjektnrIntern($varValue, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.objektnrIntern=?");

        if (!static::isPreviewMode($arrOptions) && !static::showUnpublished($arrOptions))
        {
            $arrColumns[] = "$t.published='1'";
        }

        $arrOptions['limit'] = 1;

        return static::findOneBy($arrColumns, $varValue, $arrOptions);
    }

    /**
     * Check if unpublished records should be visible
     *
     * @param array $arrOptions The options array
     *
     * @return boolean
     */
    protected static function showUnpublished(array $arrOptions)
    {
        if (isset($arrOptions['showUnpublished']) && $arrOptions['showUnpublished'])
        {
            return true;
        }

        return false;
    }
}
