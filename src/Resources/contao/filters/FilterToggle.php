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
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\StringUtil;

/**
 * Class FilterToggle
 *
 * @property integer $pid
 * @property boolean $outputAllItems
 * @property array   $items
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class FilterToggle extends FilterWidget
{

    /**
     * Submit user input
     *
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Values
     * @var array
     */
    protected $arrValues;

    /**
     * Multiple
     * @var boolean
     */
    protected $blnMultiple = true;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'filter_toggle';

    /**
     * The CSS class prefix
     * @var string
     */
    protected $strPrefix = 'widget widget-toggle';

    /**
     * The filter item array
     * @var array
     */
    protected $arrItems = array();

    /**
     * Initialize the object
     *
     * @param array $arrAttributes An optional attributes array
     * @param FilterModel $objFilter     Parent filter model
     */
    public function __construct($arrAttributes=null, $objFilter=null)
    {
        parent::__construct($arrAttributes, $objFilter);
    }

    /**
     * Add specific attributes
     *
     * @param string $strKey   The attribute name
     * @param mixed  $varValue The attribute value
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'mandatory':
                if ($varValue)
                {
                    $this->arrAttributes['required'] = 'required';
                }
                else
                {
                    unset($this->arrAttributes['required']);
                }
                parent::__set($strKey, $varValue);
                break;

            case 'items':
                $this->arrItems = $varValue;
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Return an object property
     *
     * @param string $strKey The property name
     *
     * @return mixed The property value
     */
    public function __get($strKey)
    {
        switch ($strKey)
        {
            case 'groups':
                return $this->arrGroups;
                break;

            case 'items':
                return $this->arrItems;
                break;

            default:
                return parent::__get($strKey);
                break;
        }
    }

    /**
     * Parse the template file and return it as string
     *
     * @param array $arrAttributes An optional attributes array
     *
     * @return string The template markup
     */
    public function parse($arrAttributes=null)
    {
        // ToDo: Return a backend preview for the filter generator
        if ($this->objFilter === null)
        {
            return '';
        }

        $objCurrentTyp = $this->getCurrentType();

        $this->outputAllItems = !$this->objFilter->submitOnChange;

        // Determine actual used toggle filter
        if ($objCurrentTyp !== null)
        {
            $arrToggleFilter = StringUtil::deserialize($objCurrentTyp->toggleFilter, true);
        }
        else
        {
            $arrToggleFilter = StringUtil::deserialize($this->objFilter->toggleFilter, true);
        }

        $this->loadDataContainer('tl_filter');
        $arrAvailableFilters = $GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'];

        if ($this->objFilter->submitOnChange)
        {
            // Remove not used available filters if no interactive toggle is needed
            foreach ($arrAvailableFilters as $group => $groupData)
            {
                if (!\in_array($group, $arrToggleFilter))
                {
                    unset($arrAvailableFilters[$group]);
                }
            }
        }

        $arrItems = array();

        // Parse leftover filter items
        foreach ($arrAvailableFilters as $group => $groupData)
        {
            $arrItems[] = $this->parseFilterItem($group, $groupData, \in_array($group, $arrToggleFilter) ? true : false, $objCurrentTyp, $this->objFilter->submitOnChange);
        }

        $this->items = $arrItems;

        return parent::parse($arrAttributes);
    }

    /**
     * Parse an item and return it as string
     *
     * @param string                   $name
     * @param array                    $groupData
     * @param boolean                  $visible
     * @param RealEstateTypeModel|null $objCurrentTyp
     * @param boolean                  $submitOnChange
     *
     * @return string
     */
    protected function parseFilterItem($name, $groupData, $visible=true, $objCurrentTyp=null, $submitOnChange=false)
    {
        $arrFilterItem = array
        (
            'show'   => $visible,
            'name'   => $name
        );

        foreach ($groupData['fields'] as $field)
        {
            $filterItem = array
            (
                'show'        => $this->rangeMode ? true : $field !== $groupData['hide'],
                'name'        => $field,
                'value'       => $_SESSION['FILTER_DATA'][$field] ?? '', // ToDo: Use SessionManager "get" Method
                'label'       => $this->showLabel ? $this->translateLabel($name, $field, $objCurrentTyp, $submitOnChange) : '',
                'placeholder' => $this->showPlaceholder ? $this->translateLabel($name, $field, $objCurrentTyp, $submitOnChange) : '',
            );

            // Add options array if needed
            if ($GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'][$name]['options'] ?? null)
            {
                $strOptionsField = $GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'][$name]['options'];
                $strOptions = $this->objFilter->{$strOptionsField} ? $this->objFilter->{$strOptionsField} : Config::get($strOptionsField);

                $options = array_map('trim', explode(',', $strOptions));
                $arrOptions = array();

                foreach ($options as $value)
                {
                    $arrOptions[$value] = $this->translateOption($field, $value);
                }

                $filterItem['options'] = $arrOptions;
            }

            $arrFilterItem['filters'][] = $filterItem;
        }

        $toggleTemplate = 'toggle_' . $arrFilterItem['name'];

        /** @var FrontendTemplate|object $objTemplate */
        $objTemplate = new FrontendTemplate($toggleTemplate);
        $objTemplate->setData($arrFilterItem);

        // HOOK: add custom logic
        if (isset($GLOBALS['CEM_HOOKS']['parseFilterItem']) && \is_array($GLOBALS['CEM_HOOKS']['parseFilterItem']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['parseFilterItem'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objTemplate, $arrFilterItem, $this);
            }
        }

        return $objTemplate->parse();
    }

    /**
     * Validate the user input and set the value
     */
    public function validate()
    {
        $arrValues = array();

        $this->loadDataContainer('tl_filter');
        $arrToggleGroups = $GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'];

        foreach ($arrToggleGroups as $group)
        {
            foreach ($group['fields'] as $field)
            {
                $arrValues[$field] = $this->validator(Input::post($field, true), $group['rgxp']);
            }
        }

        if ($this->hasErrors())
        {
            $this->class = 'error';
        }

        $this->arrValues = $arrValues;
    }

    /**
     * Return submitted fields and values
     *
     * @return array
     */
    public function getSubmitted()
    {
        return $this->arrValues;
    }

    /**
     * Get current real estate type by a collection of types
     *
     * @return RealEstateTypeModel|null
     * @throws \Exception
     */
    protected function getCurrentType()
    {
        return $this->objFilterSession->getCurrentRealEstateType();
    }

    /**
     * Translates a label
     *
     * @param string                   $type
     * @param string                   $field
     * @param RealEstateTypeModel|null $objCurrentType
     * @param boolean                  $submitOnChange
     *
     * @return string
     */
    protected function translateLabel($type, $field, $objCurrentType=null, $submitOnChange=false)
    {
        if (!$submitOnChange)
        {
            return Translator::translateFilter($field);
        }

        if ($objCurrentType !== null)
        {
            $label = '';

            if ($type === 'price' || $type === 'area')
            {
                $label .= $objCurrentType->{$type}.'_';
            }

            $field = $label . $field;
        }

        return Translator::translateFilter($field);
    }

    /**
     * Translates an option
     *
     * @param string $field
     * @param string $value
     *
     * @return string
     */
    protected function translateOption($field, $value)
    {
        return str_replace('%s', $value, Translator::translateFilter($field.'_x'));
    }

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate() {}

    /**
     * Get list filter of all real estate filter
     *
     * @return string
     */
    public static function getEstateManagerConfig()
    {
        $objFilters = FilterModel::findAll();
        $objTypes = RealEstateTypeModel::findByPublished(1);

        if ($objFilters === null || $objTypes === null)
        {
            return '';
        }


        $filters = array();

        while ($objFilters->next())
        {
            $strFilter = '';
            $arrFilters = StringUtil::deserialize($objFilters->toggleFilter, true);

            if (\count($arrFilters))
            {
                $strFilter = "'".implode("','", $arrFilters)."'";
            }

            $filters[] = $objFilters->id.": {submitOnChange: ".json_encode(boolval($objFilters->submitOnChange)).", filter: [".$strFilter."]}";
        }


        $types = array();

        while ($objTypes->next())
        {
            $arrFilters = \StringUtil::deserialize($objTypes->toggleFilter, true);

            $types[] = $objTypes->id.": {filter: ['".implode("','", $arrFilters)."'], switchType: ".$objTypes->similarType."}";
        }


        $return = array();

        $return[] = "filters: ".PHP_EOL."{".implode(','.PHP_EOL, $filters)."}";
        $return[] = "types: ".PHP_EOL."{".implode(','.PHP_EOL, $types)."}";

        return implode(','.PHP_EOL, $return);
    }
}
