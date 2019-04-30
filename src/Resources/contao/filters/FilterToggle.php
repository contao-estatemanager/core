<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


/**
 * Class FilterToggle
 *
 * @property integer $pid
 * @property boolean $outputAllItems
 * @property array   $items
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class FilterToggle extends FilterWidget
{

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
        $this->objFilter = $objFilter;

        parent::__construct($arrAttributes);
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
        $objCurrentTyp = $this->getCurrentType();
        $objFilter = FilterModel::findByPk($this->pid);

        if ($objFilter === null)
        {
            return '';
        }

        $this->outputAllItems = !$objFilter->submitOnChange;

        // Determine actual used toggle filter
        if ($objCurrentTyp !== null)
        {
            $arrToggleFilter = \StringUtil::deserialize($objCurrentTyp->toggleFilter, true);
        }
        else
        {
            $arrToggleFilter = \StringUtil::deserialize($objFilter->toggleFilter, true);
        }

        $this->loadDataContainer('tl_filter');
        $arrAvailableFilters = $GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'];

        if ($objFilter->submitOnChange)
        {
            // Remove not used available filters if no interactive toggle is needed
            foreach ($arrAvailableFilters as $group => $groupData)
            {
                if (!in_array($group, $arrToggleFilter))
                {
                    unset($arrAvailableFilters[$group]);
                }
            }
        }

        $arrItems = array();

        // Parse leftover filter items
        foreach ($arrAvailableFilters as $group => $groupData)
        {
            $arrItems[] = $this->parseFilterItem($group, $groupData, in_array($group, $arrToggleFilter) ? true : false, $objCurrentTyp, $objFilter->submitOnChange);
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
                'value'       => $_SESSION['FILTER_DATA'][$field],
                'label'       => $this->showLabel ? $this->translateLabel($name, $field, $objCurrentTyp, $submitOnChange) : '',
                'placeholder' => $this->showPlaceholder ? $this->translateLabel($name, $field, $objCurrentTyp, $submitOnChange) : '',
            );

            // Add options array if needed
            if ($GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'][$name]['options'])
            {
                $options = explode(',', \Config::get($GLOBALS['TL_DCA']['tl_filter']['fields']['toggleFilter']['toggleFields'][$name]['options']));
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

        /** @var \FrontendTemplate|object $objTemplate */
        $objTemplate = new \FrontendTemplate($toggleTemplate);
        $objTemplate->setData($arrFilterItem);

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['parseFilterItem']) && \is_array($GLOBALS['TL_HOOKS']['parseFilterItem']))
        {
            foreach ($GLOBALS['TL_HOOKS']['parseFilterItem'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objTemplate, $arrFilterItem, $this);
            }
        }

        return $objTemplate->parse();
    }

    /**
     * Get current real estate type by a collection of types
     *
     * @return RealEstateTypeModel|null
     */
    protected function getCurrentType()
    {
        if (!$this->objFilter->addBlankMarketingType && !$this->objFilter->addBlankRealEstateType)
        {
            return RealEstateTypeModel::findOneByDefaultType(1);
        }
        elseif ($this->objFilter->addBlankMarketingType && !$this->objFilter->addBlankRealEstateType)
        {
            $objTypeSeparated = FilterItemModel::findPublishedByTypeAndPid('typeSeparated', $this->objFilter->id);

            if ($objTypeSeparated !== null)
            {
                return RealEstateTypeModel::findOneByDefaultType(1);
            }
        }

        return null;
    }

    /**
     * Translates a label
     *
     * @param string                   $type
     * @param string                   $field
     * @param RealEstateTypeModel|null $objCurrentTyp
     * @param boolean                  $submitOnChange
     *
     * @return string
     */
    protected function translateLabel($type, $field, $objCurrentTyp=null, $submitOnChange=false)
    {
        if (!$submitOnChange || $objCurrentTyp === null)
        {
            return Translator::translateFilter($field);
        }
        else
        {
            return Translator::translateFilter($objCurrentTyp->{$type}.'_'.$field);
        }
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
     * Skip validation
     */
    public function validate()
    {
        return true;
    }

    /**
     * Get list filter of all real estate filter
     *
     * @return array
     */
    public static function getImmoManagerConfig()
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
            $arrFilters = \StringUtil::deserialize($objFilters->toggleFilter, true);

            if (count($arrFilters))
            {
                $strFilter = "'".implode("','", $arrFilters)."'";
            }

            $filters[] = $objFilters->id.": {addBlankMarketingType: ".json_encode(boolval($objFilters->addBlankMarketingType)).", addBlankRealEstateType: ".json_encode(boolval($objFilters->addBlankRealEstateType)).", submitOnChange: ".json_encode(boolval($objFilters->submitOnChange)).", filter: [".$strFilter."]}";
        }


        $defaultType = '';
        $types = array();

        while ($objTypes->next())
        {
            $arrFilters = \StringUtil::deserialize($objTypes->toggleFilter, true);

            $types[] = $objTypes->id.": {filter: ['".implode("','", $arrFilters)."'], switchType: ".$objTypes->similarType."}";

            if ($objTypes->defaultType)
            {
                $defaultType = $objTypes->id;
            }
        }


        $return = array();

        $return[] = "defaultType: ".$defaultType;
        $return[] = "filters: ".PHP_EOL."{".implode(','.PHP_EOL, $filters)."}";
        $return[] = "types: ".PHP_EOL."{".implode(','.PHP_EOL, $types)."}";

        return implode(','.PHP_EOL, $return);
    }
}
