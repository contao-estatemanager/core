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
use Patchwork\Utf8;

/**
 * Front end module "real estate list".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ModuleRealEstateList extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateList';

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateList'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        // HOOK: real estate list generate
        if (isset($GLOBALS['TL_HOOKS']['generateList']) && \is_array($GLOBALS['TL_HOOKS']['generateList']))
        {
            foreach ($GLOBALS['TL_HOOKS']['generateList'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this);
            }
        }

        $strBuffer = parent::generate();

        return (!$this->countItems() && $this->hideOnEmpty) ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->generateResultList();
    }

    /**
     * Count the total matching items
     *
     * @return integer
     */
    protected function countItems()
    {
        $intCount = 0;

        switch ($this->listMode)
        {
            case 'visited':
                $intCount = count($_SESSION['REAL_ESTATE_VISITED']);
                break;
            case 'group':
                // ToDo: Derzeit kann nur eine Gruppe selektiert werden. Umbau in checkboxWizard und entgegennahmen mehrerer Gruppen
                $filter = RealEstateFilter::getInstance();
                $filter->setCurrentGroup(RealEstateGroupModel::findByPk($this->filterGroups));

                list($arrColumns, $arrValues, $arrOptions) = $filter->getParameter($this->filterMode);

                $intCount = RealEstateModel::countBy($arrColumns, $arrValues, $arrOptions);
                break;
        }

        // HOOK: real estate list count items
        if (isset($GLOBALS['TL_HOOKS']['realEstateListCountItems']) && \is_array($GLOBALS['TL_HOOKS']['realEstateListCountItems']))
        {
            foreach ($GLOBALS['TL_HOOKS']['realEstateListCountItems'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($intCount, $this);
            }
        }

        return $intCount;
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
        $objRealEstate = null;
        $arrOptions = array();

        $arrOptions['limit']  = $limit;
        $arrOptions['offset'] = $offset;

        switch ($this->listMode)
        {
            case 'visited':
                $objRealEstate = RealEstateModel::findMultipleByIds($_SESSION['REAL_ESTATE_VISITED'], $arrOptions);
                break;
            case 'group':
                // ToDo: Derzeit kann nur eine Gruppe selektiert werden. Umbau in checkboxWizard und entgegennahmen mehrerer Gruppen
                $filter = RealEstateFilter::getInstance();
                $filter->setCurrentGroup(RealEstateGroupModel::findByPk($this->filterGroups));

                list($arrColumns, $arrValues, $options) = $filter->getParameter($this->filterMode);

                $arrOptions = array_merge($arrOptions, $options);

                $objRealEstate = RealEstateModel::findBy($arrColumns, $arrValues, $arrOptions);
                break;
        }

        // HOOK: real estate list fetch items
        if (isset($GLOBALS['TL_HOOKS']['realEstateListFetchItems']) && \is_array($GLOBALS['TL_HOOKS']['realEstateListFetchItems']))
        {
            foreach ($GLOBALS['TL_HOOKS']['realEstateListFetchItems'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objRealEstate, $limit, $offset, $this);
            }
        }

        return $objRealEstate;
    }
}