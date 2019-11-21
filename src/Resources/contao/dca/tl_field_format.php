<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

use ContaoEstateManager\FieldFormatModel;

System::loadLanguageFile('tl_real_estate');

$GLOBALS['TL_DCA']['tl_field_format'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_field_format_action'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'markAsCopy'                  => 'fieldname',
        'onload_callback' => array
        (
            array('tl_field_format', 'checkPermission')
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
            'mode'                    => 1,
            'fields'                  => array('fieldname'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;sort,search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('fieldname'),
            'showColumns'             => true
        ),
        'global_operations' => array
        (
            'importFieldFormats' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_field_format']['importFieldFormats'],
                'href'              => 'key=importFieldFormats',
                'class'             => 'header_field_format_import',
                'icon'              => 'sync.svg',
                'attributes'        => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_field_format']['importConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
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
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format']['edit'],
                'href'                => 'table=tl_field_format_action',
                'icon'                => 'edit.svg'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.svg',
                'button_callback'     => array('tl_field_format', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_field_format', 'copyGroup')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_field_format', 'deleteArchive')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_field_format']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'  => array('useCondition'),
        'default'       => '{format_legend},fieldname,cssClass,forceOutput,useCondition;'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'useCondition'  => 'conditionFields'
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
        'tstamp' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
            'default'                 => time(),
            'sorting'                 => true,
            'flag'                    => 6,
            'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'fieldname'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format']['fieldname'],
            'inputType'                 => 'select',
            'exclude'                   => true,
            'search'                    => true,
            'options_callback'          => array('tl_field_format', 'getRealEstateColumns'),
            'eval'                      => array('tl_class'=>'w50', 'mandatory'=>true, 'chosen' => true),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'cssClass'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format']['cssClass'],
            'inputType'                 => 'text',
            'exclude'                   => true,
            'search'                    => true,
            'eval'                      => array('tl_class'=>'w50', 'maxlength'=>255),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'forceOutput'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format']['forceOutput'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class'=>'w50 m12'),
            'sql'                       => "char(1) NOT NULL default ''"
        ),
        'useCondition'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format']['useCondition'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class'=>'w50 m12', 'submitOnChange'=>true),
            'sql'                       => "char(1) NOT NULL default ''"
        ),
        'conditionFields'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_field_format']['conditionFields'],
            'inputType' 	            => 'multiColumnWizard',
            'eval' 			            => array
            (
                'columnFields' => array
                (
                    'field' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_field_format']['field'],
                        'inputType'             => 'select',
                        'options_callback'      => array('tl_field_format', 'getRealEstateColumns'),
                        'eval' 			        => array('style'=>'width:100%', 'chosen' => true)
                    ),
                    'value' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_field_format_action']['value'],
                        'inputType'             => 'text',
                        'eval' 			        => array('style'=>'width:100%')
                    )
                )
            ),
            'sql'                     => "blob NULL"
        ),
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class tl_field_format extends Backend
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
     * Check permissions to edit table tl_filter_group
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Return the edit header button
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
    public function editHeader($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_field_format') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the copy group button
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
    public function copyGroup($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('create', 'fieldformat') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the delete archive button
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
    public function deleteArchive($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'fieldformat') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Get fields from real estate dca
     *
     * @return array
     */

    public function getRealEstateColumns(){
        $options   = array();
        $skipFields = array('id', 'alias', 'published', 'titleImageSRC', 'imageSRC', 'planImageSRC', 'interiorViewImageSRC', 'exteriorViewImageSRC', 'mapViewImageSRC', 'panormaImageSRC', 'epassSkalaImageSRC', 'panoramaImageSRC', 'logoImageSRC', 'qrImageSRC', 'documents', 'links');

        $this->loadDataContainer('tl_real_estate');

        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']))
        {
            foreach (array_keys($GLOBALS['TL_DCA']['tl_real_estate']['fields']) as $field)
            {
                if (!in_array($field, $skipFields))
                {
                    $options[$field] = $GLOBALS['TL_LANG']['tl_real_estate'][$field][0] . ' [' . $field . ']';
                }
            }
        }

        return $options;
    }
}
