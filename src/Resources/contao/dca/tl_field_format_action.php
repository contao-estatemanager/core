<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

Contao\System::loadLanguageFile('tl_real_estate');
Contao\System::loadLanguageFile('tl_field_format');

$GLOBALS['TL_DCA']['tl_field_format_action'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_field_format',
        'enableVersioning'            => true,
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
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format_action']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
                'button_callback'     => array('tl_field_format_action', 'editFormatAction')
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
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
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
        '__selector__'                => array('action'),
        'default'                     => '{type_legend},action;',
        'prepend'                     => '{type_legend},action;{setting_legend},text;',
        'append'                      => '{type_legend},action;{setting_legend},text;',
        'number_format'               => '{type_legend},action;{setting_legend},decimals;',
        'strtotime'                   => '{type_legend},action;',
        'date_format'                 => '{type_legend},action;',
        'ucfirst'                     => '{type_legend},action;{setting_legend};',
        'wrap'                        => '{type_legend},action;{setting_legend},text;',
        'unserialize'                 => '{type_legend},action;{setting_legend},seperator;',
        'boolToWord'                  => '{type_legend},action;{setting_legend},necessary;',
        'combine'                     => '{type_legend},action;{setting_legend},elements,seperator;',
        'custom'                      => '{type_legend},action;{setting_legend},customFunction;'
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
            'exclude'                 => true,
            'default'                 => time(),
            'sorting'                 => true,
            'flag'                    => 6,
            'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'action'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['action'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('prepend', 'append', 'number_format', 'date_format', 'strtotime', 'ucfirst', 'wrap', 'unserialize', 'combine', 'boolToWord', 'custom'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_field_format_action'],
            'eval'                    => array('helpwizard'=>true, 'tl_class'=>'w50', 'chosen' => true, 'submitOnChange'=>true, 'includeBlankOption'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'decimals'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['decimals'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'text'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['text'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50', 'mandatory'=>true, 'doNotTrim' => true, 'allowHtml'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'seperator'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['seperator'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50', 'doNotTrim' => true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'necessary'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['necessary'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'elements'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['elements'],
            'exclude'                 => true,
            'inputType' 	          => 'multiColumnWizard',
            'eval' 			          => array
            (
                'dragAndDrop'  => true,
                'columnFields' => array
                (
                    'field' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_field_format_action']['field'],
                        'inputType'             => 'select',
                        'options_callback'      => array('tl_field_format_action', 'getRealEstateColumns'),
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_field_format_action']['customFunction'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_field_format_action', 'getCustomFunctions'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'sorting'   => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['MSC']['sorting'],
            'exclude'                 => true,
            'sorting'                 => true,
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "int(10) unsigned NULL"
        )
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_field_format_action extends Contao\Backend
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
     * Get fields from real estate dca
     *
     * @return array
     */
    public function getRealEstateColumns(): array
    {
        $options   = array();
        $skipFields = array('id', 'alias', 'published', 'titleImageSRC', 'imageSRC', 'planImageSRC', 'interiorViewImageSRC', 'exteriorViewImageSRC', 'mapViewImageSRC', 'panormaImageSRC', 'epassSkalaImageSRC', 'panoramaImageSRC', 'logoImageSRC', 'qrImageSRC', 'documents', 'links');

        $this->loadDataContainer('tl_real_estate');

        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields'] ?? null))
        {
            foreach (array_keys($GLOBALS['TL_DCA']['tl_real_estate']['fields']) as $field)
            {
                if (!in_array($field, $skipFields))
                {
                    $options[$field] = ($field.' ['.$GLOBALS['TL_LANG']['tl_real_estate'][$field][0].']') ?? '';
                }
            }
        }

        return $options;
    }

    /**
     * Return the edit format action button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function editFormatAction(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->canEditFieldsOf('tl_field_format_action') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Stringify Format Action und return it as string
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function stringifyFormatAction(array $arrRow): string
    {
        return '<div class="tl_content_left">' . $arrRow['action'] . '</div>';
    }

    /**
     * Return all custom function templates as array
     *
     * @return array
     */
    public function getCustomFunctions(): array
    {
        return $this->getTemplateGroup('re_ac_');
    }
}
