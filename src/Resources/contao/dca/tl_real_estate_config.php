<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// Load translations
Contao\System::loadLanguageFile('tl_real_estate_misc');

$GLOBALS['TL_DCA']['tl_real_estate_config'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'File',
		'closed'                      => true
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{real_estate_list_legend},defaultSorting,statusTokenNewDisplayDuration,defaultNumberOfMainDetails,defaultNumberOfMainAttr,defaultImage;{provider_contact_legend},defaultContactPersonImage,defaultContactPersonFemaleImage,defaultContactPersonMaleImage;{number_legend:hide},defaultCurrency,numberFormatDecimals,numberFormatThousands;{filter_config_legend:hide},roomOptions;{api_legend:hide},cemApiKey;{exception_legend:hide},estateManagerAdminEmail,cemExceptionNotifications'
	),

	// Fields
	'fields' => array
	(
        'estateManagerAdminEmail' => array
        (
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'friendly', 'decodeEntities'=>true, 'tl_class'=>'w50')
        ),
		'numberFormatDecimals' => array
		(
            'default'                 => ',',
			'inputType'               => 'select',
            'options'                 => array
            (
                ',' => &$GLOBALS['TL_LANG']['tl_real_estate_config']['comma'],
                '.' => &$GLOBALS['TL_LANG']['tl_real_estate_config']['dot']
            ),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 clr')
		),
		'numberFormatThousands' => array
		(
            'default'                 => '.',
            'inputType'               => 'select',
            'options'                 => array
            (
                ',' => &$GLOBALS['TL_LANG']['tl_real_estate_config']['comma'],
                '.' => &$GLOBALS['TL_LANG']['tl_real_estate_config']['dot']
            ),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
		),
		'defaultCurrency' => array
		(
            'default'                 => 'euro',
            'inputType'               => 'select',
            'options'                 => array
            (
                'euro' => &$GLOBALS['TL_LANG']['tl_real_estate_misc']['euro'][0],
                'dollar' => &$GLOBALS['TL_LANG']['tl_real_estate_misc']['dollar'][0],
                'pound' => &$GLOBALS['TL_LANG']['tl_real_estate_misc']['pound'][0]
            ),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
		),
		'defaultSorting' => array
		(
            'inputType'               => 'select',
            'options'                 => array('dateAdded', 'tstamp', 'standVom'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_config'],
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 clr')
		),
        'statusTokenNewDisplayDuration' => array
        (
            'inputType'               => 'select',
            'options'                 => array('+1 days' => 'oneDay', '+3 days' => 'threeDays', '+1 week' => 'oneWeek', '+2 weeks' => 'twoWeeks', '+3 weeks' => 'threeWeeks', '+4 weeks' => 'oneMonth'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
            'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
        ),
        'defaultImage' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'isGallery'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'tl_class'=>'clr w50'),
        ),
        'defaultContactPersonImage' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'isGallery'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'tl_class'=>'w50'),
        ),
        'defaultContactPersonFemaleImage' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'isGallery'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'tl_class'=>'w50'),
        ),
        'defaultContactPersonMaleImage' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'isGallery'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'tl_class'=>'w50'),
        ),
        'roomOptions' => array
        (
            'default'                 => '1,2,3,4,5,6,7,8,9,10',
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50')
        ),
        'defaultNumberOfMainDetails' => array
        (
            'default'                 => '3',
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'natural', 'tl_class'=>'w50')
        ),
        'defaultNumberOfMainAttr' => array
        (
            'default'                 => '4',
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'natural', 'tl_class'=>'w50')
        ),
        'cemApiKey' => array
        (
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50')
        ),
        'cemExceptionNotifications' => array
        (
            'inputType'               => 'checkbox',
            'eval'                    => array('multiple' => true, 'tl_class'=>'w50 clr')
        ),
	)
);
