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
use Contao\Controller;
use Contao\StringUtil;
use Contao\System;

/**
 * Provide methods to handle real estate formats.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class RealEstateFormatter
{
    /**
     * RealEstateFormatter Instance
     * @var null
     */
    private static $instance = null;

    /**
     * RealEstate Object
     * @var null
     */
    private $objRealEstate = null;

    /**
     * Field formats and actions
     * @var array
     */
    private $arrFieldFormats = array();

    /**
     * Field format conditions
     * @var array
     */
    private $arrFieldConditions = array();

    /**
     * Removed fields collection
     * @var array
     */
    private $arrRemovedCollection = array();


    /**
     * RealEstateFormatter
     *
     * Initialize the object
     */
    private function __construct()
    {
        $arrFieldFormats = array();
        $arrFieldFormatActions = array();

        $objFieldFormats = FieldFormatModel::findAll();
        $objFieldFormatActions = FieldFormatActionModel::findAll(array('order'=>'pid,sorting'));

        if ($objFieldFormats === null || $objFieldFormatActions === null)
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
                    'force'     => !!$objFieldFormats->forceOutput,
                    'actions'   => null
                );

                if($objFieldFormats->useCondition)
                {
                    $this->arrFieldConditions[ $objFieldFormats->fieldname ] = StringUtil::deserialize($objFieldFormats->conditionFields, true);
                }

                // add actions
                if($arrFieldFormatActions[ $objFieldFormats->id ])
                {
                    $arrFieldFormats[ $objFieldFormats->fieldname ]['actions'] = $arrFieldFormatActions[ $objFieldFormats->id ];
                }
            }

            $this->arrFieldFormats = $arrFieldFormats;
        }
    }

    /**
     * Instantiate the RealEstateFormatter object
     *
     * @return RealEstateFormatter The object instance
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * Set real estate model and check field conditions
     *
     * @param RealEstateModel $objRealEstate
     */
    public function setRealEstateModel(RealEstateModel $objRealEstate): void
    {
        // set current real estate
        $this->objRealEstate = $objRealEstate;

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
     * Return field format class
     *
     * @param $field
     *
     * @return string
     */
    public function getClass($field): ?string
    {
        return $this->arrFieldFormats[ $field ]['class'];
    }

    /**
     * returns a fully formatted collection or null for values that should be skipped afterwards
     *
     * @param string $field
     * @return array|null
     */
    public function getFormattedCollection(string $field): ?array
    {
        $val = $this->formatValue($field);

        if($val === false)
        {
            return null;
        }

        return array(
            'value' => $val,
            'raw'   => $this->objRealEstate->{$field},
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
     * @return string
     */
    public function formatValue(string $field)
    {
        $actions = $this->arrFieldFormats[ $field ]['actions'];

        if($actions === null)
        {
            return Translator::translateValue($this->objRealEstate->{$field}, $field);
        }

        return $this->formatParser($field, $actions);
    }

    /**
     * Cut text to given max length
     *
     * @param string $text
     * @param int $max
     * @param string $textOverflow
     *
     * @return string
     */
    public function shortenText(string $text, int $max=0, string $textOverflow = '...'): string
    {
        if ($max > 0)
        {
            $txt = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));

            while (substr($txt, $max, 1) != " ")
            {
                $max++;

                if ($max > strlen($txt))
                {
                    break;
                }
            }

            return substr($txt, 0, $max) . $textOverflow;
        }

        return $text;
    }

    /**
     * Parse field
     *
     * @param string $field
     * @param array|null $actions
     * @return string
     */
    private function formatParser(string $field, ?array $actions)
    {
        $value = $this->objRealEstate->{$field};

        foreach ($actions as $action)
        {
            switch($action['action'])
            {
                // Format a number e.g (PHP number_format)
                case 'number_format':
                    $newValue = (isset($value) && $value !== '') ? number_format($value, ($action['decimals'] ?: 0), Config::get('numberFormatDecimals'), Config::get('numberFormatThousands')) : $value;
                    break;

                // Adds text at the beginning of the value
                case 'prepend':
                    $newValue = (isset($value) && $value !== '') ? $action['text'] . $value : '';
                    break;

                // Adds text at the end of the value
                case 'append':
                    $newValue = (isset($value) && $value !== '') ? $value . $action['text'] : '';
                    break;

                // Deserialized a value to an array and displays it in a list separated by a given seperator
                case 'unserialize':
                    $arrValues = StringUtil::deserialize($value);

                    if ($arrValues !== null)
                    {
                        $arrValues = Translator::translateValue($arrValues, $field);
                        $newValue = implode($action['seperator'], $arrValues);
                    }

                    break;

                // Converts boolean values to readable values
                case 'boolToWord':
                    $newValue = boolval($value) ? Translator::translateValue('yes') : ($action['necessary'] ? Translator::translateValue('no') : $value);
                    break;

                // Make a string's first character uppercase (PHP ucfirst)
                case 'ucfirst':
                    $newValue = ucfirst( strtolower( $value ) );
                    break;

                // Format a local time/date (PHP date)
                case 'date_format':
                    $newValue = date( Config::get('dateFormat'), $value );
                    break;

                // Wrap a value with its own content using PHP sprintf function
                case 'wrap':
                    if(substr_count($action['text'],'%s') === 1)
                    {
                        $newValue = sprintf($action['text'], $value);
                    }
                    break;

                // Merges multiple fields by a seperator
                case 'combine':
                    $arrValues = StringUtil::deserialize($action['elements'], true);

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

                // Custom function (see templates/actions)
                case 'custom':
                    $template = Controller::getTemplate($action['customFunction']);
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
     * @param string $field
     *
     * @return bool
     */
    public function isAllowed(string $field): bool
    {
        if(in_array($field, $this->arrRemovedCollection)){
            return false;
        }

        return true;
    }

    /**
     * Check whether the field has a valid value
     *
     * @param string $field
     *
     * @return bool
     */
    public function isFilled(string $field): bool
    {
        if($this->arrFieldFormats[ $field ]['force'])
        {
            return true;
        }

        if ($this->objRealEstate->{$field})
        {
            if(!(is_numeric($this->objRealEstate->{$field}) && intval($this->objRealEstate->{$field}) === 0))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether the field has a valid value and can be displayed.
     *
     * @param string $field
     *
     * @return bool
     */
    public function isValid(string $field): bool
    {
        if ($this->isFilled($field) && $this->isAllowed($field))
        {
            return true;
        }

        return false;
    }
}
