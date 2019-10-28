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


use Contao\Environment;

/**
 * Provide methods to handle inquiries.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class RealEstateInquiry
{
    public function attachFile(&$arrSubmitted, &$arrLabels, &$arrFields, $form)
    {
        if ($form->attachRealEstateFeedbackXml)
        {
            $objTemplate = new \FrontendTemplate($form->realEstateFeedbackTemplate);
            $objTemplate->setData($arrSubmitted);

            $objRealEstate = RealEstateModel::findPublishedByIdOrAlias(\Input::get('items'));

            if ($objRealEstate !== null)
            {
                $realEstate = new RealEstate($objRealEstate, null);
                $arrRealEstateData = array();

                $arrRealEstateData['anbieter_id'] = $realEstate->anbieternr;
                $arrRealEstateData['oobj_id'] = $realEstate->objektnrIntern;
                $arrRealEstateData['exposeUrl'] = Environment::get('http_origin') . Environment::get('request_uri');
                $arrRealEstateData['vermarktungsart'] = $this->getMarketingtype($realEstate);
                $arrRealEstateData['bezeichnung'] = $realEstate->getTitle();
                if ($realEstate->etage)
                {
                    $arrRealEstateData['etage'] = $realEstate->etage;
                }
                if ($realEstate->hausnummer)
                {
                    $arrRealEstateData['whg_nr'] = $realEstate->hausnummer;
                }
                if ($realEstate->strasse)
                {
                    $arrRealEstateData['strasse'] = $realEstate->strasse;
                }
                if ($realEstate->ort)
                {
                    $arrRealEstateData['ort'] = $realEstate->ort;
                }
                if ($realEstate->land)
                {
                    $arrRealEstateData['land'] = $realEstate->land;
                }
                $arrRealEstateData['preis'] = $realEstate->getMainPrice()['value'];
                if ($realEstate->anzahlZimmer)
                {
                    $arrRealEstateData['anzahl_zimmer'] = $realEstate->anzahlZimmer;
                }
                $arrRealEstateData['flaeche'] = $realEstate->getMainArea()['value'];

                $objTemplate->addRealEstateData = true;
                $objTemplate->realEstate = $arrRealEstateData;
            }

            $fileName = 'feedback' . time() . '.xml';
            $filePath = 'system/tmp/' . $fileName;

            \File::putContent($filePath, $objTemplate->parse());

            $_SESSION['FILES']['feedback'] = array
            (
                'tmp_name' => TL_ROOT . '/' . $filePath,
                'name'     => 'feedback',
                'type'     => 'xml'
            );
        }
    }

    private function getMarketingtype($realEstate)
    {
        if ($realEstate->vermarktungsartKauf)
        {
            return 'KAUF';
        }
        elseif ($realEstate->vermarktungsartErbpacht)
        {
            return 'ERBPACHT';
        }
        elseif ($realEstate->vermarktungsartMietePacht)
        {
            return 'MIETE_PACHT';
        }
        elseif ($realEstate->vermarktungsartLeasing)
        {
            return 'LEASING';
        }
    }
}
