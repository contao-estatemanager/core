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


use Contao\BackendTemplate;
use Contao\Hybrid;
use Contao\Input;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;

/**
 * Provide methods to handle real estate filter.
 *
 * @property integer $id
 * @property string  $title
 * @property string  $attributes
 * @property boolean $novalidate
 * @property integer $jumpTo
 * @property string  $customTpl
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class Filter extends Hybrid
{

    /**
     * Model
     * @var FilterModel
     */
    protected $objModel;

    /**
     * Filter session object
     * @var FilterSession
     */
    protected $objFilterSession;

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
     * Remove name attributes in the back end so the filter is not validated
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['CTE']['realEstateFilter'][0], 'UTF-8') . ' ###';
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = 'contao/main.php?do=filter&amp;table=tl_filter_item&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        if (Input::post('reset'))
        {
            $_SESSION['FILTER_DATA'] = array();
            unset($_POST['reset']);
        }

        $this->objFilterSession = FilterSession::getInstance();

        if ($this->customTpl != '')
        {
            $this->strTemplate = $this->customTpl;
        }

        System::loadLanguageFile('tl_real_estate_filter');

        return parent::generate();
    }

    /**
     * Generate the filter
     */
    protected function compile()
    {
        $filterId = $this->filterID ? 'auto_'.$this->filterID : 'auto_filter_'.$this->id;

        $objFilterItem = FilterItemModel::findPublishedByPid($this->id);

        if ($objFilterItem === null)
        {
            return;
        }

        $this->Template->items = '';

        $doNotSubmit = false;
        $arrSubmitted = array();
        $arrLabels = array();
        $arrFilterItems = array();
        $row = 0;
        $max_row = $objFilterItem->count();

        while ($objFilterItem->next())
        {
            $strClass = $GLOBALS['TL_RFI'][$objFilterItem->type];

            // Continue if the class is not defined
            if (!class_exists($strClass))
            {
                continue;
            }

            $arrData = $objFilterItem->row();

            $arrData['rowClass'] = 'row_'.$row . (($row == 0) ? ' row_first' : (($row == ($max_row - 1)) ? ' row_last' : '')) . ((($row % 2) == 0) ? ' even' : ' odd');

            /** @var FilterWidget $objWidget */
            $objFilterWidget = new $strClass($arrData, $this->objModel);
            $objFilterWidget->required = $objFilterItem->mandatory ? true : false;

            // HOOK: load filter item

            // Store values in the session
            if (Input::post('FORM_SUBMIT') == $filterId)
            {
                $objFilterWidget->validate();

                // HOOK: validate filter item

                if ($objFilterWidget->hasErrors())
                {
                    $doNotSubmit = true;
                }

                // Store current value in the session
                elseif ($objFilterWidget->submitInput())
                {
                    if ($objFilterWidget->multiple)
                    {
                        $submitted = $objFilterWidget->getSubmitted();

                        foreach ($submitted as $field => $value)
                        {
                            $arrSubmitted[$field] = $value;
                            $_SESSION['FILTER_DATA'][$field] = $value;
                            unset($_POST[$field]);
                        }
                    }
                    else
                    {
                        $arrSubmitted[$objFilterWidget->name] = $objFilterWidget->value;
                        $_SESSION['FILTER_DATA'][$objFilterWidget->name] = $objFilterWidget->value;
                        unset($_POST[$objFilterWidget->name]);
                    }
                }
            }

            if ($objFilterWidget->name != '' && $objFilterWidget->label != '')
            {
                $arrLabels[$objFilterWidget->name] = $this->replaceInsertTags($objFilterWidget->label); // see #4268
            }

            $arrFilterItems[] = $objFilterWidget->parse();
            ++$row;
        }

        // Process the form data
        if (Input::post('FORM_SUBMIT') == $filterId && !$doNotSubmit)
        {
            $this->processFilterData($arrSubmitted, $arrLabels);
        }

        /** @var PageModel $objPage */
        global $objPage;

        $this->Template->hasError = $doNotSubmit;
        $this->Template->action = $objPage->getFrontendUrl();
        $this->Template->attributes = $this->getAttributes();
        $this->Template->novalidate = $this->novalidate ? ' novalidate' : '';
        $this->Template->filterSubmit = $filterId;
        $this->Template->items = $arrFilterItems;
    }

    /**
     * Process filter data, store it in the session and redirect to the jumpTo or reference page
     *
     * @param array $arrSubmitted
     * @param array $arrLabels
     */
    protected function processFilterData($arrSubmitted, $arrLabels)
    {
        // HOOK: prepare filter data
        if (isset($GLOBALS['TL_HOOKS']['prepareFilterData']) && \is_array($GLOBALS['TL_HOOKS']['prepareFilterData']))
        {
            foreach ($GLOBALS['TL_HOOKS']['prepareFilterData'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrSubmitted, $arrLabels, $this);
            }
        }

        // Store all values in the session
        foreach (array_keys($_POST) as $key)
        {
            $_SESSION['FILTER_DATA'][$key] = Input::post($key, true);
        }

        $_SESSION['FILTER_DATA']['FILTER_SUBMITTED'] = true;

        // HOOK: process filter data
        if (isset($GLOBALS['TL_HOOKS']['processFilterData']) && \is_array($GLOBALS['TL_HOOKS']['processFilterData']))
        {
            foreach ($GLOBALS['TL_HOOKS']['processFilterData'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrSubmitted, $this->arrData, $arrLabels, $this);
            }
        }

        $objJumpTo = $this->objFilterSession->getReferencePage();

        if ($objJumpTo === null && $this->jumpTo)
        {
            $objJumpTo = PageModel::findByPk($this->jumpTo);
        }

        // Redirect if there is a reference page
        if ($objJumpTo instanceof PageModel)
        {
            $this->jumpToOrReload($objJumpTo->row());
        }

        $this->reload();
    }

    /**
     * Get filter attributes as string
     *
     * @return string
     */
    protected function getAttributes()
    {
        $strAttributes = '';
        $arrAttributes = StringUtil::deserialize($this->attributes, true);

        if ($arrAttributes[0] != '')
        {
            $strAttributes .= ' id="' . $arrAttributes[0] . '"';
        }

        if ($arrAttributes[1] != '')
        {
            $strAttributes .= ' class="' . $arrAttributes[1] . '"';
        }

        return $strAttributes;
    }
}
