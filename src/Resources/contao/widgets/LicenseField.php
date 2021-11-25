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

use Contao\System;
use Contao\Widget;

/**
 * A license field is used to enter data only. It will not show the
 * currently stored value. In addition it shows information of the package.
 *
 * @property array $package
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class LicenseField extends Widget
{
	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

    /**
     * Package information
     * @var array
     */
    protected $arrPackage = array();

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';

	/**
	 * Add specific attributes
	 *
	 * @param string $strKey
	 * @param mixed  $varValue
	 */
	public function __set($strKey, $varValue)
	{
		if ($strKey == 'package')
		{
			$this->arrPackage = $varValue;
		}
		else
		{
			parent::__set($strKey, $varValue);
		}
	}

	/**
	 * Ignore the field if nothing has been entered
	 *
	 * @param mixed $varInput
	 *
	 * @return mixed
	 */
	protected function validator($varInput)
	{
		if ($varInput == '●●●●-●●●●-●●●●-●●●●-●●●●')
		{
			$this->blnSubmitInput = false;

			return true;
		}

        $strClass = $GLOBALS['TL_DCA']['tl_estate_manager_addon']['fields'][ $this->name ]['addonManager'];

        if($varInput != '' && !EstateManager::checkLicenses($varInput, $strClass::getLicenses(), $strClass::$key))
        {
            if(strtolower($varInput) === 'demo')
            {
                $this->addError($GLOBALS['TL_LANG']['tl_estate_manager_addon']['demo_used']);
            }
            else
            {
                $this->addError($GLOBALS['TL_LANG']['tl_estate_manager_addon']['invalid_license']);
            }
        }

		return parent::validator($varInput);
	}

	/**
	 * Generate the widget and return it as string
	 *
	 * @return string
	 */
	public function generate()
	{
        $webDir   = System::getContainer()->getParameter('contao.web_dir');
        $basePath = '/bundles/'.preg_replace('/bundle$/', '', strtolower($this->arrPackage['bundle']));

        if (file_exists($webDir . $basePath . '/logo.svg')) {
            $imagePath = $basePath . '/logo.svg';
        }
        else
        {
            $imagePath = '/bundles/estatemanager/logo/logo.svg';
        }

		return sprintf(
			'<input type="text" name="%s" id="ctrl_%s" class="tl_text%s" value="%s"%s onfocus="Backend.getScrollOffset()">%s<span class="image"><img src="%s"/></span><span class="version"><span>%s</span></span>',
			$this->strName,
			$this->strId,
			($this->strClass ? ' ' . $this->strClass : ''),
			(($this->varValue != '' && !$this->hasErrors() && strtolower($this->varValue) != 'demo') ? '●●●●-●●●●-●●●●-●●●●-●●●●' : $this->varValue),
			$this->getAttributes(),
			$this->wizard,
            $imagePath,
			$this->arrPackage['version'] ?: '0.0.0'
		);
	}
}
