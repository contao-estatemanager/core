<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_interface_mapping'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_interface',
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_interface_mapping', 'checkPermission')
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
            'fields'                  => array('attribute', 'oiFieldGroup'),
            'headerFields'            => array('title', 'tstamp'),
            'panelLayout'             => 'filter;sort,search,limit',
            'child_record_callback'   => array('tl_interface_mapping', 'stringifyMapping'),
            'child_record_class'      => 'no_padding'
        ),
        'global_operations' => array
        (
            'importDefaultMappings' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_interface_mapping']['importDefaultMappings'],
                'href'              => 'key=importDefaultMappings',
                'class'             => 'header_default_mapping_import',
                'icon'              => 'sync.svg',
                'attributes'        => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_interface_mapping']['importConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
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
                'label'               => &$GLOBALS['TL_LANG']['tl_interface_mapping']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface_mapping']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset()"'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface_mapping']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface_mapping']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('type', 'forceActive', 'formatType'),
        'default'                     => '{type_legend},type;',
        'tl_real_estate'              => '{type_legend},type,attribute;{field_legend},oiFieldGroup,oiField,oiConditionField,oiConditionValue,serialize,forceActive;{format_legend},formatType;{expert_legend},saveImage',
        'tl_contact_person'           => '{type_legend},type,attribute;{field_legend},oiFieldGroup,oiField,oiConditionField,oiConditionValue,serialize,forceActive;{format_legend},formatType;{expert_legend},saveImage'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'forceActive'                 => 'forceValue',
        'formatType_number'           => 'decimals',
        'formatType_date'             => 'dateFormat',
        'formatType_text'             => 'textTransform,trim',
        'formatType_boolean'          => 'booleanCompareValue',
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'foreignKey'              => 'tl_interface.title',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'type' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface_mapping']['type'],
            'default'                 => 'tl_real_estate',
            'exclude'				  => true,
            'inputType'				  => 'select',
            'options'				  => array('tl_real_estate', 'tl_contact_person'),
            'eval'					  => array('submitOnChange'=>true, 'tl_class'=>'w50'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface_mapping'],
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'attribute'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['attribute'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'select',
            'options_callback'		  => array('tl_interface_mapping', 'getAttributeFields'),
            'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'oiField'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['oiField'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'oiFieldGroup'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['oiFieldGroup'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'oiConditionField'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['oiConditionField'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'oiConditionValue'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['oiConditionValue'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'serialize' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['serialize'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'forceActive' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['forceActive'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'forceValue'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['forceValue'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'formatType' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['formatType'],
            'default'                 => 'none',
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'options'                 => array('none', 'number', 'date', 'text', 'boolean'),
            'eval'                    => array('helpwizard'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50 clr'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface_mapping'],
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'decimals'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['decimals'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'dateFormat'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['dateFormat'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'textTransform' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['textTransform'],
            'default'                 => 'lowercase',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('none', 'lowercase', 'uppercase', 'capitalize', 'removespecialchar'),
            'eval'                    => array('tl_class'=>'w50'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface_mapping'],
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'trim' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['trim'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'booleanCompareValue'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['booleanCompareValue'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'saveImage' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface_mapping']['saveImage'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_interface_mapping extends Contao\Backend
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
     * Check permissions to edit table tl_interface_mapping
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission(): void
    {
        return;
    }

    /**
     * Stringify mapping und return it as string
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function stringifyMapping(array $arrRow): string
    {
        return '<div class="tl_content_left">' . $arrRow['attribute'] . ' <span style="color:#999;padding-left:3px">(' . $arrRow['oiFieldGroup'] . ': ' . $arrRow['oiField'] . ')</span></div>';
    }

    /**
     * Return all attribute fields as array
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getAttributeFields(Contao\DataContainer $dc): array
    {
        if (!$dc->activeRecord)
        {
            return array();
        }

        $this->loadLanguageFile($dc->activeRecord->type);
        $this->loadDataContainer($dc->activeRecord->type);

        $arrFields = array();

        foreach ($GLOBALS['TL_DCA'][$dc->activeRecord->type]['fields'] as $field => $config)
        {
            $arrFields[$field] = $GLOBALS['TL_LANG']['tl_real_estate'][$field][0] . ' [' . $field . ']';
        }

        $arrFields['AUFTRAGSART'] = $GLOBALS['TL_LANG']['tl_real_estate']['AUFTRAGSART'][0] . ' [' . 'AUFTRAGSART' . ']';

        return $arrFields;
    }
}
