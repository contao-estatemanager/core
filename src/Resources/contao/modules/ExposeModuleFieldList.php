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
use Contao\StringUtil;

/**
 * Expose module "field list".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleFieldList extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_fieldList';

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
            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['fieldList'][0], 'UTF-8') . ' ###';
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
    protected function compile()
    {
        $arrCollection = array();

        $arrFields = StringUtil::deserialize($this->fields);

        if($arrFields)
        {
            // transform to a one dimensional array
            $arrFields = array_map(function ($a){
                return $a['field'];
            }, $arrFields);

            // add fields to collection
            $arrCollection = $this->realEstate->getFields($arrFields);
        }

        $this->Template->arrFields = $arrCollection;
    }
}
