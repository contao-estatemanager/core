<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
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
        'oncreate_callback' => array
        (
            array('tl_filter', 'adjustPermissions')
        ),
        'oncopy_callback' => array
        (
            array('tl_filter', 'adjustPermissions')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'alias' => 'index'
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
            'format'                  => '%s' // ToDo: Wird das noch benötigt?
        ),
        'global_operations' => array
        (
            'administration' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['administration'],
                'href'                => 'do=administration',
                'icon'                => 'back.svg'
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
                'button_callback'     => array('tl_filter', 'copyFilter')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_filter', 'deleteFilter')
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
        'default'                     => '{title_legend},title,alias,jumpTo;{config_legend},groups,addBlankMarketingType,addBlankRealEstateType,submitOnChange;{toggle_filter_legend},toggleFilter,roomOptions;{template_legend:hide},customTpl;{expert_legend:hide},attributes,novalidate'
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
        'groups' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['groups'],
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'foreignKey'              => 'tl_real_estate_group.title',
            'options_callback'        => array('tl_filter', 'getRealEstateGroups'),
            'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr'),
            'sql'                     => "blob NULL",
            'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
        ),
        'addBlankMarketingType' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['addBlankMarketingType'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'addBlankRealEstateType' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['addBlankRealEstateType'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'submitOnChange' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['submitOnChange'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'toggleFilter'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['toggleFilter'],
            'inputType'               => 'checkboxWizard',
            'options'                 => array('price', 'per', 'room', 'area', 'period'),
            'toggleFields'            => array
            (
                'price' => array
                (
                    'fields' => array
                    (
                        'price_from',
                        'price_to'
                    ),
                    'hide' => 'price_from',
                    'rgxp' => 'natural'
                ),
                'per' => array
                (
                    'fields' => array
                    (
                        'price_per'
                    ),
                    'hide' => false,
                    'rgxp' => 'alnum'
                ),
                'room' => array
                (
                    'fields' => array
                    (
                        'room_from',
                        'room_to'
                    ),
                    'hide' => 'room_to',
                    'options' => 'roomOptions',
                    'rgxp' => 'digit'
                ),
                'area' => array
                (
                    'fields' => array
                    (
                        'area_from',
                        'area_to'
                    ),
                    'hide' => 'area_to',
                    'rgxp' => 'natural'
                ),
                'period' => array
                (
                    'fields' => array
                    (
                        'period_from',
                        'period_to'
                    ),
                    'hide' => 'period_to',
                    'rgxp' => 'date'
                )
            ),
            'reference'               => &$GLOBALS['TL_LANG']['tl_filter'],
            'eval'                    => array('multiple'=>true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'roomOptions' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['roomOptions'],
            'default'                 => '1,2,3,4,5,6,7,8',
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''",
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
        'attributes' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['attributes'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'novalidate' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['novalidate'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'toggleMode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter']['toggleMode'],
            'sql'                     => "varchar(32) NOT NULL default 'typeSeparated'"
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
     * Add the new filter to the permissions
     *
     * @param $insertId
     */
    public function adjustPermissions($insertId)
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

        // Generate alias if there is none
        if ($varValue == '')
        {
            $autoAlias = true;

            $varValue = System::getContainer()->get('contao.slug.generator')->generate(StringUtil::stripInsertTags($dc->activeRecord->title));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_filter WHERE alias=? AND id!=?")
            ->execute($varValue, $dc->id);

        // Check whether the filter alias exists
        if ($objAlias->numRows)
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
     * Return a list of real estate groups
     *
     * @return array
     */
    public function getRealEstateGroups()
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
    public function copyFilter($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('create', 'filterp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function deleteFilter($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'filterp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }
}
