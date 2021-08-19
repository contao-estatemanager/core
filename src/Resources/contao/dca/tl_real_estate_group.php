<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */


$GLOBALS['TL_DCA']['tl_real_estate_group'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_real_estate_type'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'markAsCopy'                  => 'title',
        'onload_callback' => array
        (
            array('tl_real_estate_group', 'checkPermission')
        ),
        'oncreate_callback' => array
        (
            array('tl_real_estate_group', 'adjustPermissions')
        ),
        'oncopy_callback' => array
        (
            array('tl_real_estate_group', 'adjustPermissions')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'published' => 'index'
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
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate_group']['edit'],
                'href'                => 'table=tl_real_estate_type',
                'icon'                => 'edit.svg'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate_group']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.svg',
                'button_callback'     => array('tl_real_estate_group', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate_group']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_real_estate_group', 'copy')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate_group']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_real_estate_group', 'delete')
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate_group']['toggle'],
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_real_estate_group\')"',
                'button_callback'     => array('tl_real_estate_group', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_real_estate_group']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend},title,similarGroup,alias;{config_legend},referencePage,vermarktungsart;{publish_legend},published'
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_group']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'similarGroup' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_group']['similarGroup'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'foreignKey'              => 'tl_real_estate_group.title',
            'options_callback'        => array('tl_real_estate_group', 'getRealEstateGroups'),
            'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'referencePage' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_group']['referencePage'],
            'exclude'                 => true,
            'inputType'               => 'pageTree',
            'foreignKey'              => 'tl_page.title',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'vermarktungsart' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_group']['vermarktungsart'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'filter'                  => true,
            'options'                 => array('kauf_erbpacht', 'miete_leasing'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_group'],
            'eval'                    => array('includeBlankOption'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''",
        ),
        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_group']['published'],
            'exclude'                 => true,
            'filter'                  => true,
            'flag'                    => 1,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_real_estate_group extends Contao\Backend
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
     * Check permissions to edit table tl_real_estate_group
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
        if (empty($this->User->regroups) || !is_array($this->User->regroups))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->regroups;
        }

        if (Contao\Input::get('key') == 'syncRealEstates')
        {
            if (!in_array(Contao\Input::get('id'), $root) || !$this->User->hasAccess('sync', 'regroupp'))
            {
                throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to sync real estate group ID ' . Contao\Input::get('id') . '.');
            }
        }

        $GLOBALS['TL_DCA']['tl_real_estate_group']['list']['sorting']['root'] = $root;

        // Check permissions to add real estate group
        if (!$this->User->hasAccess('create', 'regroupp'))
        {
            $GLOBALS['TL_DCA']['tl_real_estate_group']['config']['closed'] = true;
            $GLOBALS['TL_DCA']['tl_real_estate_group']['config']['notCreatable'] = true;
            $GLOBALS['TL_DCA']['tl_real_estate_group']['config']['notCopyable'] = true;
        }

        // Check permissions to delete real estate groups
        if (!$this->User->hasAccess('delete', 'regroupp'))
        {
            $GLOBALS['TL_DCA']['tl_real_estate_group']['config']['notDeletable'] = true;
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
                if (!$this->User->hasAccess('create', 'regroupp'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to create real estate groups.');
                }
                break;

            case 'edit':
            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Contao\Input::get('id'), $root) || (Contao\Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'regroupp')))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' real estate group ID ' . Contao\Input::get('id') . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'copyAll':
                $session = $objSession->all();

                if (Contao\Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'regroupp'))
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
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' real estate groups.');
                }
                break;
        }
    }

    /**
     * Add the new real estate group to the permissions
     *
     * @param $insertId
     */
    public function adjustPermissions($insertId): void
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
        if (empty($this->User->regroups) || !is_array($this->User->regroups))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->regroups;
        }

        // The interface is enabled already
        if (in_array($insertId, $root))
        {
            return;
        }

        /** @var Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $objSessionBag */
        $objSessionBag = Contao\System::getContainer()->get('session')->getBag('contao_backend');

        $arrNew = $objSessionBag->get('new_records');

        if (is_array($arrNew['tl_real_estate_group'] ?? null) && in_array($insertId, $arrNew['tl_real_estate_group']))
        {
            // Add the permissions on group level
            if ($this->User->inherit != 'custom')
            {
                $objGroup = $this->Database->execute("SELECT id, regroups, regroupp FROM tl_user_group WHERE id IN(" . implode(',', array_map('\intval', $this->User->groups)) . ")");

                while ($objGroup->next())
                {
                    $arrReGroupp = Contao\StringUtil::deserialize($objGroup->regroupp);

                    if (is_array($arrReGroupp) && in_array('create', $arrReGroupp))
                    {
                        $arrReGroups = Contao\StringUtil::deserialize($objGroup->regroups, true);
                        $arrReGroups[] = $insertId;

                        $this->Database->prepare("UPDATE tl_user_group SET regroups=? WHERE id=?")
                            ->execute(serialize($arrReGroups), $objGroup->id);
                    }
                }
            }

            // Add the permissions on user level
            if ($this->User->inherit != 'group')
            {
                $objUser = $this->Database->prepare("SELECT regroups, regroupp FROM tl_user WHERE id=?")
                    ->limit(1)
                    ->execute($this->User->id);

                $arrReGroupp = Contao\StringUtil::deserialize($objUser->regroupp);

                if (is_array($arrReGroupp) && in_array('create', $arrReGroupp))
                {
                    $arrReGroups = Contao\StringUtil::deserialize($objUser->regroups, true);
                    $arrReGroups[] = $insertId;

                    $this->Database->prepare("UPDATE tl_user SET regroups=? WHERE id=?")
                        ->execute(serialize($arrReGroups), $this->User->id);
                }
            }

            // Add the new element to the user object
            $root[] = $insertId;
            $this->User->regroups = $root;
        }
    }

    /**
     * Auto-generate a real estate group alias if it has not been set yet
     *
     * @param string               $varValue
     * @param Contao\DataContainer $dc
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias(string $varValue, Contao\DataContainer $dc): string
    {
        $autoAlias = false;

        // Generate an alias if there is none
        if (!$varValue)
        {
            $autoAlias = true;
            $varValue = Contao\StringUtil::generateAlias($dc->activeRecord->title);
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_real_estate_group WHERE id=? OR alias=?")
            ->execute($dc->id, $varValue);

        // Check whether the page alias exists
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
        return $this->User->canEditFieldsOf('tl_real_estate_group') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function copy(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('create', 'regroupp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the delete group button
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
    public function delete(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('delete', 'regroupp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return all real estate groups as array
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getRealEstateGroups(Contao\DataContainer $dc): array
    {
        $objGroups = $this->Database->prepare("SELECT id, title FROM tl_real_estate_group WHERE id!=? AND vermarktungsart!=?")
            ->execute($dc->activeRecord->id, $dc->activeRecord->vermarktungsart);

        if ($objGroups->numRows < 1)
        {
            return array();
        }

        $arrGroups = array();

        while ($objGroups->next())
        {
            $arrGroups[$objGroups->id] = $objGroups->title;
        }

        return $arrGroups;
    }

    /**
     * Return the "toggle visibility" button
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
    public function toggleIcon(array $row, ?string $href, string $label, string $title, string $icon, string $attributes): string
    {
        if (strlen(Contao\Input::get('tid')))
        {
            $this->toggleVisibility(Contao\Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->hasAccess('tl_real_estate_group::published', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
    }

    /**
     * Toggle the visibility of a format definition
     *
     * @param integer              $intId
     * @param boolean              $blnVisible
     * @param Contao\DataContainer $dc
     */
    public function toggleVisibility(int $intId, bool $blnVisible, Contao\DataContainer $dc=null): void
    {
        // Set the ID and action
        Contao\Input::setGet('id', $intId);
        Contao\Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        // Trigger the onload_callback
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate_group']['config']['onload_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate_group']['config']['onload_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        // Check the field access
        if (!$this->User->hasAccess('tl_real_estate_group::published', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish real estate group ID ' . $intId . '.');
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_real_estate_group WHERE id=?")
                ->limit(1)
                ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $objVersions = new Contao\Versions('tl_real_estate_group', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate_group']['fields']['published']['save_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate_group']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $dc);
                }
            }
        }

        $time = time();

        // Update the database
        $this->Database->prepare("UPDATE tl_real_estate_group SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate_group']['config']['onsubmit_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate_group']['config']['onsubmit_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        $objVersions->create();
    }
}
