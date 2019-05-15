<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


use Patchwork\Utf8;

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
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['filter'][0]) . ' ###';
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = 'contao/main.php?do=filter&amp;table=tl_filter_item&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->objFilterSession = FilterSession::getInstance();

        if ($this->customTpl != '')
        {
            $this->strTemplate = $this->customTpl;
        }

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

        // HOOK: compile filter items

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
            if (\Input::post('FORM_SUBMIT') == $filterId)
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
        if (\Input::post('FORM_SUBMIT') == $filterId && !$doNotSubmit)
        {
            $this->processFilterData($arrSubmitted, $arrLabels);
        }

        $this->Template->hasError = $doNotSubmit;
        $this->Template->action = \Environment::get('indexFreeRequest');
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
            $_SESSION['FILTER_DATA'][$key] = \Input::post($key, true);
        }

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
            $objJumpTo = \PageModel::findByPk($this->jumpTo);
        }

        // Redirect if there is a reference page
        if ($objJumpTo instanceof \PageModel)
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
        $arrAttributes = \StringUtil::deserialize($this->attributes, true);

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

    /**
     * Generate the filter
     */
    protected function compile2()
    {
        $doNotSubmit = false;
        $arrSubmitted = array();

        $this->loadDataContainer('tl_filter_item');
        $filterId = $this->filterID ? 'auto_'.$this->filterID : 'auto_filter_'.$this->id;

        $this->Template->items = '';
        $this->Template->hidden = '';
        $this->Template->filterSubmit = $filterId;

        $this->initializeSession($filterId); // ToDo: Auf Session Service umbauen.
        $arrLabels = array();

        // Get all form fields
        $arrItems = array();
        $objItems = FilterItemModel::findPublishedByPid($this->id);

        if ($objItems !== null)
        {
            while ($objItems->next())
            {
                // Ignore the name of form fields which do not use a name (see #1268)
                if ($objItems->name != '' && isset($GLOBALS['TL_DCA']['tl_filter_item']['palettes'][$objItems->type]) && preg_match('/[,;]name[,;]/', $GLOBALS['TL_DCA']['tl_filter_item']['palettes'][$objItems->type]))
                {
                    $arrItems[$objItems->name] = $objItems->current();
                }
                else
                {
                    $arrItems[] = $objItems->current();
                }
            }
        }

        // HOOK: compile filter items
        if (isset($GLOBALS['TL_HOOKS']['compileFilterItems']) && \is_array($GLOBALS['TL_HOOKS']['compileFilterItems']))
        {
            foreach ($GLOBALS['TL_HOOKS']['compileFilterItems'] as $callback)
            {
                $this->import($callback[0]);
                $arrItems = $this->{$callback[0]}->{$callback[1]}($arrItems, $filterId, $this);
            }
        }

        // Process the fields
        if (!empty($arrItems) && \is_array($arrItems)) {
            $row = 0;
            $max_row = \count($arrItems);

            foreach ($arrItems as $objItem)
            {
                /** @var FilterItemModel $objItem */
                $strClass = $GLOBALS['TL_RFI'][$objItem->type];

                // Continue if the class is not defined
                if (!class_exists($strClass))
                {
                    continue;
                }

                $arrData = $objItem->row();

                $arrData['decodeEntities'] = true; //ToDo: Wofür wird das übergeben?
                $arrData['rowClass'] = 'row_'.$row . (($row == 0) ? ' row_first' : (($row == ($max_row - 1)) ? ' row_last' : '')) . ((($row % 2) == 0) ? ' even' : ' odd');

                // Increase the row count if its a password field
                if ($objItem->type == 'todo')
                {
                    ++$row;
                    ++$max_row;

                    $arrData['rowClassConfirm'] = 'row_'.$row . (($row == ($max_row - 1)) ? ' row_last' : '') . ((($row % 2) == 0) ? ' even' : ' odd');
                }

                // Submit buttons do not use the name attribute
                if ($objItem->type == 'submit')
                {
                    $arrData['name'] = '';
                }

                /** @var FilterWidget $objWidget */
                $objWidget = new $strClass($arrData);
                $objWidget->required = $objItem->mandatory ? true : false;

                // HOOK: load form field callback
                if (isset($GLOBALS['TL_HOOKS']['loadFilterItem']) && \is_array($GLOBALS['TL_HOOKS']['loadFilterItem']))
                {
                    foreach ($GLOBALS['TL_HOOKS']['loadFilterItem'] as $callback)
                    {
                        $this->import($callback[0]);
                        $objWidget = $this->{$callback[0]}->{$callback[1]}($objWidget, $filterId, $this->arrData, $this);
                    }
                }

                // Store current value in the session
                if (\Input::post('FORM_SUBMIT') == $filterId)
                {
                    $objWidget->validate();

                    // HOOK: validate filter item callback
                    if (isset($GLOBALS['TL_HOOKS']['validateFilterItem']) && \is_array($GLOBALS['TL_HOOKS']['validateFilterItem']))
                    {
                        foreach ($GLOBALS['TL_HOOKS']['validateFilterItem'] as $callback)
                        {
                            $this->import($callback[0]);
                            $objWidget = $this->{$callback[0]}->{$callback[1]}($objWidget, $filterId, $this->arrData, $this);
                        }
                    }

                    if ($objWidget->hasErrors())
                    {
                        $doNotSubmit = true;
                    }

                    // Store current value in the session
                    elseif ($objWidget->submitInput())
                    {
                        $arrSubmitted[$objItem->name] = $objWidget->value;
                        $_SESSION['FILTER_DATA'][$objItem->name] = $objWidget->value;
                        unset($_POST[$objItem->name]);
                    }
                }

                if ($objWidget->name != '' && $objWidget->label != '')
                {
                    $arrLabels[$objWidget->name] = $this->replaceInsertTags($objWidget->label);
                }

                $this->Template->items .= $objWidget->parse();
                ++$row;
            }
        }

        // Process the form data
        if (\Input::post('FORM_SUBMIT') == $filterId && !$doNotSubmit)
        {
            $this->processFilterData($arrSubmitted, $arrLabels, $arrItems);
        }

        // Add a warning to the page title
        if ($doNotSubmit && !\Environment::get('isAjaxRequest'))
        {
            /** @var \PageModel $objPage */
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
        $this->Template->action = \Environment::get('indexFreeRequest');
        $this->Template->attributes = $strAttributes;
        $this->Template->novalidate = $this->novalidate ? ' novalidate' : '';
    }

    /**
     * Process filter data, store it in the session and redirect to the jumpTo or reference page
     *
     * @param array $arrSubmitted
     * @param array $arrLabels
     * @param array $arrFields
     */
    protected function processFilterData2($arrSubmitted, $arrLabels, $arrFields)
    {
        // HOOK: prepare filter data callback
        if (isset($GLOBALS['TL_HOOKS']['prepareFilterData']) && \is_array($GLOBALS['TL_HOOKS']['prepareFilterData']))
        {
            foreach ($GLOBALS['TL_HOOKS']['prepareFilterData'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrSubmitted, $arrLabels, $arrFields, $this);
            }
        }

        // Store all values in the session
        foreach (array_keys($_POST) as $key)
        {
            $_SESSION['FILTER_DATA'][$key] = \Input::post($key, true);
        }

        /*$typeId = $_SESSION['FILTER_DATA']['type'];

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
        }*/

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
