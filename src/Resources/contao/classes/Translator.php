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

/**
 * Provide methods to handle real estates translations.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class Translator
{
    /**
     * Translate label by field
     *
     * @param string|array $field
     *
     * @return string|array
     */
    public static function translateLabel($field)
    {
        return static::translate($field, 'tl_real_estate_label');
    }

    /**
     * Translate value by field value and name
     *
     * @param string|array $value
     *
     * @param string $field
     * @return string|array
     */
    public static function translateValue($value, $field = '')
    {
        return static::translate($value, 'tl_real_estate_value', $field);
    }

    /**
     * Translate attribute by field
     *
     * @param $value
     * @param string|array $field
     *
     * @return string|array
     */
    public static function translateAttribute($value, $field = '')
    {
        return static::translate($value, 'tl_real_estate_attribute', $field);
    }

    /**
     * Translate value by field
     *
     * @param string|array $field
     *
     * @return string|array
     */
    public static function translateExpose($field)
    {
        return static::translate($field, 'tl_real_estate_expose');
    }

    /**
     * Translate filter by field
     *
     * @param string|array $field
     *
     * @return string|array
     */
    public static function translateFilter($field)
    {
        return static::translate($field, 'tl_real_estate_filter');
    }

    /**
     * Translate string or array by dictionary
     *
     * @param $strVar
     * @param $dictionary
     * @param string $prefixField
     *
     * @return string|array
     */
    public static function translate($strVar, $dictionary, $prefixField = '')
    {
        if(is_array($strVar))
        {
            foreach ($strVar as $k=> $v)
            {
                $strVar[$k] = static::translate($v, $dictionary, $prefixField);
            }

            return $strVar;
        }

        // Get the field from the DCA to check values and add a prefix if necessary
        $dcaField = $GLOBALS['TL_DCA']['tl_real_estate']['fields'][ $prefixField ];

        if(
            $prefixField &&
            $dcaField &&
            (
                $dcaField['inputType'] == 'select' ||
                $dcaField['inputType'] == 'checkboxWizard' ||
                (
                    $dcaField['inputType'] == 'checkbox' &&
                    boolval($dcaField['eval']['multiple'])
                )
            )
        )
        {
            $strVar = $prefixField . '_' . $strVar;
        }

        return $GLOBALS['TL_LANG'][ $dictionary ][ $strVar ] ?: $strVar;
    }
}