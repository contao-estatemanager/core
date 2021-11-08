<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// Extend the default palette
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('filteritems', 'fields', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER)
    ->applyToPalette('default', 'tl_user_group')
;

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('filter_legend', 'forms_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER)
    ->addField(array('filters', 'filterp'), 'filter_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_user_group')
;

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('interface_legend', 'amg_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('interfaces', 'interfacep'), 'interface_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_user_group')
;

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
	->addLegend('provider_legend', 'amg_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
	->addField(array('providers', 'providerp'), 'provider_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
	->applyToPalette('default', 'tl_user_group')
;

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
	->addLegend('real_estate_legend', 'amg_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
	->addField('realestatep', 'real_estate_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
	->applyToPalette('default', 'tl_user_group')
;

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
	->addLegend('real_estate_group_legend', 'amg_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
	->addField(array('regroups', 'regroupp'), 'real_estate_group_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
	->applyToPalette('default', 'tl_user_group')
;

// Add fields to tl_user_group
$GLOBALS['TL_DCA']['tl_user_group']['fields']['filteritems'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array_keys($GLOBALS['TL_RFI']),
    'reference'               => &$GLOBALS['TL_LANG']['RFI'],
    'eval'                    => array('multiple'=>true, 'helpwizard'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['filters'] = array
(
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_filter.title',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['filterp'] = array
(
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['interfaces'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_interface.title',
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['interfacep'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('create', 'delete', 'sync'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['providers'] = array
(
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_provider.anbieternr',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['providerp'] = array
(
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['realestatep'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('create', 'delete'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['regroups'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_real_estate_group.title',
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['regroupp'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('create', 'delete'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);
