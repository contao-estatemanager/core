<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */
namespace Oveleon\ContaoImmoManagerBundle;

use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Model\Collection;
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
        $this->parseRealEstateList();
    }

    /**
     * Parse a real estate filter and return it as string
     *
     * @return string
     */
    protected function parseFilter()
    {
        $objModule = \ModuleModel::findByPk($this->filterModule);

        if ($objModule === null)
        {
            return '';
        }

        return $this->getFrontendModule($objModule->id);
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

    /**
     * Return the order option as string
     *
     * @return string
     */
    protected function getOrderOption()
    {
        $strOrder = $_SESSION['SORTING'];

        if (strpos($strOrder, '_asc'))
        {
            $strOrder = str_replace('_asc', '', $strOrder) . ' ASC';
        }
        elseif (strpos($strOrder, '_desc'))
        {
            $strOrder = str_replace('_desc', '', $strOrder) . ' DESC';
        }

        return $strOrder;
    }
}
