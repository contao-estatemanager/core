<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


class FilterDefaultFilter extends \Widget
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'filter_default_filter';

    /**
     * The CSS class prefix
     * @var string
     */
    protected $strPrefix = 'widget widget-default-filter real-estate-filter';

    /**
     * The fields config array
     * @var array
     */
    protected $arrFields = array
    (
        'price' => array
        (
            'price_from',
            'price_to'
        ),
        'per' => array
        (
            'price_per'
        ),
        'room' => array
        (
            'room_from',
            'room_to'
        ),
        'area' => array
        (
            'area_from',
            'area_to'
        ),
        'period' => array
        (
            'period_from',
            'period_to'
        )
    );

    /**
     * The real estate type model
     * @var RealEstateTypeModel
     */
    protected $objCurrentType = null;

    /**
     * Initialize the object
     *
     * @param array $arrAttributes An optional attributes array
     */
    public function __construct($arrAttributes=null)
    {
        parent::__construct($arrAttributes);

        $this->objCurrentType = RealEstateTypeModel::findCurrentType();
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
            case 'required':
            case 'mandatory':
                // Ignore
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
        // ToDo: Add "usePlaceholder" (s. filter_default_filter_compact.html5)

        $objFilterItemType = FilterItemModel::findByPk($this->typeItem);

        if ($objFilterItemType === null)
        {
            return '';
        }

        $this->outputAllFilter = !$objFilterItemType->submitOnChange;

        if (!$objFilterItemType->addBlankOption)
        {
            $this->objCurrentType = RealEstateTypeModel::findOneByDefaultType(1);
        }

        if ($this->objCurrentType !== null)
        {
            $arrFilter = \StringUtil::deserialize($this->objCurrentType->listFilter, true);

            $this->setLabels(!!$objFilterItemType->submitOnChange);
        }
        else
        {
            $objFilter = FilterModel::findByPk($this->pid);

            $arrFilter = \StringUtil::deserialize($objFilter->listFilter, true);

            $this->setLabels(!$objFilterItemType->submitOnChange);
        }

        foreach ($arrFilter as $index => $filter)
        {
            $arrFilter[$index] = $filter['group'];
        }

        foreach ($this->arrFields as $group => $fields)
        {
            if (!in_array($group, $arrFilter))
            {
                continue;
            }

            $addGroup = 'addGroup'.ucfirst($group);
            $this->{$addGroup} = true;

            foreach ($fields as $field)
            {
                $this->{$field} = $_SESSION['FILTER_DATA'][$field];
            }
        }

        return parent::parse($arrAttributes);
    }

    /**
     * Set translations and values for filter
     *
     * @param boolean $useTypeFields
     */
    private function setLabels($useTypeFields)
    {
        $this->labelFrom = Translator::translateFilter('from');
        $this->labelTo = Translator::translateFilter('to');

        if ($useTypeFields)
        {
            $this->labelPriceFrom = Translator::translateFilter($this->objCurrentType->price.'_from');
            $this->labelPriceTo = Translator::translateFilter($this->objCurrentType->price.'_to');
            $this->labelPrice = Translator::translateFilter($this->objCurrentType->price);

            $this->labelAreaFrom = Translator::translateFilter($this->objCurrentType->area.'_from');
            $this->labelAreaTo = Translator::translateFilter($this->objCurrentType->area.'_to');
            $this->labelArea = Translator::translateFilter($this->objCurrentType->area);
        }
        else
        {
            $this->labelPriceFrom = Translator::translateFilter('price_from');
            $this->labelPriceTo = Translator::translateFilter('price_to');
            $this->labelPrice = Translator::translateFilter('price');

            $this->labelAreaFrom = Translator::translateFilter('area_from');
            $this->labelAreaTo = Translator::translateFilter('area_to');
            $this->labelArea = Translator::translateFilter('area');
        }

        $this->labelPer = Translator::translateFilter('price_per');
        $this->labelPerMonth = Translator::translateFilter('per_month');
        $this->labelPerSquareMeter = Translator::translateFilter('per_square_meter');

        $this->labelRoomFrom = Translator::translateFilter('room_from');
        $options = array();
        foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $option)
        {
            $options[$option] =  str_replace('%s', $option, Translator::translateFilter('from_x_rooms'));
        }
        $this->roomFromOptions = $options;

        $this->labelRoomTo = Translator::translateFilter('room_to');
        $options = array();
        foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $option)
        {
            $options[$option] = str_replace('%s', $option, Translator::translateFilter('to_x_rooms'));
        }
        $this->roomToOptions = $options;
        $this->labelRoom = Translator::translateFilter('room');

        $this->labelPeriodFrom = Translator::translateFilter('period_from');
        $this->labelPeriodTo = Translator::translateFilter('period_to');
        $this->labelPeriod = Translator::translateFilter('period');
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
    public static function getConfigFilterCriteria()
    {
        $objTypes = RealEstateTypeModel::findByPublished(1);

        if ($objTypes->count() < 1)
        {
            return '';
        }

        $return = array();

        while ($objTypes->next())
        {
            $arrGroups = array();
            $arrFilterGroups = \StringUtil::deserialize($objTypes->listFilter);

            foreach ($arrFilterGroups as $group)
            {
                $arrGroups[] = $group['group'];
            }

            $return[] = $objTypes->id.": {fields: ['".implode("','", $arrGroups)."'], switchType: ".$objTypes->similarType."}";
        }

        return implode(','.PHP_EOL, $return);
    }
}
