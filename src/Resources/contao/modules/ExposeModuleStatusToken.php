<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;

/**
 * Expose module "status token".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleStatusToken extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_statusToken';

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['statusToken'][0]) . ' ###';
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
        $arrValidTokens = \StringUtil::deserialize($this->statusTokens);

        $arrStatusTokens = $this->realEstate->getStatusTokens($arrValidTokens);

        $this->Template->arrStatusTokens = $arrStatusTokens;

        // HOOK: add custom logic for status tokens
        if (isset($GLOBALS['TL_HOOKS']['compileExposeStatusToken']) && \is_array($GLOBALS['TL_HOOKS']['compileExposeStatusToken']))
        {
            foreach ($GLOBALS['TL_HOOKS']['compileExposeStatusToken'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this->Template, $this->realEstate, $this);
            }
        }

        $this->isEmpty = !count($this->Template->arrStatusTokens);
    }
}