<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

$GLOBALS['TL_DCA']['tl_expose_module'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_expose_module', 'checkPermission'),
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 2,
            'fields'                  => array('name'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;sort,search,limit',
        ),
        'label' => array
        (
            'fields'                  => array('name')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset()"'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('type', 'protected'),
        'default'                     => '{title_legend},name,headline,type',
        'title'                       => '{title_legend},name,headline,type;{title_output_legend},titleSize;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'protected'                   => 'groups',
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['name'],
            'exclude'                 => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'headline' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['headline'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'inputUnit',
            'options'                 => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
            'eval'                    => array('maxlength'=>200, 'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'type' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['type'],
            'default'                 => 'title',
            'exclude'                 => true,
            'sorting'                 => true,
            'flag'                    => 11,
            'filter'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getExposeModules'),
            'reference'               => &$GLOBALS['TL_LANG']['FMD'],
            'eval'                    => array('helpwizard'=>true, 'chosen'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'customTpl' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['customTpl'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getExposeModuleTemplates'),
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'protected' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['protected'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'groups' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['groups'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'foreignKey'              => 'tl_member_group.name',
            'eval'                    => array('mandatory'=>true, 'multiple'=>true),
            'sql'                     => "blob NULL",
            'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
        ),
        'guests' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['guests'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'cssID' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['cssID'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'titleSize' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['titleSize'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(2) NOT NULL default ''"
        )
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_expose_module extends Backend
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
     * Check permissions to edit the table
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Return all front end modules as array
     *
     * @return array
     */
    public function getExposeModules()
    {
        $groups = array();

        foreach ($GLOBALS['FE_EXPOSE_MOD'] as $k=>$v)
        {
            foreach (array_keys($v) as $kk)
            {
                $groups[$k][] = $kk;
            }
        }

        return $groups;
    }

    /**
     * Return all module templates as array
     *
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getExposeModuleTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('expose_mod_' . $dc->activeRecord->type);
    }
}
