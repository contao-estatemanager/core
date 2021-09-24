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
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\StringUtil;
use Patchwork\Utf8;

/**
 * Expose module "share".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleShare extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_share';

    /**
     * Template share email
     * @var string
     */
    protected $strShareTemplate = 'expose_mod_share_email';

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['share'][0]) . ' ###';
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

        // get options
        $arrOptions = StringUtil::deserialize($this->share, true);

        foreach ($arrOptions as $option)
        {
            switch($option)
            {
                case 'email':
                    $arrCollection[] = $this->parseShareEmail();
                    break;
            }
        }

        // add label to the Template
        $this->Template->label = Translator::translateExpose('button_share');

        // HOOK: add some more share options
        if (isset($GLOBALS['TL_HOOKS']['compileExposeShare']) && \is_array($GLOBALS['TL_HOOKS']['compileExposeShare']))
        {
            foreach ($GLOBALS['TL_HOOKS']['compileExposeShare'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this->Template, $arrCollection, $this);
            }
        }

        // add options to the Template
        $this->Template->items = $arrCollection;
    }

    /**
     * Parse the share template and return it as string
     *
     * @return string
     */
    protected function parseShareEmail()
    {
        $strTemplate = $this->strShareTemplate;

        // set custom Template
        if($this->shareEmailTemplate)
        {
            $strTemplate = $this->shareEmailTemplate;
        }

        // create Template
        $objTemplate = new FrontendTemplate($strTemplate);

        /** @var PageModel $objPage */
        global $objPage;

        // create email content
        $link = Environment::get('base') . $this->realEstate->generateExposeUrl($objPage->id);
        $text = Translator::translateExpose('text_share_mail_body');

        // set url to email content
        $body = vsprintf($text, array($link));

        if($body === false)
        {
            @trigger_error('Cant return array values as a formatted string', E_USER_DEPRECATED);
        }

        // convert linebreak
        $body = str_replace(array('\r', '\n'), "%0D%0A", $body);

        // set template information
        $objTemplate->label = Translator::translateExpose('button_per_email');
        $objTemplate->subject = Translator::translateExpose('text_share_mail_subject');
        $objTemplate->body = $body;

        return $objTemplate->parse();
    }

}
