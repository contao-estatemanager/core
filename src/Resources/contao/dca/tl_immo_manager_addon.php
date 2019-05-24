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
            array('tl_immo_manager_addon', 'createInstalledAddonFields'),
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

    public function createInstalledAddonFields()
    {
        foreach ($GLOBALS['TL_IMMOMANAGER_ADDONS'] as list($namespace, $className))
        {
            $strClass = $namespace . '\\' . $className;

            if (!class_exists($strClass) || !$strClass::$key)
            {
                continue;
            }

            $fieldName = $strClass::$key;

            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $fieldName ] = array(
                'label'           => &$GLOBALS['TL_LANG']['tl_immo_manager_addon'][ $fieldName ],
                'inputType'       => 'text',
                'save_callback'   => [['tl_immo_manager_addon', 'checkLicense']],
                'load_callback'   => [['tl_immo_manager_addon', 'loadLicenseField']],
                'eval'            => ['tl_class'=>'w50 clr'],
                'addonManager'    => $strClass
            );

            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['palettes']['default'] = str_replace(
                "{license_legend}",
                "{license_legend}," . $fieldName,
                $GLOBALS['TL_DCA']['tl_immo_manager_addon']['palettes']['default']
            );
        }
    }

    public function checkLicense($varValue, DataContainer $dc)
    {
        if(!$varValue)
        {
            return $varValue;
        }

        $strClass = $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['addonManager'];

        if(!Oveleon\ContaoImmoManagerBundle\ImmoManager::checkLicenses($varValue, $strClass::getLicenses(), $strClass::$key))
        {
            if(strtolower($varValue) === 'demo')
            {
                throw new Exception($GLOBALS['TL_LANG']['tl_immo_manager_addon']['demo_used']);
            }
            else
            {
                throw new Exception($GLOBALS['TL_LANG']['tl_immo_manager_addon']['invalid_license']);
            }
        }

        return $varValue;
    }

    public function loadLicenseField($varValue, DataContainer $dc)
    {
        if(!$varValue)
        {
            return $varValue;
        }

        $strClass = $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['addonManager'];

        // Check if it is a demo
        if(strtolower($varValue) === 'demo' && $expTime = \Config::get($dc->field . '_demo'))
        {
            $curTime = time();

            $expTimeEnd = strtotime('+2 weeks', $expTime);
            if($expTimeEnd > $curTime && $expTime <= $curTime)
            {
                $info = sprintf($GLOBALS['TL_LANG']['tl_immo_manager_addon']['demo_expiration_date'], date(\Config::get('datimFormat'), $expTimeEnd));
                $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['tl_class'] = $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['tl_class'] . ' validLicense demo';
            }
            else
            {
                $info = $GLOBALS['TL_LANG']['tl_immo_manager_addon']['demo_expired'];
                $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['tl_class'] = $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['tl_class'] . ' expiredLicense';
            }

            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['label'] = array($GLOBALS['TL_LANG']['tl_immo_manager_addon'][ $dc->field ][0], $info);
        }
        // Check valid license
        elseif(Oveleon\ContaoImmoManagerBundle\ImmoManager::checkLicenses($varValue, $strClass::getLicenses(), $strClass::$key))
        {
            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['tl_class'] = $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['eval']['tl_class'] . ' validLicense';
            $GLOBALS['TL_DCA']['tl_immo_manager_addon']['fields'][ $dc->field ]['label'] = array($GLOBALS['TL_LANG']['tl_immo_manager_addon'][ $dc->field ][0], $GLOBALS['TL_LANG']['tl_immo_manager_addon']['valid_license']);
        }

        return $varValue;
    }
}
