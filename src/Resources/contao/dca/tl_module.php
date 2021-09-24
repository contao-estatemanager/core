<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// Load translations
Contao\System::loadLanguageFile('tl_real_estate_misc');

// Add palette selectors
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'listMode';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'filterByProvider';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'addSorting';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]        = 'addCustomOrder';

// Add palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['realEstateExpose']      = '{title_legend},name,headline,type;{config_legend},allowUnpublishedRecords;{module_legend:hide},exposeModules;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['realEstateFilter']      = '{title_legend},name,headline,type;{include_legend},filter;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['realEstateList']        = '{title_legend},name,headline,type;{config_legend},numberOfItems,perPage,numberOfMainDetails,numberOfMainAttributes,hideOnEmpty,listMode;{sorting_legend},listSorting,addCustomOrder;{redirect_legend},jumpTo;{item_extension_legend:hide},addProvider,addContactPerson;{template_legend:hide},statusTokens,customTpl,realEstateTemplate,realEstateProviderTemplate,realEstateContactPersonTemplate;{image_legend:hide},imgSize,providerImgSize,contactPersonImgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,maxTextLength';
$GLOBALS['TL_DCA']['tl_module']['palettes']['realEstateResultList']  = '{title_legend},name,headline,type;{config_legend},realEstateGroups,numberOfItems,perPage,numberOfMainDetails,numberOfMainAttributes,filterMode,addCountLabel;{provider_legend},filterByProvider;{sorting_legend},addSorting,addCustomOrder;{redirect_legend},jumpTo;{item_extension_legend:hide},addProvider,addContactPerson;{template_legend:hide},statusTokens,customTpl,realEstateTemplate,realEstateProviderTemplate,realEstateContactPersonTemplate;{image_legend:hide},imgSize,providerImgSize,contactPersonImgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Add subpalettes
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['listMode_group']     = 'realEstateGroups,filterMode';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['listMode_type']      = 'realEstateTypes,filterMode';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['listMode_provider']  = 'realEstateGroups,provider,filterMode';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['filterByProvider']   = 'provider';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['addSorting']         = 'defaultSorting';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['addCustomOrder']     = 'customOrder';

// Add fields
$GLOBALS['TL_DCA']['tl_module']['fields']['realEstateTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateTemplate'],
    'default'                 => 'real_estate_item_default',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback' => function () {
        return Contao\Controller::getTemplateGroup('real_estate_item_');
    },
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['realEstateContactPersonTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateContactPersonTemplate'],
    'default'                 => 'real_estate_itemext_contact_person_default',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback' => function () {
        return Contao\Controller::getTemplateGroup('real_estate_itemext_');
    },
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['realEstateProviderTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateProviderTemplate'],
    'default'                 => 'real_estate_itemext_provider_default',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback' => function () {
        return Contao\Controller::getTemplateGroup('real_estate_itemext_');
    },
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'foreignKey'              => 'tl_filter.title',
    'options_callback'        => array('tl_module_estate_manager', 'getFilter'),
    'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "int(10) unsigned NOT NULL default 0",
    'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['listMode'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['listMode'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('visited', 'group', 'type', 'provider', 'vacation'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
    'eval'                    => array('tl_class'=>'w50 clr','submitOnChange'=>true),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hideOnEmpty'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hideOnEmpty'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['realEstateGroups'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateGroups'],
    'exclude'                 => true,
    'inputType'               => 'checkboxWizard',
    'foreignKey'              => 'tl_real_estate_group.title',
    'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr'),
    'sql'                     => "blob NULL",
    'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['realEstateTypes'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateTypes'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr'),
    'options_callback'        => array('tl_module_estate_manager', 'getRealEstateTypes'),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addCountLabel'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addCountLabel'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['listSorting'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['listSorting'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('none', 'dateAdded_asc', 'dateAdded_desc', 'tstamp_asc', 'tstamp_desc'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addSorting'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addSorting'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filterByProvider'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filterByProvider'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['provider'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['provider'],
    'exclude'                 => true,
    'inputType'               => 'checkboxWizard',
    'foreignKey'              => 'tl_provider.anbieternr',
    'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr'),
    'sql'                     => "varchar(255) NOT NULL default ''",
    'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['defaultSorting'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['defaultSorting'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('date'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addCustomOrder'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addCustomOrder'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['customOrder'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['customOrder'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addProvider'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addProvider'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addContactPerson'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addContactPerson'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filterMode'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filterMode'],
    'default'                 => 'default',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('default'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['maxTextLength'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['maxTextLength'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['statusTokens'],
    'exclude'                 => true,
    'inputType'               => 'checkboxWizard',
    'options'                 => array('new', 'reserved', 'rented', 'sold'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['allowUnpublishedRecords'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['allowUnpublishedRecords'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['exposeModules'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['exposeModules'],
    'default'                 => array(array('mod'=>0, 'col'=>'wrapper_before', 'enable'=>1)),
    'exclude'                 => true,
    'inputType'               => 'exposeModuleWizard',
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['contactPersonImgSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['contactPersonImgSize'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return Contao\System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(Contao\BackendUser::getInstance());
    },
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['providerImgSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['providerImgSize'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return Contao\System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(Contao\BackendUser::getInstance());
    },
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['numberOfMainDetails'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['numberOfMainDetails'],
    'default'                 => 0,
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
    'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['numberOfMainAttributes'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['numberOfMainAttributes'],
    'default'                 => 0,
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
    'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_module_estate_manager extends Contao\Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * Get all filter and return them as array
     *
     * @return array
     */
    public function getFilter(): array
    {
        if (!$this->User->isAdmin && !is_array($this->User->filter))
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
     * Return a list of real estate groups
     *
     * @return array
     */
    public function getRealEstateTypes(): array
    {
        $objGroup = $this->Database->prepare("SELECT id, title FROM tl_real_estate_group")->execute();
        $arrGroup = $objGroup->fetchEach('title');

        $objTypes = $this->Database->prepare("SELECT id, pid, title, longTitle FROM tl_real_estate_type ORDER BY pid, title")->execute();

        if ($objGroup->numRows < 1 || $objTypes->numRows < 1)
        {
            return array();
        }

        $return = array();
        $currId = 0;

        while ($objTypes->next())
        {
            if($objTypes->pid !== $currId)
            {
                $currId = $objTypes->pid;
                $return[$arrGroup[$currId]] = [];
            }

            $return[$arrGroup[$currId]][$objTypes->id] = $objTypes->title . ' [' . $objTypes->longTitle . ']';
        }

        return $return;
    }
}
