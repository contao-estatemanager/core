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
        'oncreate_callback' => array
        (
            array('tl_interface', 'adjustPermissions')
        ),
        'oncopy_callback' => array
        (
            array('tl_interface', 'adjustPermissions')
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
            'fields'                  => array('type', 'title'),
            'flag'                    => 1,
            'panelLayout'             => 'search,limit'
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
            'sync' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['sync'],
                'href'                => 'key=syncRealEstates',
                'icon'                => 'sync.svg',
                'button_callback'     => array('tl_interface', 'syncInterface')
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
            'cleardata' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['cleardata'],
                'href'                => 'key=clearRealEstates',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['clearEstateConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'icon'                => 'bundles/estatemanager/icons/clear.svg'
            ),
            'history' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['history'],
                'href'                => 'table=tl_interface_history',
                'icon'                => 'bundles/estatemanager/icons/history.svg'
            ),
            'log' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['log'],
                'href'                => 'table=tl_interface_log',
                'icon'                => 'bundles/estatemanager/icons/log.svg'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('type', 'importThirdPartyRecords'),
        'default'                     => '{title_legend},title,type',
        'openimmo'                    => '{title_legend},title,type;{oi_field_legend},provider,anbieternr,uniqueProviderField,uniqueField,importPath,filesPath,filesPathContactPerson;{related_records_legend},contactPersonActions,contactPersonUniqueField,importThirdPartyRecords;{expert_legend},skipRecords,dontPublishRecords;{sync_legend},autoSync,deleteFilesOlderThen,filesPerSync',
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'importThirdPartyRecords_assign' => 'assignContactPersonKauf,assignContactPersonMietePacht,assignContactPersonErbpacht,assignContactPersonLeasing',
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
            'filter'                  => true,
            'inputType'				  => 'select',
            'options'				  => array ('openimmo'),
            'eval'					  => array('helpwizard'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
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
            'eval'					  => array('mandatory'=>true, 'tl_class'=>'w50 clr'),
            'options_callback'		  => array('tl_interface', 'getUniqueProviderFieldOptions'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'uniqueField' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['uniqueField'],
            'exclude'				  => true,
            'filter'                  => true,
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
        'dontPublishRecords' => array
        (
            'label'					  => &$GLOBALS['TL_LANG']['tl_interface']['dontPublishRecords'],
            'exclude'				  => true,
            'inputType'				  => 'checkbox',
            'eval'					  => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
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
        'filesPerSync' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_interface']['filesPerSync'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>2, 'rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "smallint(2) unsigned NOT NULL default '10'"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_interface extends Contao\Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');

        $this->loadDataContainer('tl_contact_person');
        $this->loadDataContainer('tl_provider');
        $this->loadDataContainer('tl_real_estate');

        $this->loadLanguageFile('tl_contact_person');
        $this->loadLanguageFile('tl_provider');
        $this->loadLanguageFile('tl_real_estate');
    }

    /**
     * Check permissions to edit table tl_interface
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission(): void
    {
        if ($this->User->isAdmin)
        {
            return;
        }

        // Set root IDs
        if (empty($this->User->interfaces) || !is_array($this->User->interfaces))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->interfaces;
        }

        if (Contao\Input::get('key') == 'syncRealEstates')
        {
            if (!in_array(Contao\Input::get('id'), $root) || !$this->User->hasAccess('sync', 'interfacep'))
            {
                throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to sync interface ID ' . Contao\Input::get('id') . '.');
            }
        }

        $GLOBALS['TL_DCA']['tl_interface']['list']['sorting']['root'] = $root;

        // Check permissions to add interface
        if (!$this->User->hasAccess('create', 'interfacep'))
        {
            $GLOBALS['TL_DCA']['tl_interface']['config']['closed'] = true;
            $GLOBALS['TL_DCA']['tl_interface']['config']['notCreatable'] = true;
            $GLOBALS['TL_DCA']['tl_interface']['config']['notCopyable'] = true;
        }

        // Check permissions to delete interfaces
        if (!$this->User->hasAccess('delete', 'interfacep'))
        {
            $GLOBALS['TL_DCA']['tl_interface']['config']['notDeletable'] = true;
        }

        /** @var Symfony\Component\HttpFoundation\Session\SessionInterface $objSession */
        $objSession = Contao\System::getContainer()->get('session');

        // Check current action
        switch (Contao\Input::get('act'))
        {
            case 'select':
                // Allow
                break;

            case 'create':
                if (!$this->User->hasAccess('create', 'interfacep'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to create interfaces.');
                }
                break;

            case 'edit':
            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Contao\Input::get('id'), $root) || (Contao\Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'interfacep')))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' interface ID ' . Contao\Input::get('id') . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'copyAll':
                $session = $objSession->all();

                if (Contao\Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'interfacep'))
                {
                    $session['CURRENT']['IDS'] = array();
                }
                else
                {
                    $session['CURRENT']['IDS'] = array_intersect((array) $session['CURRENT']['IDS'], $root);
                }
                $objSession->replace($session);
                break;

            default:
                if (Contao\Input::get('act'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' interface.');
                }
                break;
        }
    }

    /**
     * Add the new interface to the permissions
     *
     * @param $insertId
     */
    public function adjustPermissions($insertId)
    {
        // The oncreate_callback passes $insertId as second argument
        if (func_num_args() == 4)
        {
            $insertId = func_get_arg(1);
        }

        if ($this->User->isAdmin)
        {
            return;
        }

        // Set root IDs
        if (empty($this->User->interfaces) || !is_array($this->User->interfaces))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->interfaces;
        }

        // The interface is enabled already
        if (in_array($insertId, $root))
        {
            return;
        }

        /** @var Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $objSessionBag */
        $objSessionBag = Contao\System::getContainer()->get('session')->getBag('contao_backend');

        $arrNew = $objSessionBag->get('new_records');

        if (is_array($arrNew['tl_interface']) && in_array($insertId, $arrNew['tl_interface']))
        {
            // Add the permissions on group level
            if ($this->User->inherit != 'custom')
            {
                $objGroup = $this->Database->execute("SELECT id, interfaces, interfacep FROM tl_user_group WHERE id IN(" . implode(',', array_map('\intval', $this->User->groups)) . ")");

                while ($objGroup->next())
                {
                    $arrInterfacep = Contao\StringUtil::deserialize($objGroup->interfacep);

                    if (is_array($arrInterfacep) && in_array('create', $arrInterfacep))
                    {
                        $arrInterfaces = Contao\StringUtil::deserialize($objGroup->interfaces, true);
                        $arrInterfaces[] = $insertId;

                        $this->Database->prepare("UPDATE tl_user_group SET interfaces=? WHERE id=?")
                            ->execute(serialize($arrInterfaces), $objGroup->id);
                    }
                }
            }

            // Add the permissions on user level
            if ($this->User->inherit != 'group')
            {
                $objUser = $this->Database->prepare("SELECT interfaces, interfacep FROM tl_user WHERE id=?")
                    ->limit(1)
                    ->execute($this->User->id);

                $arrInterfacep = Contao\StringUtil::deserialize($objUser->interfacep);

                if (is_array($arrInterfacep) && in_array('create', $arrInterfacep))
                {
                    $arrInterfaces = Contao\StringUtil::deserialize($objUser->interfaces, true);
                    $arrInterfaces[] = $insertId;

                    $this->Database->prepare("UPDATE tl_user SET interfaces=? WHERE id=?")
                        ->execute(serialize($arrInterfaces), $this->User->id);
                }
            }

            // Add the new element to the user object
            $root[] = $insertId;
            $this->User->interfaces = $root;
        }
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
    public function editHeader(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->canEditFieldsOf('tl_interface') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the sync button
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
    public function syncInterface(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('sync', 'interfacep') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml( 'bundles/estatemanager/icons/sync_.svg').' ';
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
    public function copyInterface(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('create', 'interfacep') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function deleteInterface(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('delete', 'interfacep') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return all unique provider field options as array
     *
     * @param Contao\DataContainer  $dc
     *
     * @return array
     */
    public function getUniqueProviderFieldOptions(Contao\DataContainer $dc): array
    {
        $return = array();

        foreach ($GLOBALS['TL_DCA']['tl_provider']['fields'] as $field => $options)
        {
            if (array_key_exists('realEstate', $options) && array_key_exists('unique', $options['realEstate']))
            {
                $return[$field] = $GLOBALS['TL_LANG']['tl_provider'][$field][0];
            }
        }

        return $return;
    }

    /**
     * Return all unique field options as array
     *
     * @param Contao\DataContainer  $dc
     *
     * @return array
     */
    public function getUniqueFieldOptions(Contao\DataContainer $dc): array
    {
        $return = array();

        foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields'] as $field => $options)
        {
            if (array_key_exists('realEstate', $options) && array_key_exists('unique', $options['realEstate']))
            {
                $return[$field] = $GLOBALS['TL_LANG']['tl_real_estate'][$field][0];
            }
        }

        return $return;
    }

    /**
     * Return all unique field options as array
     *
     * @param Contao\DataContainer  $dc
     *
     * @return array
     */
    public function getContactPersonUniqueFieldOptions(Contao\DataContainer $dc): array
    {
        $return = array();

        foreach ($GLOBALS['TL_DCA']['tl_contact_person']['fields'] as $field => $options)
        {
            if (array_key_exists('realEstate', $options) && array_key_exists('unique', $options['realEstate']))
            {
                $return[$field] = $GLOBALS['TL_LANG']['tl_contact_person'][$field][0];
            }
        }

        $return['name_vorname'] = $GLOBALS['TL_LANG']['tl_contact_person']['name_vorname'];

        return $return;
    }

    /**
     * Return all contact person of assigned provider as array
     *
     * @param Contao\DataContainer  $dc
     *
     * @return array
     */
    public function getContactPerson(Contao\DataContainer $dc): array
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
     * @param Contao\DataContainer  $dc
     *
     * @return array
     */
    public function getSyncOptions(Contao\DataContainer $dc): array
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
     * @param Contao\DataContainer  $dc
     *
     * @return array
     */
    public function getDeleteFilesOlderThenOptions(Contao\DataContainer $dc): array
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
