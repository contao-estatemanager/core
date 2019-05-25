<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */


$GLOBALS['TL_DCA']['tl_field_format_action'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_field_format',
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_field_format_action', 'checkPermission')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('sorting'),
            'headerFields'            => array('fieldname'),
            'panelLayout'             => 'filter;sort,search,limit',
            'child_record_callback'   => array('tl_field_format_action', 'stringifyFormatAction'),
            'child_record_class'      => 'no_padding'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'              => 'act=select',
                'class'             => 'header_edit_all',
                'attributes'        => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format_action']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format_action']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.svg'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format_action']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'  => array(
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format_action']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif',
                'attributes'          => 'style="margin-right:3px"'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'  => array('action'),
        'default'       => '{type_legend},action;',
        'prepend'       => '{type_legend},action;{setting_legend},text;',
        'append'        => '{type_legend},action;{setting_legend},text;',
        'number_format' => '{type_legend},action;{setting_legend},decimals;',
        'date_format'   => '{type_legend},action;',
        'ucfirst'       => '{type_legend},action;{setting_legend};',
        'wrap'          => '{type_legend},action;{setting_legend},text;',
        'unserialize'   => '{type_legend},action;{setting_legend},seperator;',
        'boolToWord'    => '{type_legend},action;{setting_legend},necessary;',
        'combine'       => '{type_legend},action;{setting_legend},elements,seperator;',
        'custom'        => '{type_legend},action;{setting_legend},customFunction;'
    ),

    // Fields
    'fields'   => array
    (
        /**
         * Database / Intern
         */
        'id'     => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'foreignKey'              => 'tl_field_format.fieldname',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
            'default'                 => time(),
            'sorting'                 => true,
            'flag'                    => 6,
            'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'action'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['action'],
            'inputType'                 => 'select',
            'options'                   => array(
                'prepend'           => 'prepend',
                'append'            => 'append',
                'number_format'     => 'number_format',
                'date_format'       => 'date_format',
                'ucfirst'           => 'ucfirst',
                'wrap'              => 'wrap',
                'unserialize'       => 'unserialize',
                'combine'           => 'combine',
                'boolToWord'        => 'boolToWord',
                'custom'            => 'custom'
            ),
            'reference'                 => &$GLOBALS['TL_LANG']['FMD'],
            'eval'                      => array('tl_class'=>'w50', 'chosen' => true, 'submitOnChange'=>true, 'includeBlankOption'=>true),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'decimals'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['decimals'],
            'inputType'                 => 'text',
            'eval'                      => array('rgxp'=>'digit', 'tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'text'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['text'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50', 'mandatory'=>true, 'doNotTrim' => true, 'allowHtml'=>true),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'seperator'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['seperator'],
            'inputType'                 => 'text',
            'eval'                      => array('tl_class'=>'w50', 'doNotTrim' => true),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'necessary'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['necessary'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "char(1) NOT NULL default ''"
        ),
        'elements'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['elements'],
            'inputType' 	            => 'multiColumnWizard',
            'eval' 			            => array
            (
                'dragAndDrop'  => true,
                'columnFields' => array
                (
                    'field' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_field_format_action']['field'],
                        'inputType'             => 'select',
                        'options_callback'      => array('tl_field_format_action', 'getRealEstateCollumns'),
                        'eval' 			        => array('style'=>'width:100%', 'chosen' => true)
                    ),
                    'remove' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_field_format_action']['remove'],
                        'inputType'             => 'checkbox'
                    ),
                )
            ),
            'sql'                     => "blob NULL"
        ),
        'customFunction'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format_action']['customFunction'],
            'inputType'                 => 'select',
            'options_callback'          => array('tl_field_format_action', 'getCustomFunctions'),
            'eval'                      => array('tl_class'=>'w50'),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'sorting'   => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['MSC']['sorting'],
            'sorting'               => true,
            'eval'                  => array('doNotCopy'=>true),
            'sql'                   => "int(10) unsigned NULL"
        )
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_field_format_action extends \Backend
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
     * Check permissions to edit table tl_field_format_action
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Stringify Format Action und return it as string
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function stringifyFormatAction($arrRow)
    {
        return '<div class="tl_content_left">' . $arrRow['action'] . '</div>';
    }

    /**
     * Get fields from real estate dca
     *
     * @return array
     */
    public function getRealEstateCollumns(){
        $collumns      = array();
        $skipFields    = array('id', 'alias', 'published', 'titleImageSRC', 'imageSRC', 'planImageSRC', 'interiorViewImageSRC', 'exteriorViewImageSRC', 'mapViewImageSRC', 'panormaImageSRC', 'epassSkalaImageSRC', 'logoImageSRC', 'qrImageSRC', 'documents', 'links');

        $this->loadDataContainer('tl_real_estate');

        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']))
        {
            foreach (array_keys($GLOBALS['TL_DCA']['tl_real_estate']['fields']) as $field)
            {
                if (!in_array($field, $skipFields))
                {
                    $collumns[$field] = $field;
                }
            }
        }

        return $collumns;
    }

    public function getCustomFunctions(){
        return $this->getTemplateGroup('re_ac_');
    }
}