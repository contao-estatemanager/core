<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

$GLOBALS['TL_DCA']['tl_immo_manager_addon'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'File',
		'closed'                      => true,
        'onload_callback'             => array
        (
            array('tl_immo_manager_addon', 'checkInstalledAddons'),
        )
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{license_legend};'
	),

	// Fields
	'fields' => array
	(
	    // dynamic
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_immo_manager_addon extends Backend
{

    public function checkInstalledAddons()
    {

        foreach ($GLOBALS['TL_IMMOMANAGER_ADDONS'] as list($namespace, $className)){

            $strClass = $namespace . '\\' . $className;

            // Continue if the class is not defined
            if (!class_exists($strClass) || !$strClass::$name)
            {
                continue;
            }

            $fieldName = 'addon_' . trim($strClass::$name) . '_license';

            // create field
            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $fieldName ] = array(
                'label'         => &$GLOBALS['TL_LANG']['tl_immo_manager_addon'][ $fieldName ],
                'inputType'     => 'text',
                'save_callback' => array
                (
                    array('tl_immo_manager_addon', 'checkAddonLicense')
                ),
                'load_callback' => array
                (
                    array('tl_immo_manager_addon', 'checkAddonLicense')
                ),
                'addonManager'  => $strClass,
                'eval'          => array('tl_class'=>'w50')
            );

            // add field to palette
            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['palettes']['default'] = str_replace(
                "{license_legend}",
                "{license_legend}," . $fieldName,
                $GLOBALS['TL_DCA']['tl_immo_manager_addon']['palettes']['default']
            );
        }
    }

    public function checkAddonLicense($varValue, DataContainer $dc)
    {
        if(!$varValue){
            return $varValue;
        }

        $strClass = $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['addonManager'];

        if(!Oveleon\ContaoImmoManagerBundle\ImmoManager::checkLicenses($varValue, $strClass::getLicenses())){
            throw new Exception('Die angegebene Lizenz ist nicht gültig. Bitte prüfen Sie Ihre Eingabe und beachten Sie 0 (Null) und O (Buchstabe)');
        }else{
            // highlight valid licenses
            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['style'] = 'border-color: green';

            return $varValue;
        }
    }
}
