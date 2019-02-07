<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


use Contao\PageModel;
use Patchwork\Utf8;

/**
 * Provide methods to handle real estate filter.
 *
 * @property integer $id
 * @property string  $title
 * @property string  $filterID
 * @property string  $method
 * @property boolean $allowTags
 * @property string  $attributes
 * @property boolean $novalidate
 * @property integer $jumpTo
 * @property boolean $sendViaEmail
 * @property boolean $skipEmpty
 * @property string  $format
 * @property string  $recipient
 * @property string  $subject
 * @property boolean $storeValues
 * @property string  $targetTable
 * @property string  $customTpl
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class Filter extends \Hybrid
{

    /**
     * Model
     * @var FilterModel
     */
    protected $objModel;

    /**
     * Key
     * @var string
     */
    protected $strKey = 'filter';

    /**
     * Table
     * @var string
     */
    protected $strTable = 'tl_filter';

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'filter_wrapper';

    /**
     * Initialize the object
     *
     * @param \ContentModel|\ModuleModel|FilterModel $objElement
     */
    public function __construct($objElement)
    {
        if ($objElement instanceof FilterModel)
        {
            $this->strKey = 'id';
        }

        \System::loadLanguageFile('tl_real_estate_filter');

        parent::__construct($objElement);
    }

    /**
     *
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['filter'][0]) . ' ###';
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = 'contao/main.php?do=filter&amp;table=tl_filter_item&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        if ($this->customTpl != '' && TL_MODE == 'FE')
        {
            $this->strTemplate = $this->customTpl;
        }

        return parent::generate();
    }

    /**
     * Generate the filter
     *
     * @return string
     */
    protected function compile()
    {
        $this->strKey = 'filter';

        $doNotSubmit = false;
        $arrSubmitted = array();

        $this->loadDataContainer('tl_filter_item');
        $filterId = $this->filterID ? 'auto_'.$this->filterID : 'auto_filter_'.$this->id;

        $this->Template->items = '';
        $this->Template->hidden = '';
        $this->Template->filterSubmit = $filterId;
        $this->Template->method = ($this->method == 'GET') ? 'get' : 'post';

        $this->initializeSession($filterId);
        $arrLabels = array();

        // Get all form fields
        $arrFilterItems = array();
        $objFilterItems = FilterItemModel::findPublishedByPid($this->id);

        if ($objFilterItems !== null)
        {
            while ($objFilterItems->next())
            {
                // Ignore the name of form fields which do not use a name (see #1268)
                if ($objFilterItems->name != '' && isset($GLOBALS['TL_DCA']['tl_filter_item']['palettes'][$objFilterItems->type]) && preg_match('/[,;]name[,;]/', $GLOBALS['TL_DCA']['tl_filter_item']['palettes'][$objFilterItems->type]))
                {
                    $arrFilterItems[$objFilterItems->name] = $objFilterItems->current();
                }
                else
                {
                    $arrFilterItems[] = $objFilterItems->current();
                }
            }
        }

        // HOOK: compile form fields
        if (isset($GLOBALS['TL_HOOKS']['compileFilterItems']) && \is_array($GLOBALS['TL_HOOKS']['compileFilterItems']))
        {
            foreach ($GLOBALS['TL_HOOKS']['compileFilterItems'] as $callback)
            {
                $this->import($callback[0]);
                $arrFilterItems = $this->{$callback[0]}->{$callback[1]}($arrFilterItems, $filterId, $this);
            }
        }

        // Process the fields
        if (!empty($arrFilterItems) && \is_array($arrFilterItems)) {
            $row = 0;
            $max_row = \count($arrFilterItems);

            foreach ($arrFilterItems as $objFilterItem) {
                /** @var FilterItemModel $objFilterItem */
                $strClass = $GLOBALS['TL_RFI'][$objFilterItem->type];

                // Continue if the class is not defined
                if (!class_exists($strClass)) {
                    continue;
                }

                $arrData = $objFilterItem->row();

                $arrData['decodeEntities'] = true;
                $arrData['rowClass'] = 'row_'.$row . (($row == 0) ? ' row_first' : (($row == ($max_row - 1)) ? ' row_last' : '')) . ((($row % 2) == 0) ? ' even' : ' odd');

                // Submit buttons do not use the name attribute
                if ($objFilterItem->type == 'submit')
                {
                    $arrData['name'] = '';
                }

                /** @var \Widget $objWidget */
                $objWidget = new $strClass($arrData);
                $objWidget->required = $objFilterItem->mandatory ? true : false;

                if ($objFilterItem->type == 'type')
                {
                    $objWidget->filterMode = $this->filterMode;
                }

                // Store current value in the session
                if (\Input::post('FORM_SUBMIT') == $filterId)
                {
                    $skip = $objWidget->validate();

                    // Skip if null
                    if ($skip !== true)
                    {
                        $arrSubmitted[$objFilterItem->name] = $objWidget->value;
                        $_SESSION['FILTER_DATA'][$objFilterItem->name] = $objWidget->value;
                        unset($_POST[$objFilterItem->name]);
                    }
                }
                else
                {
                    // Restore value from session
                    $objWidget->value = $_SESSION['FILTER_DATA'][$objFilterItem->name];
                }

                if ($objWidget->name != '' && $objWidget->label != '')
                {
                    $arrLabels[$objWidget->name] = $this->replaceInsertTags($objWidget->label); // see #4268
                }

                $this->Template->items .= $objWidget->parse();
                ++$row;
            }
        }

        // Process the form data
        if (\Input::post('FORM_SUBMIT') == $filterId && !$doNotSubmit)
        {
            $this->processFilterData($arrSubmitted, $arrLabels, $arrFilterItems);
        }

        // Add a warning to the page title
        if ($doNotSubmit && !\Environment::get('isAjaxRequest'))
        {
            /** @var PageModel $objPage */
            global $objPage;

            $title = $objPage->pageTitle ?: $objPage->title;
            $objPage->pageTitle = $GLOBALS['TL_LANG']['ERR']['filter'] . ' - ' . $title;
        }

        $strAttributes = '';
        $arrAttributes = \StringUtil::deserialize($this->attributes, true);

        if ($arrAttributes[0] != '')
        {
            $strAttributes .= ' id="' . $arrAttributes[0] . '"';
        }

        if ($arrAttributes[1] != '')
        {
            $strAttributes .= ' class="' . $arrAttributes[1] . '"';
        }

        $this->Template->hasError = $doNotSubmit;
        $this->Template->attributes = $strAttributes;
        $this->Template->action = \Environment::get('indexFreeRequest');
        $this->Template->novalidate = $this->novalidate ? ' novalidate' : '';

        return $this->Template->parse();
    }

    /**
     * Process filter data, store it in the session and redirect to the jumpTo or reference page
     *
     * @param array $arrSubmitted
     * @param array $arrLabels
     * @param array $arrFields
     */
    protected function processFilterData($arrSubmitted, $arrLabels, $arrFields)
    {
        if ($this->filterMode == 'neubau' || $this->filterMode == 'referenz')
        {
            $this->reload();
        }

        // Store all values in the session
        foreach (array_keys($_POST) as $key)
        {
            $_SESSION['FILTER_DATA'][$key] = \Input::post($key, true);
        }

        $typeId = $_SESSION['FILTER_DATA']['type'];

        if ($typeId)
        {
            $objType = RealEstateTypeModel::findByPk($typeId);

            if (($objJumpTo = \PageModel::findByPk($objType->referencePage)) instanceof \PageModel)
            {
                $this->jumpToOrReload($objJumpTo->row());
            }
        }

        $groupId = $_SESSION['FILTER_DATA']['groupId'];

        if ($groupId)
        {
            $objGroup = RealEstateGroupModel::findByPk($groupId);

            if (($objJumpTo = \PageModel::findByPk($objGroup->referencePage)) instanceof \PageModel)
            {
                $this->jumpToOrReload($objJumpTo->row());
            }
        }

        if (($objJumpTo = $this->objModel->getRelated('jumpTo')) instanceof \PageModel)
        {
            $this->jumpToOrReload($objJumpTo->row());
        }

        $this->reload();
    }

    /**
     * Initialize the filter in the current session
     *
     * @param string $formId
     */
    protected function initializeSession($formId)
    {
        if (\Input::post('FORM_SUBMIT') != $formId)
        {
            return;
        }

        $_SESSION['FILTER_DATA'] = \is_array($_SESSION['FILTER_DATA']) ? $_SESSION['FILTER_DATA'] : array();
    }
}

class_alias(Filter::class, 'Filter');