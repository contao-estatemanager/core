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
 * Front end module "real estate result list".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 * @author Fabian Ekert <https://github.com/eki89>
 */
class ModuleRealEstateResultList extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateResultList';

    /**
     * Session manager object
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * Do not display the module if there are no real estates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateResultList'][0], 'UTF-8') . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        //$this->objFilterSession = FilterSession::getInstance();
        $this->sessionManager = SessionManager::getInstance();

        if ($this->customTpl != '')
        {
            $this->strTemplate = $this->customTpl;
        }

        // HOOK: real estate result list generate
        if (isset($GLOBALS['CEM_HOOKS']['generateRealEstateResultList']) && \is_array($GLOBALS['CEM_HOOKS']['generateRealEstateResultList']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['generateRealEstateResultList'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this);
            }
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->redirectIfUnique();
        $this->addSorting();
        $this->parseRealEstateList();

        if($this->addCountLabel && $this->totalItems)
        {
            $this->Template->labelObjectsFound = sprintf(Translator::translateLabel('labelObjectsFound'), '<span>' . $this->totalItems . '</span>');
        }
    }

    /**
     * Count the total matching items
     *
     * @return integer
     */
    protected function countItems()
    {
        //list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameter($this->realEstateGroups, $this->filterMode, true, $this);
        list($arrColumns, $arrValues, $arrOptions) = $this->sessionManager->getParameter($this->realEstateGroups, $this);

        return RealEstateModel::countPublishedBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Fetch the matching items
     *
     * @param integer $limit
     * @param integer $offset
     *
     * @return \Model\Collection|RealEstateModel|null
     */
    protected function fetchItems($limit, $offset)
    {
        //list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameter($this->realEstateGroups, $this->filterMode, true, $this);
        list($arrColumns, $arrValues, $arrOptions) = $this->sessionManager->getParameter($this->realEstateGroups, $this);

        $arrOptions['limit']  = $limit;
        $arrOptions['offset'] = $offset;

        if ($this->addCustomOrder)
        {
            $arrOptions['order'] = $this->customOrder . (isset($arrOptions['order']) ? ', ' . $arrOptions['order'] : '');
        }

        return RealEstateModel::findPublishedBy($arrColumns, $arrValues, $arrOptions);
    }
}
