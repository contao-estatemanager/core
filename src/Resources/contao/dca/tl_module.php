<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Add palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'addFilterModule';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'listMode';

array_insert($GLOBALS['TL_DCA']['tl_module']['palettes'], 0, array
(
    'realEstateExpose'      => '{title_legend},name,headline,type;{module_legend:hide},exposeModules;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
    'realEstateFilter'      => '{title_legend},name,headline,type;{include_legend},filter;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
    'realEstateList'        => '{title_legend},name,headline,type;{list_mode_legend},listMode,hideOnEmpty;{list_config_legend},jumpTo,numberOfItems,perPage;{status_token_legend},statusTokens;{template_legend:hide},realEstateTemplate,customTpl;{image_legend:hide},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,maxTextLength',
    'realEstateResultList'  => '{title_legend},name,headline,type;{filter_legend:hide},addFilterModule;{filter_mode_legend:hide},filterMode;{status_token_legend},statusTokens;{template_legend:hide},realEstateTemplate,customTpl;{image_legend:hide},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
));

array_insert($GLOBALS['TL_DCA']['tl_module']['subpalettes'], 0, array
(
    'addFilterModule'      => 'filterModule',
    'listMode_group'       => 'filterGroups,filterMode'
));

// Add immo manager fields
array_insert($GLOBALS['TL_DCA']['tl_module']['fields'], 1, array
(
    'realEstateTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateTemplate'],
        'default'                 => 'real_estate_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_module_immo_manager', 'getRealEstateTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
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
    ),
    'exposeModules' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['exposeModules'],
        'default'                 => array(array('mod'=>0, 'col'=>'wrapper_before', 'enable'=>1)),
        'exclude'                 => true,
        'inputType'               => 'exposeModuleWizard',
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
    public function getRealEstateTemplates()
    {
        return $this->getTemplateGroup('real_estate_');
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
