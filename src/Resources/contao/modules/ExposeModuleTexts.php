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
 * @author Daniele Sciannimanica <https://github.com/doishub>
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

        $strBuffer = parent::generate();

        return $this->isEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrCollection = array();
        $this->Template->texts = array();

        $arrBlocks = \StringUtil::deserialize($this->textBlocks);

        $arrTexts = $this->realEstate->getTexts($arrBlocks, $this->maxTextLength);

        foreach ($arrTexts as $field => $text)
        {
            if(!$text['value']){
                continue;
            }

            $arrCollection[] = array(
                'label' => Translator::translateExpose('headline_' . $field),
                'text'  => $text
            );
        }

        if($this->hideOnEmpty && !count($arrCollection))
        {
            $this->isEmpty = true;
            return '';
        }

        $this->Template->texts = $arrCollection;
    }
}