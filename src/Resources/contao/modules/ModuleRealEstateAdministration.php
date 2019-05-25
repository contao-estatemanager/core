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
 * Back end module "real estate administration".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ModuleRealEstateAdministration extends \BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_real_estate_administration';

	/**
	 * Catalog URL
	 * @var string
	 */
	protected $strCatalogUrl = 'https://www.contao-estatemanager.com/';

	/**
	 * Generate the module
	 *
	 * @throws \Exception
	 */
	protected function compile()
	{
		\System::loadLanguageFile('tl_real_estate_administration');

		$this->Template->content = '';
		$this->Template->href = $this->getReferer(true);
		$this->Template->title = \StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
        $this->Template->headline = $GLOBALS['TL_LANG']['tl_real_estate_administration']['title'];
        $this->Template->catalogUrl = $this->strCatalogUrl;

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
                    $link = $this->strCatalogUrl;
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