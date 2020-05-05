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

use Contao\StringUtil;
use Contao\System;

/**
 * Back end module "real estate administration".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ModuleRealEstateAdministration extends \BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_real_estate_administration';

	/**
	 * EstateManager URL
	 * @var string
	 */
	protected $strEstateManagerUrl = 'https://www.contao-estatemanager.com/';

	/**
	 * Catalog URL
	 * @var string
	 */
	protected $strCompanyUrl = 'https://www.oveleon.de/';

	/**
	 * Generate the module
	 *
	 * @throws \Exception
	 */
	protected function compile()
	{
		System::loadLanguageFile('tl_real_estate_administration');

        $packages = System::getContainer()->getParameter('kernel.packages');

		$this->Template->content = '';
		$this->Template->href = $this->getReferer(true);
		$this->Template->title = StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
        $this->Template->headline = $GLOBALS['TL_LANG']['tl_real_estate_administration']['title'];
        $this->Template->catalogUrl = $this->strEstateManagerUrl;

        $this->Template->version = $GLOBALS['TL_LANG']['MSC']['version'] . ': ' . (isset($packages['contao-estatemanager/core']) ? $packages['contao-estatemanager/core'] : '0.0.0');
        $this->Template->descritption = sprintf($GLOBALS['TL_LANG']['MSC']['estatemanager_description'], '<a href="' . $this->strCompanyUrl . '" target="_blank">' . $GLOBALS['TL_LANG']['MSC']['estatemanager_company'] . '</a>');

        $groups = array();

        foreach ($GLOBALS['TL_RAM'] as $group => $modules)
        {
            $gp = array(
                'alias'   => $group,
                'group'   => $GLOBALS['TL_LANG']['tl_real_estate_administration'][ 'group_' . $group ],
                'modules' => array()
            );

            foreach ($modules as $module)
            {
                if($module == 'addon_catalog')
                {
                    $link = $this->strEstateManagerUrl;
                }
                else
                {
                    $link = 'contao/main.php?do=' . $module;
                }

                $gp['modules'][] = array(
                    'title' => $GLOBALS['TL_LANG']['tl_real_estate_administration'][ $module ][0],
                    'desc'  => $GLOBALS['TL_LANG']['tl_real_estate_administration'][ $module ][1],
                    'link'  => $link
                );
            }

            $groups[] = $gp;
        }

		$this->Template->groups = $groups;
	}
}
