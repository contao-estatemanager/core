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


use Contao\Config;
use Contao\Date;
use Contao\Email;
use Contao\Environment;
use Contao\File;
use Contao\Form;
use Contao\FormModel;
use Contao\FrontendTemplate;
use Contao\FrontendUser;
use Contao\Input;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\Widget;

/**
 * Provide methods to handle expose forms.
 *
 * @property integer $id
 * @property string  $title
 * @property boolean $allowTags
 * @property integer $jumpTo
 * @property boolean $sendViaEmail
 * @property boolean $skipEmpty
 * @property string  $format
 * @property string  $subject
 * @property boolean $storeValues
 * @property string  $targetTable
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class ExposeForm extends Form
{

	/**
	 * Key
	 * @var string
	 */
	protected $strKey = 'id';

    /**
     * Module
     * @var ExposeModuleEnquiryForm
     */
	protected $objExposeModule;

    /**
     * Initialize the object
     *
     * @param FormModel               $objForm
     * @param ExposeModuleEnquiryForm $objExposeModule
     */
    public function __construct($objForm, $objExposeModule)
    {
        $this->objExposeModule = $objExposeModule;

        parent::__construct($objForm);
    }

    /**
     * Set a new strKey.
     *
     * @param string $key  The new strKey of object ExposeForm.
     */
    public function setStrKey($key)
    {
        $this->strKey = $key;
    }

    /**
     * Process form data, store it in the session and redirect to the jumpTo page
     *
     * @param array $arrSubmitted
     * @param array $arrLabels
     * @param array $arrFields
     */
    protected function processFormData($arrSubmitted, $arrLabels, $arrFields)
    {
        // HOOK: prepare form data callback
        if (isset($GLOBALS['TL_HOOKS']['prepareFormData']) && is_array($GLOBALS['TL_HOOKS']['prepareFormData']))
        {
            foreach ($GLOBALS['TL_HOOKS']['prepareFormData'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrSubmitted, $arrLabels, $arrFields, $this);
            }
        }

        $objRealEstate = RealEstateModel::findPublishedByIdOrAlias(Input::get('items'));
        $objContactPerson = ContactPersonModel::findByPk($objRealEstate->contactPerson);
        $objProvider = ProviderModel::findByPk($objContactPerson->pid);

        // Send form data via e-mail
        if ($this->sendViaEmail)
        {
            $keys = array();
            $values = array();
            $fields = array();
            $message = '';

            foreach ($arrSubmitted as $k=>$v)
            {
                if ($k == 'cc')
                {
                    continue;
                }

                $v = StringUtil::deserialize($v);

                // Skip empty fields
                if ($this->skipEmpty && !is_array($v) && !strlen($v))
                {
                    continue;
                }

                // Add field to message
                $message .= ($arrLabels[$k] ?? ucfirst($k)) . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";

                // Prepare XML file
                if ($this->format == 'xml')
                {
                    $fields[] = array
                    (
                        'name' => $k,
                        'values' => (is_array($v) ? $v : array($v))
                    );
                }

                // Prepare CSV file
                if ($this->format == 'csv')
                {
                    $keys[] = $k;
                    $values[] = (is_array($v) ? implode(',', $v) : $v);
                }
            }

            $recipients = $this->getRecipients($objProvider, $objContactPerson);

            // Format recipients
            foreach ($recipients as $k=>$v)
            {
                $recipients[$k] = str_replace(array('[', ']', '"'), array('<', '>', ''), $v);
            }

            $email = new Email();
            $email->subject = $this->subject;

            // Get subject and message
            if ($this->format == 'email')
            {
                $message = $arrSubmitted['message'];
                $email->subject = $arrSubmitted['subject'];
            }

            if($objProvider->useOwnSender)
            {
                $email->from = $objProvider->senderEmail;
                $email->fromName = $objProvider->senderName;
            }
            else
            {
                // Set the admin e-mail as "from" address
                $email->from = $GLOBALS['TL_ADMIN_EMAIL'];
                $email->fromName = $GLOBALS['TL_ADMIN_NAME'];
            }

            // Get the "reply to" address
            if (!empty(Input::post('email', true)))
            {
                $replyTo = Input::post('email', true);

                // Add the name
                if (!empty(Input::post('name')))
                {
                    $replyTo = '"' . Input::post('name') . '" <' . $replyTo . '>';
                }
                elseif (!empty(Input::post('firstname')) && !empty(Input::post('lastname')))
                {
                    $replyTo = '"' . Input::post('firstname') . ' ' . Input::post('lastname') . '" <' . $replyTo . '>';
                }

                $email->replyTo($replyTo);
            }

            // Fallback to default subject
            if (!$email->subject)
            {
                $email->subject = $this->replaceInsertTags($this->subject, false);
            }

            // Send copy to sender
            if (!empty($arrSubmitted['cc']))
            {
                $email->sendCc(Input::post('email', true));
                unset($_SESSION['FORM_DATA']['cc']);
            }

            // Attach XML file
            if ($this->format == 'xml')
            {
                $objTemplate = new FrontendTemplate('form_xml');
                $objTemplate->fields = $fields;
                $objTemplate->charset = Config::get('characterSet');

                $email->attachFileFromString($objTemplate->parse(), 'form.xml', 'application/xml');
            }

            // Attach CSV file
            if ($this->format == 'csv')
            {
                $email->attachFileFromString(StringUtil::decodeEntities('"' . implode('";"', $keys) . '"' . "\n" . '"' . implode('";"', $values) . '"'), 'form.csv', 'text/comma-separated-values');
            }

            if ($this->objExposeModule->attachFeedbackXml)
            {
                $this->attachFeedbackXml($objRealEstate, $arrSubmitted);
            }

            $uploaded = '';

            // Attach uploaded files
            if (!empty($_SESSION['FILES']))
            {
                foreach ($_SESSION['FILES'] as $file)
                {
                    // Add a link to the uploaded file
                    if ($file['uploaded'])
                    {
                        $uploaded .= "\n" . Environment::get('base') . StringUtil::stripRootDir(dirname($file['tmp_name'])) . '/' . rawurlencode($file['name']);
                        continue;
                    }

                    $email->attachFileFromString(file_get_contents($file['tmp_name']), $file['name'], $file['type']);
                }
            }

            $uploaded = strlen(trim($uploaded)) ? "\n\n---\n" . $uploaded : '';
            $email->text = StringUtil::decodeEntities(trim($message)) . $uploaded . "\n\n";

            // Send the e-mail
            $email->sendTo($recipients);
        }

        // Store the values in the database
        if ($this->storeValues && $this->targetTable)
        {
            $arrSet = array();

            // Add the timestamp
            if ($this->Database->fieldExists('tstamp', $this->targetTable))
            {
                $arrSet['tstamp'] = time();
            }

            // Fields
            foreach ($arrSubmitted as $k=>$v)
            {
                if ($k != 'cc' && $k != 'id')
                {
                    $arrSet[$k] = $v;

                    // Convert date formats into timestamps (see #6827)
                    if ($arrSet[$k] != '' && in_array($arrFields[$k]->rgxp, array('date', 'time', 'datim')))
                    {
                        $objDate = new Date($arrSet[$k], Date::getFormatFromRgxp($arrFields[$k]->rgxp));
                        $arrSet[$k] = $objDate->tstamp;
                    }
                }
            }

            // Files
            if (!empty($_SESSION['FILES']))
            {
                foreach ($_SESSION['FILES'] as $k=>$v)
                {
                    if ($v['uploaded'])
                    {
                        $arrSet[$k] = StringUtil::stripRootDir($v['tmp_name']);
                    }
                }
            }

            // HOOK: store form data callback
            if (isset($GLOBALS['TL_HOOKS']['storeFormData']) && is_array($GLOBALS['TL_HOOKS']['storeFormData']))
            {
                foreach ($GLOBALS['TL_HOOKS']['storeFormData'] as $callback)
                {
                    $this->import($callback[0]);
                    $arrSet = $this->{$callback[0]}->{$callback[1]}($arrSet, $this);
                }
            }

            // Set the correct empty value (see #6284, #6373)
            foreach ($arrSet as $k=>$v)
            {
                if ($v === '')
                {
                    $arrSet[$k] = Widget::getEmptyValueByFieldType($GLOBALS['TL_DCA'][$this->targetTable]['fields'][$k]['sql']);
                }
            }

            // Do not use Models here (backwards compatibility)
            $this->Database->prepare("INSERT INTO " . $this->targetTable . " %s")->set($arrSet)->execute();
        }

        // Store all values in the session
        foreach (array_keys($_POST) as $key)
        {
            $_SESSION['FORM_DATA'][$key] = $this->allowTags ? Input::postHtml($key, true) : Input::post($key, true);
        }

        // Store the submit time to invalidate the session later on
        $_SESSION['FORM_DATA']['SUBMITTED_AT'] = time();

        $arrFiles = $_SESSION['FILES'] ?? null;

        // HOOK: process form data callback
        if (isset($GLOBALS['TL_HOOKS']['processFormData']) && is_array($GLOBALS['TL_HOOKS']['processFormData']))
        {
            foreach ($GLOBALS['TL_HOOKS']['processFormData'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrSubmitted, $this->arrData, $arrFiles, $arrLabels, $this);
            }
        }

        $_SESSION['FILES'] = array(); // DO NOT CHANGE

        // Add a log entry
        if (FE_USER_LOGGED_IN)
        {
            $this->import(FrontendUser::class, 'User');
            $this->log('Form "' . $this->title . '" has been submitted by "' . $this->User->username . '".', __METHOD__, TL_FORMS);
        }
        else
        {
            $this->log('Form "' . $this->title . '" has been submitted by a guest.', __METHOD__, TL_FORMS);
        }

        // Check whether there is a jumpTo page
        if (($objJumpTo = $this->objModel->getRelated('jumpTo')) instanceof PageModel)
        {
            $this->jumpToOrReload($objJumpTo->row());
        }

        $this->reload();
    }

    /**
     * Get the list of involved recipient
     *
     * @param ProviderModel      $objProvider
     * @param ContactPersonModel $objContactPerson
     *
     * @return array
     */
    protected function getRecipients($objProvider, $objContactPerson)
    {
        $recipients = array();

        if ($objProvider->forwardingMode === 'contact')
        {
            if ($objContactPerson->email_direkt)
            {
                $recipients[] = $objContactPerson->email_direkt;
            }
            else
            {
                $recipients[] = $objProvider->email;
            }
        }
        elseif ($objProvider->forwardingMode === 'provider')
        {
            $recipients[] = $objProvider->email;
        }
        elseif ($objProvider->forwardingMode === 'both')
        {
            $recipients[] = $objProvider->email;

            if ($objContactPerson->email_direkt)
            {
                $recipients[] = $objContactPerson->email_direkt;
            }
        }

        return $recipients;
    }

    protected function attachFeedbackXml($objRealEstate, $arrSubmitted)
    {
        $objFeedbackTemplate = new FrontendTemplate($this->objExposeModule->feedbackXmlTemplate);
        $objFeedbackTemplate->setData($arrSubmitted);

        $realEstate = new RealEstate($objRealEstate, null);
        $arrRealEstateData = array();

        $arrRealEstateData['anbieter_id'] = $realEstate->anbieternr;
        $arrRealEstateData['oobj_id'] = $realEstate->objektnrExtern;
        $arrRealEstateData['exposeUrl'] = Environment::get('http_origin') . Environment::get('request_uri');
        $arrRealEstateData['vermarktungsart'] = $this->getMarketingtype($realEstate);
        $arrRealEstateData['bezeichnung'] = $realEstate->title;
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

        $objFeedbackTemplate->addRealEstateData = true;
        $objFeedbackTemplate->realEstateData = $arrRealEstateData;
        $objFeedbackTemplate->realEstate = $realEstate;

        $fileName = 'feedback' . time() . '.xml';
        $filePath = 'system/tmp/' . $fileName;

        File::putContent($filePath, $objFeedbackTemplate->parse());

        $_SESSION['FILES']['feedback'] = array
        (
            'tmp_name' => TL_ROOT . '/' . $filePath,
            'name'     => 'feedback.xml',
            'type'     => 'xml'
        );
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
