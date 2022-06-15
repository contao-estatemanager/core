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

use Contao\BackendTemplate;

/**
 * Expose module "title".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleTitle extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_title';

    /**
     * Do not display the module if there are no real etates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['title'][0], 'UTF-8') . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile(){}
}
