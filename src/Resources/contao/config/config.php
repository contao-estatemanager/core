<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// Back end modules
array_insert($GLOBALS['BE_MOD'], 1, array
(
    'real_estate' => array
    (
        'provider' => array
        (
            'tables'                => array('tl_provider', 'tl_contact_person'),
            'hideInNavigation'      => true,
        ),
        'real_estate' => array
        (
            'tables'                => array('tl_real_estate'),
        ),
        'type' => array
        (
            'tables'                => array('tl_real_estate_group', 'tl_real_estate_type'),
            'hideInNavigation'      => true,
        ),
        'filter' => array
        (
            'tables'                => array('tl_filter', 'tl_filter_item'),
            'hideInNavigation'      => true,
        ),
        'field_format' => array
        (
            'tables'                => array('tl_field_format', 'tl_field_format_action'),
            'importFieldFormats'    => array('ContaoEstateManager\EstateManager', 'importFieldFormats'),
            'hideInNavigation'      => true,
        ),
        'interface' => array
        (
            'tables'                => array('tl_interface', 'tl_interface_mapping', 'tl_interface_history', 'tl_interface_log'),
            'syncRealEstates'       => array('ContaoEstateManager\RealEstateImporter', 'sync'),
            'importDefaultMappings' => array('ContaoEstateManager\EstateManager', 'importDefaultMappings'),
            'clearRealEstates'      => array('ContaoEstateManager\EstateManager', 'clearRealEstates'),
            'hideInNavigation'      => true,
        ),
        'config' => array
        (
            'tables'                => array('tl_real_estate_config'),
            'hideInNavigation'      => true,
        ),
        'addon' => array
        (
            'tables'                => array('tl_estate_manager_addon'),
            'hideInNavigation'      => true,
        ),
        'expose_module' => array
        (
            'tables'                => array('tl_expose_module'),
            'hideInNavigation'      => true,
        ),
        'administration' => array
        (
            'callback'              => 'ContaoEstateManager\ModuleRealEstateAdministration'
        ),
    )
));

// Models
$GLOBALS['TL_MODELS']['tl_contact_person']         = 'ContaoEstateManager\ContactPersonModel';
$GLOBALS['TL_MODELS']['tl_expose_module']          = 'ContaoEstateManager\ExposeModuleModel';
$GLOBALS['TL_MODELS']['tl_field_format_action']    = 'ContaoEstateManager\FieldFormatActionModel';
$GLOBALS['TL_MODELS']['tl_field_format']           = 'ContaoEstateManager\FieldFormatModel';
$GLOBALS['TL_MODELS']['tl_filter_item']            = 'ContaoEstateManager\FilterItemModel';
$GLOBALS['TL_MODELS']['tl_filter']                 = 'ContaoEstateManager\FilterModel';
$GLOBALS['TL_MODELS']['tl_interface_history']      = 'ContaoEstateManager\InterfaceHistoryModel';
$GLOBALS['TL_MODELS']['tl_interface_log']          = 'ContaoEstateManager\InterfaceLogModel';
$GLOBALS['TL_MODELS']['tl_interface_mapping']      = 'ContaoEstateManager\InterfaceMappingModel';
$GLOBALS['TL_MODELS']['tl_interface']              = 'ContaoEstateManager\InterfaceModel';
$GLOBALS['TL_MODELS']['tl_provider']               = 'ContaoEstateManager\ProviderModel';
$GLOBALS['TL_MODELS']['tl_real_estate_group']      = 'ContaoEstateManager\RealEstateGroupModel';
$GLOBALS['TL_MODELS']['tl_real_estate']            = 'ContaoEstateManager\RealEstateModel';
$GLOBALS['TL_MODELS']['tl_real_estate_type']       = 'ContaoEstateManager\RealEstateTypeModel';

// Back end form fields
$GLOBALS['BE_FFL']['exposeModuleWizard']           = 'ContaoEstateManager\ExposeModuleWizard';
$GLOBALS['BE_FFL']['license']                      = 'ContaoEstateManager\LicenseField';

// Front end modules
array_insert($GLOBALS['FE_MOD'], 0, array
(
    'estatemanager' => array
    (
        'realEstateExpose'       => 'ContaoEstateManager\ModuleRealEstateExpose',
        'realEstateFilter'       => 'ContaoEstateManager\Filter',
        'realEstateList'         => 'ContaoEstateManager\ModuleRealEstateList',
        'realEstateResultList'   => 'ContaoEstateManager\ModuleRealEstateResultList',
    )
));

// Content elements
array_insert($GLOBALS['TL_CTE']['includes'], 3, array
(
    'realEstateFilter'      => 'ContaoEstateManager\Filter'
));

// Expose modules
$GLOBALS['FE_EXPOSE_MOD'] = array
(
    'properties' => array
    (
        'title'             => 'ContaoEstateManager\ExposeModuleTitle',
        'address'           => 'ContaoEstateManager\ExposeModuleAddress',
        'details'           => 'ContaoEstateManager\ExposeModuleDetails',
        'mainDetails'       => 'ContaoEstateManager\ExposeModuleMainDetails',
        'mainAttributes'    => 'ContaoEstateManager\ExposeModuleMainAttributes',
        'mainPrice'         => 'ContaoEstateManager\ExposeModuleMainPrice',
        'mainArea'          => 'ContaoEstateManager\ExposeModuleMainArea',
        'texts'             => 'ContaoEstateManager\ExposeModuleTexts',
        'fieldList'         => 'ContaoEstateManager\ExposeModuleFieldList',
        'statusToken'       => 'ContaoEstateManager\ExposeModuleStatusToken',
        'marketingToken'    => 'ContaoEstateManager\ExposeModuleMarketingToken',
    ),
    'media' => array
    (
        'gallery'           => 'ContaoEstateManager\ExposeModuleGallery',
    ),
    'miscellaneous' => array
    (
        'contactPerson'     => 'ContaoEstateManager\ExposeModuleContactPerson',
        'enquiryForm'       => 'ContaoEstateManager\ExposeModuleEnquiryForm',
        'attachments'       => 'ContaoEstateManager\ExposeModuleAttachments',
        'share'             => 'ContaoEstateManager\ExposeModuleShare',
        'print'             => 'ContaoEstateManager\ExposeModulePrint',
        'html'              => 'ContaoEstateManager\ExposeModuleHtml',
    )
);

// Back end real estate filter items
$GLOBALS['TL_RFI'] = array
(
    'country'               => 'ContaoEstateManager\FilterCountry',
    'location'              => 'ContaoEstateManager\FilterLocation',
    'unique'                => 'ContaoEstateManager\FilterUnique',
    'type'                  => 'ContaoEstateManager\FilterType',
    'typeSeparated'         => 'ContaoEstateManager\FilterTypeSeparated',
    'toggle'                => 'ContaoEstateManager\FilterToggle',
    'reset'                 => 'ContaoEstateManager\FilterReset',
    'submit'                => 'ContaoEstateManager\FilterSubmit',
);

// Back end real estate administration modules
$GLOBALS['TL_RAM'] = array
(
    'configuration' => array('interface', 'config'),
    'realestate'    => array('type', 'real_estate'),
    'provider'      => array('provider'),
    'filter'        => array('filter'),
    'visualization' => array('field_format', 'expose_module'),
    'addons'        => array('addon', 'addon_catalog'),
);

// Hooks
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('contao_estate_manager.listener.insert_tags', 'onReplaceInsertTags');

// Cron jobs
$GLOBALS['TL_CRON']['minutely'][] = array('ContaoEstateManager\RealEstateCronImporter', 'run');

// Style sheet
if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/estatemanager/real_estate_administration.css|static';
}

// Add permissions
$GLOBALS['TL_PERMISSIONS'][] = 'filters';
$GLOBALS['TL_PERMISSIONS'][] = 'filterp';
$GLOBALS['TL_PERMISSIONS'][] = 'interfaces';
$GLOBALS['TL_PERMISSIONS'][] = 'interfacep';
$GLOBALS['TL_PERMISSIONS'][] = 'providers';
$GLOBALS['TL_PERMISSIONS'][] = 'providerp';
$GLOBALS['TL_PERMISSIONS'][] = 'realestatep';
$GLOBALS['TL_PERMISSIONS'][] = 'regroups';
$GLOBALS['TL_PERMISSIONS'][] = 'regroupp';

// Add localconfig defaults
$GLOBALS['TL_CONFIG']['defaultSorting'] = 'dateAdded';
$GLOBALS['TL_CONFIG']['statusTokenNewDisplayDuration'] = '+1 week';
$GLOBALS['TL_CONFIG']['defaultNumberOfMainDetails'] = '3';
$GLOBALS['TL_CONFIG']['defaultNumberOfMainAttr'] = '3';
$GLOBALS['TL_CONFIG']['numberFormatDecimals'] = ',';
$GLOBALS['TL_CONFIG']['numberFormatThousands'] = '.';
$GLOBALS['TL_CONFIG']['roomOptions'] = '1,2,3,4,5,6,7,8';
