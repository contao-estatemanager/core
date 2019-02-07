<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

$GLOBALS['TL_DCA']['tl_filter'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_filter_item'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'markAsCopy'                  => 'title',
        'onload_callback' => array
        (
            array('tl_filter', 'checkPermission')
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
            'fields'                  => array('title'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('title'),
            'format'                  => '%s'
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
                'label'               => &$GLOBALS['TL_LANG']['tl_filter']['edit'],
                'href'                => 'table=tl_filter_item',
                'icon'                => 'edit.svg'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.svg',
                'button_callback'     => array('tl_filter', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_filter', 'copy')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_filter', 'delete')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend},title,alias,jumpTo;{filter_mode_legend:hide},filterMode,listFilter;{template_legend:hide},customTpl;{expert_legend:hide},method,novalidate,attributes,formID'
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
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'alias' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['alias'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
            'save_callback' => array
            (
                array('tl_filter', 'generateAlias')
            ),
            'sql'                     => "varchar(128) BINARY NOT NULL default ''"
        ),
        'jumpTo' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['jumpTo'],
            'exclude'                 => true,
            'inputType'               => 'pageTree',
            'foreignKey'              => 'tl_page.title',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'filterMode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['filterMode'],
            'default'                 => 'default',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('default', 'neubau', 'referenz'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''"
        ),
        'listFilter'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['listFilter'],
            'inputType' 	          => 'multiColumnWizard',
            'eval' 			          => array
            (
                'dragAndDrop'  => true,
                'columnFields' => array
                (
                    'group' => array
                    (
                        'label'       => &$GLOBALS['TL_LANG']['tl_filter']['listFilter'],
                        'exclude'     => true,
                        'inputType'   => 'select',
                        'options'     => array('price', 'per', 'room', 'area', 'period', 'radius'),
                        'eval' 		  => array('style'=>'width:100%', 'chosen'=>true)
                    )
                ),
                'tl_class' => 'long clr'
            ),
            'sql'                     => "blob NULL"
        ),
        'customTpl' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['customTpl'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_filter', 'getFilterWrapperTemplates'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'method' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['method'],
            'default'                 => 'POST',
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'options'                 => array('POST', 'GET'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(12) NOT NULL default ''"
        ),
        'novalidate' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['novalidate'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'attributes' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['attributes'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'formID' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['formID'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('nospace'=>true, 'doNotCopy'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class tl_filter extends Backend
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
     * Check permissions to edit table tl_filter
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Auto-generate a filter alias if it has not been set yet
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate an alias if there is none
        if ($varValue == '')
        {
            $autoAlias = true;
            $varValue = StringUtil::generateAlias($dc->activeRecord->title);
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_filter WHERE id=? OR alias=?")
            ->execute($dc->id, $varValue);

        // Check whether the form alias exists
        if ($objAlias->numRows > 1)
        {
            if (!$autoAlias)
            {
                throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
            }

            $varValue .= '-' . $dc->id;
        }

        return $varValue;
    }

    /**
     * Return all filter wrapper templates as array
     *
     * @return array
     */
    public function getFilterWrapperTemplates()
    {
        return $this->getTemplateGroup('filter_wrapper_');
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
        return $this->User->canEditFieldsOf('tl_filter') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the copy filter button
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
    public function copy($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('create', 'filter') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the delete filter button
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
    public function delete($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'filter') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }
}