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
use Contao\Config;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Environment;
use Contao\FrontendUser;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Patchwork\Utf8;

/**
 * Front end module "real estate expose".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ModuleRealEstateExpose extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateExpose';

    /**
     * Real estate object
     * @var RealEstate
     */
    protected $realEstate;

    /**
     * Real estate type model
     * @var RealEstateTypeModel
     */
    protected $objRealEstateType;

    /**
     * Template
     * @var string
     */
    protected $strTable = 'tl_real_estate';

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateExpose'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        // Set the item from the auto_item parameter
        if (!isset($_GET['items']) && Config::get('useAutoItem') && isset($_GET['auto_item']))
        {
            Input::setGet('items', Input::get('auto_item'));
        }

        // Return an empty string if "items" is not set (to combine list and reader on same page)
        if (!Input::get('items'))
        {
            throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
        }

        if ($internal = strpos(Input::get('items'), 'intern-') === 0)
        {
            /** @var \PageModel $objPage */
            global $objPage;

            $objRealEstate = RealEstateModel::findPublishedByObjektnrIntern(substr(Input::get('items'), 7));

            if ($objRealEstate !== null)
            {
                $realEstate = new RealEstate($objRealEstate);
                $this->redirect($realEstate->generateExposeUrl($objPage));
            }
        }

        System::loadLanguageFile('tl_real_estate_expose');

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $objRealEstate = RealEstateModel::findPublishedByIdOrAlias(Input::get('items'));

        if ($objRealEstate === null || (!$this->allowReferences && $objRealEstate->referenz))
        {
            throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
        }

        $this->updateVisitedSession($objRealEstate->id);

        // HOOK: compile real estate expose
        if (isset($GLOBALS['TL_HOOKS']['compileRealEstateExpose']) && \is_array($GLOBALS['TL_HOOKS']['compileRealEstateExpose']))
        {
            foreach ($GLOBALS['TL_HOOKS']['compileRealEstateExpose'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this->Template, $objRealEstate, $this);
            }
        }

        $arrCustomSections = array();
        $arrSections = array('header', 'contentTop', 'left', 'right', 'main', 'contentBottom', 'footer');
        $arrModules = StringUtil::deserialize($this->exposeModules);

        $arrModuleIds = array();

        // Filter the disabled modules
        foreach ($arrModules as $module)
        {
            if ($module['enable'])
            {
                $arrModuleIds[] = $module['mod'];
            }
        }

        // Get all modules in a single DB query
        $objModules = ExposeModuleModel::findMultipleByIds($arrModuleIds);

        if ($objModules !== null || $arrModules[0]['mod'] == 0)
        {
            $arrMapper = array();

            // Create a mapper array in case a module is included more than once
            if ($objModules !== null)
            {
                while ($objModules->next())
                {
                    $arrMapper[$objModules->id] = $objModules->current();
                }
            }

            foreach ($arrModules as $arrModule)
            {
                // Disabled module
                if (!$arrModule['enable'])
                {
                    continue;
                }

                // Replace the module ID with the module model
                if ($arrModule['mod'] > 0 && isset($arrMapper[$arrModule['mod']]))
                {
                    $arrModule['mod'] = $arrMapper[$arrModule['mod']];
                }

                // Generate the modules
                if (\in_array($arrModule['col'], $arrSections))
                {
                    $this->Template->{$arrModule['col']} .= $this->getExposeModule($arrModule['mod'], $objRealEstate, $arrModule['col']);
                }
                else
                {
                    $arrCustomSections[$arrModule['col']] .= $this->getExposeModule($arrModule['mod'], $objRealEstate, $arrModule['col']);
                }
            }
        }

        $this->Template->sections = $arrCustomSections;
        $this->Template->realEstateId = $objRealEstate->id;
    }

    /**
     * Generate a expose module and return it as string
     *
     * @param mixed $intId A module ID or a Model object
     * @param $objRealEstate
     * @param string $strColumn The name of the column
     *
     * @return string The module HTML markup
     */
    public function getExposeModule($intId, $objRealEstate, $strColumn='main'): string
    {
        if (!\is_object($intId) && !\strlen($intId))
        {
            return '';
        }

        if (\is_object($intId))
        {
            $objRow = $intId;
        }
        else
        {
            $objRow = ExposeModuleModel::findByPk($intId);

            if ($objRow === null)
            {
                return '';
            }
        }

        // Check the visibility (see #6311)
        if (!static::isVisibleExposeElement($objRow))
        {
            return '';
        }

        $strClass = ExposeModule::findClass($objRow->type);

        // Return if the class does not exist
        if (!class_exists($strClass))
        {
            System::log('Module class "'.$strClass.'" (module "'.$objRow->type.'") does not exist', __METHOD__, TL_ERROR);

            return '';
        }

        $objRow->typePrefix = 'expose_mod_';

        /** @var ExposeModule $objModule */
        $objModule = new $strClass($objRow, $objRealEstate, $strColumn);
        $strBuffer = $objModule->generate();

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['getExposeModule']) && \is_array($GLOBALS['TL_HOOKS']['getExposeModule']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getExposeModule'] as $callback)
            {
                $strBuffer = \System::importStatic($callback[0])->{$callback[1]}($objRow, $strBuffer, $objModule);
            }
        }

        // Disable indexing if protected
        if ($objModule->protected && !preg_match('/^\s*<!-- indexer::stop/', $strBuffer))
        {
            $strBuffer = "\n<!-- indexer::stop -->". $strBuffer ."<!-- indexer::continue -->\n";
        }

        return $strBuffer;
    }

    /**
     * Check whether an element is visible in the front end
     *
     * @param ExposeModuleModel $objElement The element model
     *
     * @return boolean True if the element is visible
     */
    public static function isVisibleExposeElement(ExposeModuleModel $objElement): bool
    {
        $blnReturn = true;

        // Only apply the restrictions in the front end
        if (TL_MODE == 'FE')
        {
            // Protected element
            if ($objElement->protected)
            {
                if (!FE_USER_LOGGED_IN)
                {
                    $blnReturn = false;
                }
                else
                {
                    $groups = StringUtil::deserialize($objElement->groups);

                    if (empty($groups) || !\is_array($groups) || !\count(array_intersect($groups, FrontendUser::getInstance()->groups)))
                    {
                        $blnReturn = false;
                    }
                }
            }

            // Show to guests only
            elseif ($objElement->guests && FE_USER_LOGGED_IN)
            {
                $blnReturn = false;
            }
        }

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['isVisibleElement']) && \is_array($GLOBALS['TL_HOOKS']['isVisibleElement']))
        {
            foreach ($GLOBALS['TL_HOOKS']['isVisibleElement'] as $callback)
            {
                $blnReturn = System::importStatic($callback[0])->{$callback[1]}($objElement, $blnReturn);
            }
        }

        return $blnReturn;
    }
}
