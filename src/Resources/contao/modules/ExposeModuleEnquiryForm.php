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
use Contao\FormModel;

/**
 * Expose module "enquiry form".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleEnquiryForm extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_enquiryForm';

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
            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['enquiryForm'][0], 'UTF-8') . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $strBuffer = parent::generate();

        return $this->isEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $objForm = FormModel::findByPk($this->form);

        if ($objForm === null || ($this->hideOnReferences && !!$this->realEstate->referenz))
        {
            $this->isEmpty = true;

            return '';
        }

        $form = new ExposeForm($objForm, $this);

        $form->setStrKey('form');

        $this->Template->form = $form->generate();
    }
}
