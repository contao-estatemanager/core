<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_interface'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_interface_mapping', 'tl_interface_log'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'markAsCopy'                  => 'title',
        'onload_callback' => array
        (
            array('tl_interface', 'checkPermission')
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
            'fields'                  => array('title', 'type', 'lastSync'),
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
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['edit'],
                'href'                => 'table=tl_interface_mapping',
                'icon'                => 'edit.svg'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.svg',
                'button_callback'     => array('tl_interface', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_interface', 'copyInterface')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_interface', 'deleteInterface')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            ),
            'history' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['history'],
                'href'                => 'table=tl_interface_history',
                'icon'                => 'show.svg'
            ),
            'sync' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['sync'],
                'href'                => 'key=syncRealEstates',
                'icon'                => 'sync.svg'
            ),
            'log' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['log'],
                'href'                => 'table=tl_interface_log',
                'icon'                => 'changelog.svg',
            ),
            'clear' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['clear'],
                'href'                => 'key=clearRealEstates',
                'icon'                => 'rows.svg',
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'   => array('type', 'importThirdPartyRecords'),
        'default'        => '{title_legend},title,type',
        'openimmo'       => '{title_legend},title,type;{oi_field_legend},provider,anbieternr,uniqueProviderField,uniqueField,importPath,filesPath,filesPathContactPerson;{related_records_legend},contactPersonActions,contactPersonUniqueField,importThirdPartyRecords;{skip_legend},skipRecords;{sync_legend},autoSync,deleteFilesOlderThen',
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'importThirdPartyRecords_assign'   => 'assignContactPersonKauf,assignContactPersonMietePacht,assignContactPersonErbpacht,assignContactPersonLeasing',
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
        'lastSync' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'type' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['type'],
            'default'                 => 'openimmo',
            'exclude'				  => true,
            'inputType'				  => 'select',
            'options'				  => array ('openimmo'),
            'eval'					  => array('submitOnChange'=>true, 'tl_class'=>'w50'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface'],
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'provider' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['provider'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'foreignKey'              => 'tl_provider.firma',
            'eval'                    => array('submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'anbieternr' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['anbieternr'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'uniqueProviderField' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['uniqueProviderField'],
            'exclude'				  => true,
            'inputType'				  => 'select',
            'eval'					  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'		  => array('tl_interface', 'getUniqueProviderFieldOptions'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'uniqueField' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['uniqueField'],
            'exclude'				  => true,
            'search'                  => true,
            'inputType'				  => 'select',
            'eval'					  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'		  => array('tl_interface', 'getUniqueFieldOptions'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'importPath' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['importPath'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'w50'),
            'sql'                     => "binary(16) NULL"
        ),
        'filesPath' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['filesPath'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'w50'),
            'sql'                     => "binary(16) NULL"
        ),
        'filesPathContactPerson' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['filesPathContactPerson'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'w50'),
            'sql'                     => "binary(16) NULL"
        ),
        'contactPersonActions' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['contactPersonActions'],
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options'                 => array('create', 'update'),
            'eval'                    => array('multiple'=>true, 'tl_class'=>'w50'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface'],
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'contactPersonUniqueField' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['contactPersonUniqueField'],
            'default'                 => 'personennummer',
            'exclude'				  => true,
            'inputType'				  => 'select',
            'eval'					  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'		  => array('tl_interface', 'getContactPersonUniqueFieldOptions'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'importThirdPartyRecords' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['importThirdPartyRecords'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'eval'                    => array('includeBlankOption'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50 clr'),
            'options'                 => array('import', 'assign'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface'],
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'assignContactPersonKauf' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['assignContactPersonKauf'],
            'exclude'				  => true,
            'inputType'				  => 'select',
            'foreignKey'              => 'tl_contact_person.name',
            'eval'					  => array('includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'        => array('tl_interface', 'getContactPerson'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'assignContactPersonMietePacht' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['assignContactPersonMietePacht'],
            'exclude'				  => true,
            'inputType'				  => 'select',
            'foreignKey'              => 'tl_contact_person.name',
            'eval'					  => array('includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'        => array('tl_interface', 'getContactPerson'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'assignContactPersonErbpacht' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['assignContactPersonErbpacht'],
            'exclude'				  => true,
            'inputType'				  => 'select',
            'foreignKey'              => 'tl_contact_person.name',
            'eval'					  => array('includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'        => array('tl_interface', 'getContactPerson'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'assignContactPersonLeasing' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['assignContactPersonLeasing'],
            'exclude'				  => true,
            'inputType'				  => 'select',
            'foreignKey'              => 'tl_contact_person.name',
            'eval'					  => array('includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'options_callback'        => array('tl_interface', 'getContactPerson'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'skipRecords' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['skipRecords'],
            'exclude'				  => true,
            'inputType'				  => 'checkbox',
            'eval'					  => array('multiple'=>true),
            'options'                 => array('objekttitel', 'objektbeschreibung'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface'],
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'autoSync' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['autoSync'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array(0=>'never', 1=>'min', 10=>'10min', 30=>'30min', 60=>'hourly', 1440=>'daily', 10080=>'weekly'),
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface'],
            'sql'                     => "varchar(8) NOT NULL default ''"
        ),
        'deleteFilesOlderThen' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
            'options_callback'        => array('tl_interface', 'getDeleteFilesOlderThenOptions'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_interface extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');

        $this->loadDataContainer('tl_provider');
        $this->loadDataContainer('tl_real_estate');
    }

    /**
     * Check permissions to edit table tl_interface
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
        return $this->User->canEditFieldsOf('tl_interface') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function copyInterface($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('create', 'interface') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function deleteInterface($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'interface') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return all unique provider field options as array
     *
     * @param \DataContainer  $dc
     *
     * @return array
     */
    public function getUniqueProviderFieldOptions($dc)
    {
        $return = array();

        foreach ($GLOBALS['TL_DCA']['tl_provider']['fields'] as $field => $options)
        {
            if (array_key_exists('realEstate', $options) && array_key_exists('unique', $options['realEstate']))
            {
                $return[] = $field;
            }
        }

        return $return;
    }

    /**
     * Return all unique field options as array
     *
     * @param \DataContainer  $dc
     *
     * @return array
     */
    public function getUniqueFieldOptions($dc)
    {
        $return = array();

        foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields'] as $field => $options)
        {
            if (array_key_exists('realEstate', $options) && array_key_exists('unique', $options['realEstate']))
            {
                $return[] = $field;
            }
        }

        return $return;
    }

    /**
     * Return all unique field options as array
     *
     * @param \DataContainer  $dc
     *
     * @return array
     */
    public function getContactPersonUniqueFieldOptions($dc)
    {
        $this->loadDataContainer('tl_contact_person');

        $return = array();

        foreach ($GLOBALS['TL_DCA']['tl_contact_person']['fields'] as $field => $options)
        {
            if (array_key_exists('realEstate', $options) && array_key_exists('unique', $options['realEstate']))
            {
                $return[] = $field;
            }
        }

        $return[] = 'name_vorname';

        return $return;
    }

    /**
     * Return all contact person of assigned provider as array
     *
     * @param \DataContainer  $dc
     *
     * @return array
     */
    public function getContactPerson($dc)
    {
        $objContactPerson = $this->Database->prepare("SELECT id, name, vorname FROM tl_contact_person WHERE pid=?")->execute($dc->activeRecord->provider);

        if ($objContactPerson->numRows < 1)
        {
            return array();
        }

        $arrContactPerson = array();

        while ($objContactPerson->next())
        {
            $arrContactPerson[$objContactPerson->id] = $objContactPerson->vorname . ' ' . $objContactPerson->name;
        }

        return $arrContactPerson;
    }

    /**
     * Return delete files older than options as array
     *
     * @param \DataContainer  $dc
     *
     * @return array
     */
    public function getSyncOptions($dc)
    {
        return array
        (
            '0'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_none'],
            '1'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_day'],
            '3'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_three_days'],
            '7'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_week'],
            '14'  => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_two_weeks'],
            '30'  => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_month'],
            '90'  => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_three_months'],
            '183' => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_half_year'],
            '365' => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_year'],
        );
    }

    /**
     * Return delete files older than options as array
     *
     * @param \DataContainer  $dc
     *
     * @return array
     */
    public function getDeleteFilesOlderThenOptions($dc)
    {
        return array
        (
            '0'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_none'],
            '1'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_day'],
            '3'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_three_days'],
            '7'   => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_week'],
            '14'  => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_two_weeks'],
            '30'  => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_month'],
            '90'  => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_three_months'],
            '183' => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_half_year'],
            '365' => &$GLOBALS['TL_LANG']['tl_interface']['deleteFilesOlderThen_year'],
        );
    }
}
