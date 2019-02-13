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

        /** @var PageModel $objPage */
        global $objPage;

        $this->initializeFilterSession();
        $this->initializeSortingSession();

        $this->filter = RealEstateFilter::getInstance();

        if (!$this->filter->isUsable())
        {
            return ''; // ToDo: Exception werfen. Einer Ergebnisliste muss immer eine Gruppe oder ein Typ zugrunde liegen.
        }

        \System::loadLanguageFile('tl_real_estate_filter');

        // HOOK: real estate result list generate
        if (isset($GLOBALS['TL_HOOKS']['generateResultList']) && \is_array($GLOBALS['TL_HOOKS']['generateResultList']))
        {
            foreach ($GLOBALS['TL_HOOKS']['generateResultList'] as $callback)
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
        if ($this->addFilter)
        {
            $this->Template->filter = $this->getFrontendModule($this->filterModule);
        }

        $this->generateResultList();

        if ($this->addSorting)
        {
            $sortingOptions = \StringUtil::deserialize($this->filter->type->sortingOptions);
            $arrOptions = array('dateAdded_asc' => Translator::translateFilter('dateAdded_asc'));

            foreach ($sortingOptions as $option)
            {
                $asc = $option['field'].'_asc';
                $desc = $option['field'].'_desc';

                $arrOptions[$asc] = Translator::translateFilter($asc);
                $arrOptions[$desc] = Translator::translateFilter($desc);
            }

            $this->Template->sortingOptions = $arrOptions;
            $this->Template->selectedSortingOption = $_SESSION['SORTING'];
        }
    }

    /**
     * Parse a real estate filter and return it as string
     *
     * @return string
     */
    protected function parseFilter()
    {
        // ToDO:
        //  Eki, ich glaube das Model vor dem laden zu holen und zu prüfen ob es vorhanden ist, ist überflüssig.
        //  Dies wird bereits von "getFrontendModule" gemacht wenn ich das richtig sehe
        //  Ansonsten kannst du auch direkt das komplette Model übergeben, dann wird es nicht zwei mal abgeholt

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
        list($arrColumns, $arrValues, $arrOptions) = $this->filter->getParameter($this->filterMode);

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
        list($arrColumns, $arrValues, $arrOptions) = $this->filter->getParameter($this->filterMode);

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