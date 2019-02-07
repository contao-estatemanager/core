<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


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
        if(is_array($field))
        {
            foreach ($field as $k=>$v)
            {
                $field[$k] = static::translateLabel($v);
            }

            return $field;
        }

        return $GLOBALS['TL_LANG']['tl_real_estate_label'][$field] ?: $field;
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
        if(is_array($value))
        {
            foreach ($value as $k=> $v)
            {
                $value[$k] = static::translateValue($v, $field);
            }

            return $value;
        }

        $addPrefix = false;

        // set field prefix for multiple values
        if($field && $GLOBALS['TL_DCA']['tl_real_estate']['fields'][ $field ] && ($GLOBALS['TL_DCA']['tl_real_estate']['fields'][ $field ]['inputType'] == 'select' || $GLOBALS['TL_DCA']['tl_real_estate']['fields'][ $field ]['inputType'] == 'checkboxWizard'))
        {
            $addPrefix = true;
        }

        return $GLOBALS['TL_LANG']['tl_real_estate_value'][ ($addPrefix ? $field . '_' : '') . $value ] ?: $value;
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
        if(is_array($field))
        {
            foreach ($field as $k=>$v)
            {
                $field[$k] = static::translateExpose($v);
            }

            return $field;
        }

        return $GLOBALS['TL_LANG']['tl_real_estate_expose'][$field] ?: $field;
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
        if(is_array($field))
        {
            foreach ($field as $k=>$v)
            {
                $field[$k] = static::translateFilter($v);
            }

            return $field;
        }

        return $GLOBALS['TL_LANG']['tl_real_estate_filter'][$field] ?: $field;
    }
}