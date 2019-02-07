<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


class FilterType extends \Widget
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'filter_type';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-type';

    /**
     * Groups
     * @var array
     */
    protected $arrGroups = array();

    /**
     * Filter mode
     * @var string
     */
    protected $filterMode;

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
            case 'filterMode':
                $this->filterMode = $varValue;
                break;
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

            case 'groups':
                $this->arrGroups = \StringUtil::deserialize($varValue);
                break;

            default:
                parent::__set($strKey, $varValue);
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
        $strClass = 'select';

        // Custom class
        if ($this->strClass != '')
        {
            $strClass .= ' ' . $this->strClass;
        }

        $this->strClass = $strClass;
        $this->addGroupField = false;
        $this->addTypeField = true;

        $filter = RealEstateFilter::getInstance();

        $this->import('Database');

        $arrSelect = array();
        $arrOptions = array();

        switch ($this->mode)
        {
            case 'group_type':
                $objGroups = RealEstateGroupModel::findPublishedByIds($this->arrGroups);

                if ($objGroups === null)
                {
                    break;
                }

                $objCurrentType = RealEstateTypeModel::findCurrentRealEstateType();

                while ($objGroups->next())
                {
                    if (!$this->mergeOptions)
                    {
                        $arrOptions[] = array
                        (
                            'type'     => 'group_start',
                            'label'    => $objGroups->title
                        );
                    }

                    $objTypes = RealEstateTypeModel::findPublishedByPid($objGroups->id);

                    if ($objTypes === null)
                    {
                        break;
                    }

                    while ($objTypes->next())
                    {
                        $arrOptions[] = array
                        (
                            'type'     => 'option',
                            'value'    => $objTypes->id,
                            'selected' => $objTypes->id === $objCurrentType->id ? ' selected' : '',
                            'label'    => $this->showLongTitle ? $objTypes->longTitle : $objTypes->title
                        );
                    }

                    if (!$this->mergeOptions)
                    {
                        $arrOptions[] = array
                        (
                            'type' => 'group_end'
                        );
                    }
                }

                $arrSelect[] = array
                (
                    'options' => $arrOptions,
                    'class' => 'real-estate-filter-type',
                    'submitOnChange' => $this->submitOnChange
                );
                break;

            case 'group':
                $objGroups = RealEstateGroupModel::findPublishedByIds($this->arrGroups);

                if ($objGroups === null)
                {
                    break;
                }

                $skip = array();

                while ($objGroups->next())
                {
                    if (in_array($objGroups->vermarktungsart, $skip))
                    {
                        continue;
                    }

                    $arrOptions[] = array
                    (
                        'type'     => 'option',
                        'value'    => $objGroups->vermarktungsart,
                        'selected' => $filter->isGroupSelected($objGroups->vermarktungsart) ? ' selected' : '',
                        'label'    => Translator::translateFilter($objGroups->vermarktungsart),
                        'group'    => $objGroups->vermarktungsart
                    );

                    $skip[] = $objGroups->vermarktungsart;
                }

                $arrSelect[] = array
                (
                    'options' => $arrOptions,
                    'class' => 'real-estate-filter-group'
                );

                $this->addGroupField = true;
                $this->addTypeField = false;
                break;

            case 'type_by_group':
                $show = false;
                $showFirst = false;
                $groups = array();

                $objFilterItem = FilterItemModel::findPublishedById($this->groupItem);

                if ($objFilterItem === null)
                {
                    break;
                }

                $arrGroups = \StringUtil::deserialize($objFilterItem->groups);
                $objGroups = RealEstateGroupModel::findPublishedByIds($arrGroups);

                if ($objGroups === null)
                {
                    break;
                }

                $objCurrentType = $filter->type;

                if (!$this->addBlankOption)
                {
                    $objCurrentType = RealEstateTypeModel::findOneByDefaultType(1);
                }

                while ($objGroups->next())
                {
                    $groups[$objGroups->vermarktungsart][] = $objGroups->id;
                }

                foreach ($groups as $group => $arrIds)
                {
                    if ($this->addBlankOption)
                    {
                        $arrOptions[] = array
                        (
                            'type'     => 'option',
                            'value'    => '',
                            'selected' => ($objCurrentType === null) ? ' selected' : '',
                            'label'    => 'Alle'
                        );

                        if ($objCurrentType === null && $group === $_SESSION['FILTER_DATA']['group'])
                        {
                            $show = true;
                        }
                    }
                    elseif ($objCurrentType === null && ((isset($_SESSION['FILTER_DATA']) && $group === $_SESSION['FILTER_DATA']['group']) || !isset($_SESSION['FILTER_DATA']) && $group === 'miete_leasing'))
                    {
                        $show = true;
                        $showFirst = true;
                    }

                    $objTypes = RealEstateTypeModel::findPublishedByModeAndPids($this->filterMode, $arrIds);

                    while ($objTypes->next())
                    {
                        $arrOptions[] = array
                        (
                            'type'     => 'option',
                            'value'    => $objTypes->id,
                            'selected' => ($objCurrentType !== null && $objTypes->id === $objCurrentType->id || $objTypes->id === $objCurrentType->similarType || $showFirst) ? ' selected' : '',
                            'label'    => $this->showLongTitle ? $objTypes->longTitle : $objTypes->title
                        );

                        if ($objCurrentType !== null && $objTypes->id === $objCurrentType->id)
                        {
                            $show = true;
                        }

                        $showFirst = false;
                    }

                    $arrSelect[] = array
                    (
                        'options' => $arrOptions,
                        'class' => 'real-estate-filter-type',
                        'group' => $group,
                        'disabled' => !$show,
                        'submitOnChange' => $this->submitOnChange
                    );

                    $arrOptions = array();
                    $show = false;
                }
                break;

            case 'type_of_group':
                $objCurrentType = RealEstateTypeModel::findCurrentRealEstateType();
                $objTypes = RealEstateTypeModel::findPublishedByPid($this->group);

                while ($objTypes->next())
                {
                    $arrOptions[] = array
                    (
                        'type'     => 'option',
                        'value'    => $objTypes->id,
                        'selected' => $objTypes->id === $objCurrentType->id ? ' selected' : '',
                        'label'    => $this->showLongTitle ? $objTypes->longTitle : $objTypes->title
                    );
                }

                $arrSelect[] = array
                (
                    'options' => $arrOptions,
                    'submitOnChange' => $this->submitOnChange
                );
                break;
        }

        $this->selects = $arrSelect;

        return parent::parse($arrAttributes);
    }

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate() {}
}
