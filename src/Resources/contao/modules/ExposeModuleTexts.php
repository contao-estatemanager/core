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
 * Expose module "texts".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleTexts extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_texts';

    /**
     * Do not display the module if there are no real etates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['texts'][0]) . ' ###';
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
        $arrBlocks = \StringUtil::deserialize($this->textBlocks);

        $arrTexts = $this->realEstate->getTexts($arrBlocks, $this->maxTextLength);

        $arrCollection = array();

        foreach ($arrTexts as $field => $text)
        {
            $arrCollection[] = array(
                'label' => Translator::translateExpose('headline_' . $field),
                'text'  => $text
            );
        }

        $this->Template->texts = $arrCollection;
    }
}