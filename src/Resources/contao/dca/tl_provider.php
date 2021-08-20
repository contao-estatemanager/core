<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

use ContaoEstateManager\ProviderModel;

$GLOBALS['TL_DCA']['tl_provider'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_contact_person'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'markAsCopy'                  => 'title',
        'onload_callback' => array
        (
            array('tl_provider', 'checkPermission')
        ),
        'oncreate_callback' => array
        (
            array('tl_provider', 'adjustPermissions')
        ),
        'oncopy_callback' => array
        (
            array('tl_provider', 'adjustPermissions')
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
            'mode'                    => 2,
            'fields'                  => array('anbieternr DESC'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;sort,search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('firma', 'anbieternr', 'postleitzahl', 'ort'),
            'showColumns'             => true
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
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
                'button_callback'     => array('tl_provider', 'editHeader')
            ),
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['edit'],
                'href'                => 'table=tl_contact_person',
                'icon'                => 'user.svg',
                'button_callback'     => array('tl_provider', 'editContactPerson')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_provider', 'copyProvider')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_provider', 'deleteProvider')
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['toggle'],
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_provider\')"',
                'button_callback'     => array('tl_provider', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_provider']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('useOwnSender'),
        'default'                     => '{general_legend},anbieternr,openimmo_anid,lizenzkennung;{config_legend},forwardingMode,useOwnSender;{address_legend},firma,postleitzahl,ort,strasse,hausnummer,bundesland,land,lat,lng,telefon,telefon2,fax,email,homepage;{address_text_legend:hide},firmenanschrift;{impressum_legend},vertretungsberechtigter,berufsaufsichtsbehoerde,handelsregister,handelsregister_nr,umsstid,steuernummer,weiteres;{impressum_text_legend:hide},impressum;{description_legend},beschreibung;{image_legend:hide},singleSRC;{published_legend},published'
    ),


    // Palettes
    'subpalettes' => array
    (
        'useOwnSender'                => 'senderEmail,senderName'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment",
            'sorting'                 => true
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'anbieternr' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['anbieternr'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
            'realEstate'              => array(
                'unique' => true
            )
        ),
        'openimmo_anid' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['openimmo_anid'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''",
            'realEstate'              => array(
                'unique' => true
            )
        ),
        'lizenzkennung' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['lizenzkennung'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>8, 'tl_class'=>'w50'),
            'sql'                     => "varchar(8) NOT NULL default ''"
        ),
        'singleSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['singleSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'tl_class'=>'w50'),
            'sql'                     => "binary(16) NULL"
        ),
        'forwardingMode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['forwardingMode'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'options'                 => array('contact', 'provider', 'both'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_provider'],
            'eval'                    => array('helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(8) NOT NULL default ''"
        ),
        'useOwnSender' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['useOwnSender'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default '0'",
        ),
        'senderEmail' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['senderEmail'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true,'rgxp'=>'email','maxlength'=>255,'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'senderName' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['senderName'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true,'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'firma' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['firma'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'postleitzahl' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['postleitzahl'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>8, 'tl_class'=>'w50'),
            'sql'                     => "varchar(8) NOT NULL default ''"
        ),
        'ort' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['ort'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'strasse' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['strasse'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'hausnummer' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['hausnummer'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>8, 'tl_class'=>'w50'),
            'sql'                     => "varchar(8) NOT NULL default ''"
        ),
        'bundesland' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['bundesland'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'land' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['land'],
            'exclude'                 => true,
            'filter'                  => true,
            'search'                  => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'lat' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['lat'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'lng' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['lng'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'telefon' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['telefon'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'telefon2' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['telefon2'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'fax' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['fax'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'email' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['email'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'homepage' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['homepage'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'firmenanschrift' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['firmenanschrift'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'vertretungsberechtigter' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['vertretungsberechtigter'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'berufsaufsichtsbehoerde' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['berufsaufsichtsbehoerde'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'handelsregister' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['handelsregister'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'handelsregister_nr' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['handelsregister_nr'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'umsstid' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['umsstid'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'steuernummer' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['steuernummer'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'weiteres' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['weiteres'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'impressum' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['impressum'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'beschreibung' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['beschreibung'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_provider']['published'],
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
class tl_provider extends Contao\Backend
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
     * Check permissions to edit table tl_provider
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
        if (empty($this->User->providers) || !is_array($this->User->providers))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->providers;
        }

        $GLOBALS['TL_DCA']['tl_provider']['list']['sorting']['root'] = $root;

        // Check permissions to add provider
        if (!$this->User->hasAccess('create', 'providerp'))
        {
            $GLOBALS['TL_DCA']['tl_provider']['config']['closed'] = true;
            $GLOBALS['TL_DCA']['tl_provider']['config']['notCreatable'] = true;
            $GLOBALS['TL_DCA']['tl_provider']['config']['notCopyable'] = true;
        }

        // Check permissions to delete providers
        if (!$this->User->hasAccess('delete', 'providerp'))
        {
            $GLOBALS['TL_DCA']['tl_provider']['config']['notDeletable'] = true;
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
                if (!$this->User->hasAccess('create', 'providerp'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to create provider.');
                }
                break;

            case 'edit':
            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Contao\Input::get('id'), $root) || (Contao\Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'providerp')))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' provider ID ' . Contao\Input::get('id') . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'copyAll':
                $session = $objSession->all();

                if (Contao\Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'providerp'))
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
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' provider.');
                }
                break;
        }
    }

    /**
     * Add the new provider to the permissions
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
        if (empty($this->User->providers) || !is_array($this->User->providers))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->providers;
        }

        // The provider is enabled already
        if (in_array($insertId, $root))
        {
            return;
        }

        /** @var Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $objSessionBag */
        $objSessionBag = Contao\System::getContainer()->get('session')->getBag('contao_backend');

        $arrNew = $objSessionBag->get('new_records');

        if (is_array($arrNew['tl_provider']) && in_array($insertId, $arrNew['tl_provider']))
        {
            // Add the permissions on group level
            if ($this->User->inherit != 'custom')
            {
                $objGroup = $this->Database->execute("SELECT id, providers, providerp FROM tl_user_group WHERE id IN(" . implode(',', array_map('\intval', $this->User->groups)) . ")");

                while ($objGroup->next())
                {
                    $arrProviderp = Contao\StringUtil::deserialize($objGroup->providerp);

                    if (is_array($arrProviderp) && in_array('create', $arrProviderp))
                    {
                        $arrProviders = Contao\StringUtil::deserialize($objGroup->providers, true);
                        $arrProviders[] = $insertId;

                        $this->Database->prepare("UPDATE tl_user_group SET providers=? WHERE id=?")
                            ->execute(serialize($arrProviders), $objGroup->id);
                    }
                }
            }

            // Add the permissions on user level
            if ($this->User->inherit != 'group')
            {
                $objUser = $this->Database->prepare("SELECT providers, providerp FROM tl_user WHERE id=?")
                    ->limit(1)
                    ->execute($this->User->id);

                $arrProviderp = Contao\StringUtil::deserialize($objUser->providerp);

                if (is_array($arrProviderp) && in_array('create', $arrProviderp))
                {
                    $arrProviders = Contao\StringUtil::deserialize($objUser->providers, true);
                    $arrProviders[] = $insertId;

                    $this->Database->prepare("UPDATE tl_user SET providers=? WHERE id=?")
                        ->execute(serialize($arrProviders), $this->User->id);
                }
            }

            // Add the new element to the user object
            $root[] = $insertId;
            $this->User->providers = $root;
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
        return $this->User->canEditFieldsOf('tl_provider') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the edit contact person button
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
    public function editContactPerson(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->canEditFieldsOf('tl_contact_person') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the copy provider button
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
    public function copyProvider(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('create', 'providerp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the delete provider button
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
    public function deleteProvider(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('delete', 'providerp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
            $this->toggleVisibility(Contao\Input::get('tid'), (Contao\Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->hasAccess('tl_provider::published', 'alexf'))
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
     * Toggle the visibility of a provider
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
        if (is_array($GLOBALS['TL_DCA']['tl_provider']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_provider']['config']['onload_callback'] as $callback)
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
        if (!$this->User->hasAccess('tl_provider::published', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish provider ID ' . $intId . '.');
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_provider WHERE id=?")
                ->limit(1)
                ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $time = time();

        // Update the database
        $this->Database->prepare("UPDATE tl_provider SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_provider']['config']['onsubmit_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_provider']['config']['onsubmit_callback'] as $callback)
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
    }
}
