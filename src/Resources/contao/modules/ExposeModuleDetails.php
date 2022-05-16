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
 * Expose module "details".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleDetails extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_details';

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
            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['details'][0], 'UTF-8') . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $strBuffer = parent::generate();

        return ($this->skipDetails) ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->skipDetails =false;

        $arrSorting = null;
        $arrBlocks = StringUtil::deserialize($this->detailBlocks);

        if($this->overwriteFieldSorting && $userDefinedSorting = StringUtil::deserialize($this->fieldSorting))
        {
            // Flatten sorting array
            foreach ($userDefinedSorting as $sortingField)
            {
                $arrSorting[] = $sortingField['field'];
            }
        }

        $arrCollection = [];

        if($arrBlocks)
        {
            $seperateBlocks = $arrBlocks;

            $arrDetails = $this->realEstate->getPropertiesByGroup($seperateBlocks, $this->includeAddress, $arrBlocks, 'detail', $arrSorting);

            // sort by user preference
            $orderedDetails = array();

            foreach ($arrBlocks as $index)
            {
                if(array_key_exists($index, $arrDetails))
                {
                    $orderedDetails[ $index ] = $arrDetails[ $index ];
                }
            }

            $arrDetails = $orderedDetails;

            // combine all the blocks into one
            if(!!$this->summariseDetailBlocks)
            {
                $mergedBlocks = array();

                foreach ($arrDetails as $block => $details)
                {
                    $mergedBlocks = array_merge($mergedBlocks, $details);
                }

                $arrDetails = array('detail' => $mergedBlocks);
            }

            // set headline
            foreach ($arrDetails as $block => $details)
            {
                $arrCollection[] = array(
                    'key'     => $block,
                    'label'   => Translator::translateExpose('headline_' . $block),
                    'details' => $details
                );
            }
        }

        // HOOK: custom logic for details
        if (isset($GLOBALS['CEM_HOOKS']['compileExposeDetails']) && \is_array($GLOBALS['CEM_HOOKS']['compileExposeDetails']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['compileExposeDetails'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this->Template, $arrCollection, $this);
            }
        }

        if(!\count($arrCollection))
        {
            $this->skipDetails = true;
        }

        $this->Template->details = $arrCollection;
    }
}
