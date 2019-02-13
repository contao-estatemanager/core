<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// load misc language
\System::loadLanguageFile('tl_real_estate_misc');

// Add palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'addForm';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'addFilterModule';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'listMode';

array_insert($GLOBALS['TL_DCA']['tl_module']['palettes'], 0, array
(
    'realEstateExpose'      => '{title_legend},name,headline,type;{form_legend:hide},addForm;{template_legend:hide},customTpl,realEstateGalleryTemplate,realEstateFloorPlanGalleryTemplate,realEstateContactPersonTemplate;{image_legend:hide},imgSize,realEstateGalleryImgSize,floorPlanImgSize,contactPersonImgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
    'realEstateFilter'      => '{title_legend},name,headline,type;{include_legend},filter;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
    'realEstateList'        => '{title_legend},name,headline,type;{list_mode_legend},listMode,hideOnEmpty;{list_config_legend},jumpTo,numberOfItems,perPage;{include_legend},addForm;{status_token_legend},statusTokens;{template_legend:hide},realEstateTemplate,customTpl;{image_legend:hide},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,maxTextLength',
    'realEstateResultList'  => '{title_legend},name,headline,type;{filter_legend:hide},addFilterModule;{filter_mode_legend:hide},filterMode;{status_token_legend},statusTokens;{template_legend:hide},realEstateTemplate,customTpl;{image_legend:hide},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
));

array_insert($GLOBALS['TL_DCA']['tl_module']['subpalettes'], 0, array
(
    'addForm'              => 'form',
    'addFilterModule'      => 'filterModule',
    'listMode_group'       => 'filterGroups,filterMode'
));

// Add immo manager fields
array_insert($GLOBALS['TL_DCA']['tl_module']['fields'], 1, array
(
    'realEstateTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateListTemplate'],
        'default'                 => 'real_estate_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_module_immo_manager', 'getRealEstateListTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'realEstateGalleryTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateGalleryTemplate'],
        'default'                 => 'real_estate_gallery_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_module_immo_manager', 'getRealEstateGalleryListTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'realEstateFloorPlanGalleryTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstatePlanFloorGalleryTemplate'],
        'default'                 => 'real_estate_gallery_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_module_immo_manager', 'getRealEstateGalleryListTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'realEstateContactPersonTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateContactPersonTemplate'],
        'default'                 => 'real_estate_contact_person_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_module_immo_manager', 'getRealEstateContactPersonTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'realEstateGalleryImgSize' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateGalleryImgSize'],
        'exclude'                 => true,
        'inputType'               => 'imageSize',
        'reference'               => &$GLOBALS['TL_LANG']['MSC'],
        'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
        'options_callback' => function ()
        {
            return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
        },
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'floorPlanImgSize' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['planFloorImgSize'],
        'exclude'                 => true,
        'inputType'               => 'imageSize',
        'reference'               => &$GLOBALS['TL_LANG']['MSC'],
        'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
        'options_callback' => function ()
        {
            return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
        },
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'contactPersonImgSize' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['contactPersonImgSize'],
        'exclude'                 => true,
        'inputType'               => 'imageSize',
        'reference'               => &$GLOBALS['TL_LANG']['MSC'],
        'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
        'options_callback' => function ()
        {
            return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
        },
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'addForm' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addForm'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('submitOnChange'=>true),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'addFilterModule' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addFilterModule'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('submitOnChange'=>true),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'filter' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'foreignKey'              => 'tl_filter.title',
        'options_callback'        => array('tl_module_immo_manager', 'getFilter'),
        'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 wizard'),
        'sql'                     => "int(10) unsigned NOT NULL default '0'",
        'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
    ),
    'filterModule' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filterModule'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'foreignKey'              => 'tl_module.name',
        'options_callback'        => array('tl_module_immo_manager', 'getFilterModules'),
        'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 wizard'),
        'sql'                     => "int(10) unsigned NOT NULL default '0'",
        'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
    ),
    'listMode' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['listMode'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options'                 => array('visited', 'group'),
        'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
        'eval'                    => array('tl_class'=>'w50','submitOnChange'=>true),
        'sql'                     => "varchar(16) NOT NULL default ''"
    ),
    'hideOnEmpty' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hideOnEmpty'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('tl_class'=>'w50 m12'),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'filterGroups' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['filterGroups'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'foreignKey'              => 'tl_real_estate_group.title',
        'options_callback'        => array('tl_module_immo_manager', 'getFilterGroups'),
        'eval'                    => array('mandatory'=>true,'tl_class'=>'w50'),
        'sql'                     => "varchar(16) NOT NULL default ''",
        'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
    ),
    'addSorting' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addSorting'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('tl_class'=>'w50 m12'),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'filterMode' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filterMode'],
        'default'                 => 'default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options'                 => array('default', 'neubau', 'referenz'),
        'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(16) NOT NULL default ''"
    ),
    'maxTextLength' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['maxTextLength'],
        'exclude'                 => true,
        'inputType'               => 'text',
        'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
        'sql'                     => "int(10) unsigned NOT NULL default '0'"
    ),
    'statusTokens' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['statusTokens'],
        'exclude'                 => true,
        'inputType'               => 'checkboxWizard',
        'options'                 => array('new', 'reserved', 'rented', 'sold'),
        'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
        'eval'                    => array('multiple'=>true),
        'sql'                     => "blob NULL"
    )
));

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class tl_module_immo_manager extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Return all real estate list templates as array
     *
     * @return array
     */
    public function getRealEstateListTemplates()
    {
        return $this->getTemplateGroup('real_estate_');
    }

    /**
     * Return all real estate list templates as array
     *
     * @return array
     */
    public function getRealEstateGalleryListTemplates()
    {
        return $this->getTemplateGroup('real_estate_gallery_');
    }

    /**
     * Return all contact person templates as array
     *
     * @return array
     */
    public function getRealEstateContactPersonTemplates()
    {
        return $this->getTemplateGroup('real_estate_contact_person_');
    }

    /**
     * Get all filter and return them as array
     *
     * @return array
     */
    public function getFilter()
    {
        if (!$this->User->isAdmin && !\is_array($this->User->filter))
        {
            return array();
        }

        $arrFilter = array();
        $objFilter = $this->Database->execute("SELECT id, title FROM tl_filter ORDER BY title");

        while ($objFilter->next())
        {
            if ($this->User->hasAccess($objFilter->id, 'filter'))
            {
                $arrFilter[$objFilter->id] = $objFilter->title;
            }
        }

        return $arrFilter;
    }

    /**
     * Get all filter frontend modules and return them as array
     *
     * @return array
     */
    public function getFilterModules()
    {
        if (!$this->User->isAdmin)
        {
            return array();
        }

        $arrModules = array();
        $objModule = $this->Database->execute("SELECT id, name FROM tl_module WHERE type='realEstateFilter' ORDER BY name");

        while ($objModule->next())
        {
            $arrModules[$objModule->id] = $objModule->name;
        }

        return $arrModules;
    }

    /**
     * Return a list of real estate groups
     *
     * @return array
     */
    public function getFilterGroups()
    {
        $objGroup = $this->Database->prepare("SELECT id, title FROM tl_real_estate_group")->execute();

        if ($objGroup->numRows < 1)
        {
            return array();
        }

        $return = array();

        while ($objGroup->next())
        {
            $return[$objGroup->id] = $objGroup->title;
        }

        return $return;
    }
}