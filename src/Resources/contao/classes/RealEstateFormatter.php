<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


class RealEstateFormatter
{
    private static $instance = null;

    private $objRealEstate = null;

    private $arrFieldFormats = array();

    private $arrFieldConditions = array();

    private $arrRemovedCollection = array();

    private function __construct()
    {
        $arrFieldFormats = array();
        $arrFieldFormatActions = array();

        $objFieldFormats = FieldFormatModel::findAll();
        $objFieldFormatActions = FieldFormatActionModel::findAll(array('order'=>'pid,sorting'));

        if ($objFieldFormats === null)
        {
            return;
        }

        // add actions to field formats
        if($objFieldFormats->count())
        {
            if($objFieldFormatActions->count())
            {
                $objFieldFormatActions->reset();

                while($objFieldFormatActions->next())
                {
                    if(array_key_exists($objFieldFormatActions->pid, $arrFieldFormatActions))
                    {
                        $arrFieldFormatActions[ $objFieldFormatActions->pid ][] = $objFieldFormatActions->row();
                    }
                    else
                    {
                        $arrFieldFormatActions[ $objFieldFormatActions->pid ] = array( $objFieldFormatActions->row() );
                    }
                }
            }

            $objFieldFormats->reset();

            while($objFieldFormats->next())
            {
                // create field format array
                $arrFieldFormats[ $objFieldFormats->fieldname ] = array(
                    'class'     => $objFieldFormats->cssClass,
                    'actions'   => null
                );

                if($objFieldFormats->useCondition)
                {
                    $this->arrFieldConditions[ $objFieldFormats->fieldname ] = \StringUtil::deserialize($objFieldFormats->conditionFields, true);
                }

                // add actions
                if($arrFieldFormatActions[ $objFieldFormats->id ])
                {
                    $arrFieldFormats[ $objFieldFormats->fieldname ]['actions'] = $arrFieldFormatActions[ $objFieldFormats->id ];
                }
            }

            $this->arrFieldFormats = $arrFieldFormats;
        }

        // load translation files
        \System::loadLanguageFile('tl_real_estate_label');
        \System::loadLanguageFile('tl_real_estate_value');
    }

    /**
     * return formatter instance
     *
     * @return null
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * set real estate model and check field conditions
     *
     * @param $objRealEtate
     */
    public function setRealEstateModel($objRealEtate)
    {
        // set real estate
        $this->objRealEstate = $objRealEtate;

        // determine fields that may not be displayed
        if(count($this->arrFieldConditions))
        {
            foreach ($this->arrFieldConditions as $field => $conditions)
            {
                foreach ($conditions as $condition)
                {
                    if($condition['value'] === '')
                    {
                        if(!$this->objRealEstate->{$condition['field']})
                        {
                            $this->arrRemovedCollection[] = $field;
                        }
                    }
                    else
                    {
                        if($this->objRealEstate->{$condition['field']} != $condition['value'])
                        {
                            $this->arrRemovedCollection[] = $field;
                        }
                    }
                }
            }
        }
    }

    /**
     * return field format class
     *
     * @param $field
     *
     * @return null
     */
    public function getClass($field)
    {
        return $this->arrFieldFormats[ $field ]['class'];
    }

    /**
     * returns a full formatted collection
     *
     * @param $field
     * @return array
     */
    public function getFormattedCollection($field)
    {
        return array(
            'value' => $this->formatValue($field),
            'label' => Translator::translateLabel($field),
            'key'   => $field,
            'class' => $this->getClass($field)
        );
    }

    /**
     * Format field by subordinate actions
     *
     * @param $field
     *
     * @return null
     */
    public function formatValue($field)
    {
        $actions = $this->arrFieldFormats[ $field ]['actions'];

        if($actions === null)
        {
            return Translator::translateValue($this->objRealEstate->{$field}, $field);
        }

        $newValue = $this->formatParser($field, $actions);

        return $newValue;
    }

    /**
     * Parse field
     *
     * @param string $field
     * @param array $actions
     * @return string
     */
    private function formatParser($field, $actions)
    {
        $value = $this->objRealEstate->{$field};

        foreach ($actions as $action)
        {
            switch($action['action'])
            {
                case 'number_format':
                    // ToDo: #$newValue = (isset($value) && $value !== '') ? str_replace(\Config::get('numberFormatDecimals') . '00', '', number_format($value, ($action['decimals'] ?: 0), \Config::get('numberFormatDecimals'), \Config::get('numberFormatThousands'))) : $value;
                    $newValue = (isset($value) && $value !== '') ? number_format($value, ($action['decimals'] ?: 0), \Config::get('numberFormatDecimals'), \Config::get('numberFormatThousands')) : $value;
                    break;
                case 'prepend':
                    $newValue = (isset($value) && $value !== '') ? $action['text'] . $value : '';
                    break;
                case 'append':
                    $newValue = (isset($value) && $value !== '') ? $value . $action['text'] : '';
                    break;
                case 'unserialize':
                    $arrValues = \StringUtil::deserialize($value);

                    if ($arrValues !== null)
                    {
                        $arrValues = Translator::translateValue($arrValues, $field);
                        $newValue = implode($action['seperator'], $arrValues);
                    }

                    break;
                case 'boolToWord':
                    $newValue = boolval($value) ? Translator::translateValue(1) : ($action['necessary'] ? Translator::translateValue(0) : $value);
                    break;
                case 'ucfirst':
                    $newValue = ucfirst( strtolower( $value ) );
                    break;
                case 'date_format':
                    $newValue = date( \Config::get('dateFormat'), $value );
                    break;
                case 'wrap':
                    if(substr_count($action['text'],'%s') === 1)
                    {
                        $newValue = sprintf($action['text'], $value);
                    }
                    break;
                case 'combine':
                    $arrValues = \StringUtil::deserialize($action['elements'], true);

                    $list = array();

                    foreach ($arrValues as $arrValue)
                    {
                        if($arrValue['field'] == $field)
                        {
                            $list[] = $value;
                            continue;
                        }

                        if($this->isFilled($arrValue['field']))
                        {
                            $list[] = $this->formatValue($arrValue['field']);

                            if($arrValue['remove'])
                            {
                                $this->arrRemovedCollection[] = $arrValue['field'];
                            }
                        }
                    }

                    $newValue = implode($action['seperator'], $list);
                    break;
                case 'custom':
                    $template = \Controller::getTemplate($action['customFunction']);
                    $customFunc = include $template;

                    if(is_callable($customFunc['func']))
                    {
                        $newValue = call_user_func_array($customFunc['func'], array($field, $value, $this->objRealEstate, &$this->arrRemovedCollection));
                    }
                    else
                    {
                        $newValue = $value;
                    }

                    break;
            }

            $value = $newValue;
        }

        return $value;
    }

    /**
     * Check whether the field is allowed for formatting
     *
     * @param $field
     *
     * @return bool
     */
    public function isAllowed($field)
    {
        if(in_array($field, $this->arrRemovedCollection)){
            return false;
        }

        return true;
    }

    /**
     * Check whether the field has a valid value
     *
     * @param $field
     *
     * @return bool
     */
    public function isFilled($field)
    {
        if ($this->objRealEstate->{$field})
        {
            return true;
        }

        return false;
    }

    /**
     * Check whether the field has a valid value and can be displayed.
     *
     * @param $field
     *
     * @return bool
     */
    public function isValid($field)
    {
        if ($this->isFilled($field) && $this->isAllowed($field))
        {
            return true;
        }

        return false;
    }
}