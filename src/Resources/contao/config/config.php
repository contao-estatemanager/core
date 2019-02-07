<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Back end modules
array_insert($GLOBALS['BE_MOD'], 1, array
(
    'real_estate' => array
    (
        'provider' => array
        (
            'tables'            => array('tl_provider', 'tl_contact_person'),
            'hideInNavigation'  => true,
        ),
        'real_estate' => array
        (
            'tables'            => array('tl_real_estate'),
        ),
        'type' => array
        (
            'tables'            => array('tl_real_estate_group', 'tl_real_estate_type'),
            'hideInNavigation'  => true,
        ),
        'filter' => array
        (
            'tables'            => array('tl_filter', 'tl_filter_item'),
            'hideInNavigation'  => true,
        ),
        'field_format' => array
        (
            'tables'            => array('tl_field_format', 'tl_field_format_action'),
            'hideInNavigation'  => true,
        ),
        'interface' => array
        (
            'tables'            => array('tl_interface', 'tl_interface_mapping'),
            'hideInNavigation'  => true,
        ),
        'config' => array
        (
            'tables'            => array('tl_real_estate_config'),
            'hideInNavigation'  => true,
        ),
        'administration' => array
        (
            'callback'          => '\\Oveleon\\ContaoImmoManagerBundle\\ModuleRealEstateAdministration'
        ),
    )
));

// Models
$GLOBALS['TL_MODELS']['tl_provider']               = '\\Oveleon\\ContaoImmoManagerBundle\\ProviderModel';
$GLOBALS['TL_MODELS']['tl_contact_person']         = '\\Oveleon\\ContaoImmoManagerBundle\\ContactPersonModel';
$GLOBALS['TL_MODELS']['tl_real_estate']            = '\\Oveleon\\ContaoImmoManagerBundle\\RealEstateModel';
$GLOBALS['TL_MODELS']['tl_real_estate_group']      = '\\Oveleon\\ContaoImmoManagerBundle\\RealEstateGroupModel';
$GLOBALS['TL_MODELS']['tl_real_estate_type']       = '\\Oveleon\\ContaoImmoManagerBundle\\RealEstateTypeModel';
$GLOBALS['TL_MODELS']['tl_filter']                 = '\\Oveleon\\ContaoImmoManagerBundle\\FilterModel';
$GLOBALS['TL_MODELS']['tl_filter_item']            = '\\Oveleon\\ContaoImmoManagerBundle\\FilterItemModel';
$GLOBALS['TL_MODELS']['tl_field_format']           = '\\Oveleon\\ContaoImmoManagerBundle\\FieldFormatModel';
$GLOBALS['TL_MODELS']['tl_field_format_action']    = '\\Oveleon\\ContaoImmoManagerBundle\\FieldFormatActionModel';
$GLOBALS['TL_MODELS']['tl_interface']              = '\\Oveleon\\ContaoImmoManagerBundle\\InterfaceModel';
$GLOBALS['TL_MODELS']['tl_interface_mapping']      = '\\Oveleon\\ContaoImmoManagerBundle\\InterfaceMappingModel';

// Front end modules
array_insert($GLOBALS['FE_MOD'], 0, array
(
    'immomanager' => array
    (
        'realEstateExpose'       => '\\Oveleon\\ContaoImmoManagerBundle\\ModuleRealEstateExpose',
        'realEstateFilter'       => '\\Oveleon\\ContaoImmoManagerBundle\\Filter',
        'realEstateList'         => '\\Oveleon\\ContaoImmoManagerBundle\\ModuleRealEstateList',
        'realEstateResultList'   => '\\Oveleon\\ContaoImmoManagerBundle\\ModuleRealEstateResultList',
    )
));

// Content elements
array_insert($GLOBALS['TL_CTE']['includes'], 3, array
(
    'realEstateFilter'      => '\\Oveleon\\ContaoImmoManagerBundle\\Filter'
));

// Back end real estate filter items
$GLOBALS['TL_RFI'] = array
(
    'type'                  => '\\Oveleon\\ContaoImmoManagerBundle\\FilterType',
    'location'              => '\\Oveleon\\ContaoImmoManagerBundle\\FilterLocation',
    'defaultFilter'         => '\\Oveleon\\ContaoImmoManagerBundle\\FilterDefaultFilter',
    'submit'                => '\\Oveleon\\ContaoImmoManagerBundle\\FilterSubmit',
);

// Back end real estate administration modules
$GLOBALS['TL_RAM'] = array
(
    'provider'    => array('provider'),
    'filter'      => array('filter', 'type', 'field_format'),
    'settings'    => array('interface', 'config'),
);

// Style sheet
if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/contaoimmomanager/real_estate_administration.css|static';
}

// Add permissions
$GLOBALS['TL_PERMISSIONS'][] = 'provider';
$GLOBALS['TL_PERMISSIONS'][] = 'contactperson';
$GLOBALS['TL_PERMISSIONS'][] = 'filter';
$GLOBALS['TL_PERMISSIONS'][] = 'fieldformat';
$GLOBALS['TL_PERMISSIONS'][] = 'interface';
