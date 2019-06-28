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

use Patchwork\Utf8;


/**
 * Front end module "real estate result list".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class ModuleRealEstateResultList extends ModuleRealEstate
{
    /**
     * Filter session object
     * @var FilterSession
     */
    protected $objFilterSession;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateResultList';

    /**
     * Real estate filter object
     * @var RealEstateFilter
     */
    protected $filter;

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateResultList'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->objFilterSession = FilterSession::getInstance();

        if ($this->customTpl != '')
        {
            $this->strTemplate = $this->customTpl;
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->initializeSortingSession();
        $this->addSorting();
        $this->parseRealEstateList();

        if($this->addCountLabel)
        {
            $this->Template->labelObjectsFound = sprintf(Translator::translateLabel('labelObjectsFound'), $this->totalItems);
        }
    }

    /**
     * Count the total matching items
     *
     * @return integer
     */
    protected function countItems()
    {
        list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameter($this->realEstateGroups, $this->filterMode);

        return RealEstateModel::countBy($arrColumns, $arrValues, $arrOptions);
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
        list($arrColumns, $arrValues, $arrOptions) = $this->objFilterSession->getParameter($this->realEstateGroups, $this->filterMode);

        $arrOptions['limit']  = $limit;
        $arrOptions['offset'] = $offset;
        $arrOptions['order']  = $this->getOrderOption();

        return RealEstateModel::findBy($arrColumns, $arrValues, $arrOptions);
    }
}
