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


use Contao\Input;
use Contao\StringUtil;
use Model\Collection;

/**
 * Class FilterTypeSeparated
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class FilterTypeSeparated extends FilterWidget
{

    /**
     * Submit user input
     *
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Multiple
     * @var boolean
     */
    protected $blnMultiple = true;

    /**
     * Value marketing type
     * @var mixed
     */
    protected $varValueMarketingType;

    /**
     * Value real estate type
     * @var mixed
     */
    protected $varValueRealEstateType;

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'filter_type_separated';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-type-separated';

    /**
     * Initialize the object
     *
     * @param array       $arrAttributes Attributes array
     * @param FilterModel $objFilter     Parent filter model
     */
    public function __construct($arrAttributes, $objFilter=null)
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
        // ToDo: Return a backend preview for the filter generator
        if ($this->objFilter === null)
        {
            return '';
        }

        $arrGroups = StringUtil::deserialize($this->objFilter->groups, true);

        $objGroups = $this->sessionManager->getGroupCollectionByIds($arrGroups);

        if ($objGroups->count() === 0)
        {
            return '';
        }

        $objTypes = $this->sessionManager->getTypeCollectionByPids($arrGroups);

        if ($objTypes->count() === 0)
        {
            return '';
        }

        $selectedMarketingType = null;
        $showAllTypes = false;

        // Vermarktungsart Start
        $arrOptions = array();

        $selected = $this->isMarketingOptionSelected(Filter::MARKETING_TYPE_ALL);

        $arrOptions[] = array
        (
            'type'     => 'option',
            'value'    => '',
            'selected' => $selected ? ' selected' : '',
            'label'    => $this->showPlaceholder ? Translator::translateFilter(Filter::MARKETING_TYPE_ALL) : ''
        );

        $selectedMarketingType = Filter::MARKETING_TYPE_ALL;
        $showAllTypes = true;

        $addedMarketingTypes = array();

        foreach ($objGroups as $objGroup)
        {
            if (\in_array($objGroup->vermarktungsart, $addedMarketingTypes))
            {
                continue;
            }

            $addedMarketingTypes[] = $objGroup->vermarktungsart;

            $selected = $this->isMarketingOptionSelected($objGroup->vermarktungsart);

            $arrOptions[] = array
            (
                'type'          => 'option',
                'value'         => $objGroup->vermarktungsart,
                'selected'      => $selected ? ' selected' : '',
                'label'         => Translator::translateFilter($objGroup->vermarktungsart),
                'marketingType' => $objGroup->vermarktungsart
            );

            // Set selected marketing type
            if ($selectedMarketingType === null || $selected)
            {
                $selectedMarketingType = $objGroup->vermarktungsart;
                $showAllTypes = false;
            }
        }

        $this->marketingType = array
        (
            'options' => $arrOptions,
            'class' => Filter::MARKETING_TYPE_KEY
        );
        // Vermarktungsart Stop


        // Objektart Start
        $arrOptions = array();

        $arrOptions[] = array
        (
            'type'     => 'option',
            'value'    => '',
            'selected' => '',
            'label'    => $this->showPlaceholder ? Translator::translateFilter('all_types') : '',
            'show'     => true
        );

        foreach ($objGroups as $objGroup)
        {
            $objGroupTypes = $this->getGroupTypes($objTypes, $objGroup->id);

            if ($objGroupTypes->count() === 0)
            {
                continue;
            }

            foreach ($objGroupTypes as $objGroupType)
            {
                $arrOptions[] = array
                (
                    'type'          => 'option',
                    'value'         => $objGroupType->id,
                    'selected'      => $this->isRealEstateOptionSelected($objGroupType) ? ' selected' : '',
                    'label'         => $this->showLongTitle ? $objGroupType->longTitle : $objGroupType->title,
                    'marketingType' => $objGroup->vermarktungsart,
                    'show'          => !(!$showAllTypes && $objGroup->vermarktungsart != $selectedMarketingType)
                );
            }
        }

        $this->realEstateType = array
        (
            'options'  => $arrOptions,
            'class'    => Filter::PROPERTY_TYPE_KEY
        );
        // Objektart Stop

        // Add labels
        if ($this->showLabel)
        {
            $this->labelMarketingType  = Translator::translateFilter(Filter::MARKETING_TYPE_KEY);
            $this->labelRealEstateType = Translator::translateFilter(Filter::PROPERTY_TYPE_KEY);
        }

        return parent::parse($arrAttributes);
    }

    /**
     * Validate the user input and set the value
     */
    public function validate()
    {
        $varMarketingType = $this->validator(Input::post(Filter::MARKETING_TYPE_KEY, true));
        $varRealEstateType = $this->validator(Input::post(Filter::PROPERTY_TYPE_KEY, true));

        if ($this->hasErrors())
        {
            $this->class = 'error';
        }

        $this->varValueMarketingType = $varMarketingType;
        $this->varValueRealEstateType = $varRealEstateType;
    }

    /**
     * Return submitted fields and values
     *
     * @return array
     */
    public function getSubmitted()
    {
        return array
        (
            Filter::MARKETING_TYPE_KEY => $this->varValueMarketingType,
            Filter::PROPERTY_TYPE_KEY => $this->varValueRealEstateType
        );
    }

    /**
     * Datermine current real estate type by a collection of types
     *
     * @param Collection $objTypes
     * @param $pid
     *
     * @return Collection
     */
    protected function getGroupTypes($objTypes, $pid)
    {
        $arrTypes = array();

        foreach ($objTypes as $objType)
        {
            if ($objType->pid == $pid)
            {
                $arrTypes[] = $objType;
            }
        }

        return new Collection($arrTypes, 'tl_real_estate_type');
    }

    /**
     * Is marketing type option selected
     *
     * @param string $marketingType
     *
     * @return boolean
     */
    protected function isMarketingOptionSelected($marketingType)
    {
        return $this->sessionManager->getSelectedMarketingType() === $marketingType;
    }

    /**
     * Is real estate type option selected
     *
     * @param RealEstateTypeModel $objType
     *
     * @return boolean
     */
    protected function isRealEstateOptionSelected($objType)
    {
        if ($this->sessionManager->getSelectedType() === null)
        {
            return false;
        }

        if ($objType->id === $this->sessionManager->getSelectedType()->id)
        {
            return true;
        }

        return false;
    }

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate() {}
}
