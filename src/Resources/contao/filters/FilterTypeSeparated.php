<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


use Contao\StringUtil;
use Model\Collection;

/**
 * Class FilterTypeSeparated
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class FilterTypeSeparated extends FilterWidget
{

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

        $objCurrentType = $this->getCurrentType();
        $selectedMarketingType = null;
        $showAllTypes = false;

        // Vermarktungsart Start
        $arrOptions = array();

        if ($this->objFilter->addBlankMarketingType)
        {
            $arrOptions[] = array
            (
                'type'     => 'option',
                'value'    => '',
                'selected' => '',
                'label'    => Translator::translateFilter('kauf_erbpacht_miete_leasing')
            );

            $selectedMarketingType = 'kauf_erbpacht_miete_leasing';
            $showAllTypes = true;
        }

        while ($objGroups->next())
        {
            $selected = $this->isMarketingOptionSelected($objGroups->vermarktungsart);

            $arrOptions[] = array
            (
                'type'          => 'option',
                'value'         => $objGroups->vermarktungsart,
                'selected'      => $selected,
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
                'label'    => '---',
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
                    'selected'      => $this->isOptionSelected($objGroupTypes, $objCurrentType) ? ' selected' : '',
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

        return parent::parse($arrAttributes);
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
            return RealEstateTypeModel::findOneByDefaultType(1);
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
     * Is marketing option selected
     *
     * @param string $marketingType
     *
     * @return boolean
     */
    protected function isMarketingOptionSelected($marketingType)
    {
        return false;
    }

    /**
     * Datermine current real estate type by a collection of types
     *
     * @param RealEstateTypeModel $objType
     * @param RealEstateTypeModel $objCurrentType
     *
     * @return boolean
     */
    protected function isOptionSelected($objType, $objCurrentType)
    {
        if ($objCurrentType === null)
        {
            return false;
        }

        if ($objType->id === $objCurrentType->id)
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
