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
     * Marketing type matched flag
     *
     * @var boolean
     */
    private $blnMarketingTypeMatched = false;

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

        $objGroups = RealEstateGroupModel::findPublishedByIds($arrGroups);

        if ($objGroups === null)
        {
            return '';
        }

        $objTypes = RealEstateTypeModel::findPublishedByPids($arrGroups);

        if ($objTypes === null)
        {
            return '';
        }

        $selectedMarketingType = null;
        $showAllTypes = false;

        // Vermarktungsart Start
        $arrOptions = array();

        if ($this->objFilter->addBlankMarketingType)
        {
            $selected = $this->isMarketingOptionSelected('kauf_erbpacht_miete_leasing');

            $arrOptions[] = array
            (
                'type'     => 'option',
                'value'    => '',
                'selected' => $selected ? ' selected' : '',
                'label'    => $this->showPlaceholder ? Translator::translateFilter('kauf_erbpacht_miete_leasing') : ''
            );

            $selectedMarketingType = 'kauf_erbpacht_miete_leasing';
            $showAllTypes = true;
        }

        $addedMarketingTypes = array();

        while ($objGroups->next())
        {
            if (in_array($objGroups->vermarktungsart, $addedMarketingTypes))
            {
                continue;
            }

            $addedMarketingTypes[] = $objGroups->vermarktungsart;

            $selected = $this->isMarketingOptionSelected($objGroups->vermarktungsart);

            // Select marketing type of current real estate type if no marketing type will match
            if (!$this->objFilter->addBlankMarketingType && $this->isMarketingOptionSelected('kauf_erbpacht_miete_leasing') && $this->objFilterSession->getCurrentRealEstateType() !== null)
            {
                $selected = $this->objFilterSession->getCurrentRealEstateType()->vermarktungsart === $objGroups->vermarktungsart;
            }

            $arrOptions[] = array
            (
                'type'          => 'option',
                'value'         => $objGroups->vermarktungsart,
                'selected'      => $selected ? ' selected' : '',
                'label'         => Translator::translateFilter($objGroups->vermarktungsart),
                'marketingType' => $objGroups->vermarktungsart
            );

            // Set selected marketing type
            if ($selectedMarketingType === null || $selected)
            {
                $selectedMarketingType = $objGroups->vermarktungsart;
                $showAllTypes = false;
            }
        }

        $this->marketingType = array
        (
            'options' => $arrOptions,
            'class' => 'real-estate-marketing-type'
        );
        // Vermarktungsart Stop


        // Objektart Start
        $arrOptions = array();

        if ($this->objFilter->addBlankRealEstateType)
        {
            $arrOptions[] = array
            (
                'type'     => 'option',
                'value'    => '',
                'selected' => '',
                'label'    => $this->showPlaceholder ? Translator::translateFilter('all_types') : '',
                'show'     => true
            );
        }

        $objGroups->reset();

        while ($objGroups->next())
        {
            $objGroupTypes = $this->getGroupTypes($objTypes, $objGroups->id);

            if ($objGroupTypes === null)
            {
                continue;
            }

            while ($objGroupTypes->next())
            {
                $arrOptions[] = array
                (
                    'type'          => 'option',
                    'value'         => $objGroupTypes->id,
                    'selected'      => $this->isRealEstateOptionSelected($objGroupTypes) ? ' selected' : '',
                    'label'         => $this->showLongTitle ? $objGroupTypes->longTitle : $objGroupTypes->title,
                    'marketingType' => $objGroups->vermarktungsart,
                    'show'          => !(!$showAllTypes && $objGroups->vermarktungsart != $selectedMarketingType)
                );
            }
        }

        $this->realEstateType = array
        (
            'options'  => $arrOptions,
            'class'    => 'real-estate-type'
        );
        // Objektart Stop

        // Add labels
        if ($this->showLabel)
        {
            $this->labelMarketingType  = Translator::translateFilter('marketingType');
            $this->labelRealEstateType = Translator::translateFilter('realEstateType');
        }

        return parent::parse($arrAttributes);
    }

    /**
     * Validate the user input and set the value
     */
    public function validate()
    {
        $varMarketingType = $this->validator(Input::post('marketing-type', true));
        $varRealEstateType = $this->validator(Input::post('real-estate-type', true));

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
            'marketing-type' => $this->varValueMarketingType,
            'real-estate-type' => $this->varValueRealEstateType
        );
    }

    /**
     * Get current real estate type by a collection of types
     *
     * @return RealEstateTypeModel|null
     */
    protected function getCurrentType()
    {
        if (!$this->objFilter->addBlankRealEstateType)
        {
            return $this->objFilterSession->getCurrentRealEstateType();
        }

        return null;
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

        while ($objTypes->next())
        {
            if ($objTypes->pid == $pid)
            {
                $arrTypes[] = $objTypes->current();
            }
        }

        $objTypes->reset();

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
        return $this->objFilterSession->getCurrentMarketingType() === $marketingType;
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
        if ($this->objFilterSession->getCurrentRealEstateType() === null)
        {
            // Just used, if different addBlankRealEstateType configurations available: Not recommended!
            if (!$this->blnMarketingTypeMatched && !$this->objFilter->addBlankRealEstateType && ($this->objFilterSession->getCurrentMarketingType() === $objType->vermarktungsart || $this->objFilterSession->getCurrentMarketingType() === 'kauf_erbpacht_miete_leasing'))
            {
                if ($objType->defaultType || $objType->getRelated('similarType')->defaultType)
                {
                    $this->blnMarketingTypeMatched = true;
                    return true;
                }
            }

            return false;
        }

        if ($objType->id === $this->objFilterSession->getCurrentRealEstateType()->id)
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
