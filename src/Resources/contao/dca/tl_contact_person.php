<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_contact_person'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_provider',
        'doNotCopyRecords'            => true,
        'onload_callback' => array
        (
            array('tl_contact_person', 'checkPermission')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid,published' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('name DESC'),
            'headerFields'            => array('anbieternr', 'firma', 'openimmo_anid'),
            'panelLayout'             => 'filter;sort,search,limit',
            'child_record_callback'   => array('tl_contact_person', 'stringifyContactPerson'),
            'child_record_class'      => 'no_padding'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
                'button_callback'     => array('tl_contact_person', 'editContactPerson')
            ),
            'copy' => array
            (
                'href'                => 'act=copy',
                'icon'                => 'copy.svg'
            ),
            'cut' => array
            (
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.svg'
            ),
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_contact_person', 'deleteContactPerson')
            ),
            'toggle' => array
            (
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_contact_person\')"',
                'button_callback'     => array('tl_contact_person', 'toggleIcon')
            ),
            'show' => array
            (
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend},anrede,firma,vorname,name,titel,position,anrede_brief,email_zentrale,email_direkt,email_privat,email_sonstige,email_feedback,tel_zentrale,tel_durchw,tel_fax,tel_handy,tel_privat,tel_sonstige;{location_legend},strasse,hausnummer,plz,ort,land,zusatzfeld,freitextfeld,adressfreigabe;{image_legend},singleSRC;{extended_legend},postfach,postfach_plz,postfach_ort,personennummer,immobilientreuhaenderid;{published_legend},published'
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
            'foreignKey'              => 'tl_provider.id',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'anrede' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['anrede'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('herr','frau'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_contact_person'],
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(4) NOT NULL default ''"
        ),
        'firma' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['firma'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'vorname' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['vorname'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['name'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'titel' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['titel'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'position' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['position'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'anrede_brief' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['anrede_brief'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
            'save_callback' => array
            (
                array('tl_contact_person', 'generateSalutation')
            ),
        ),
        'email_zentrale' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_zentrale'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''",
            'realEstate'              => array(
                'unique' => true
            )
        ),
        'email_direkt' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_direkt'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''",
            'realEstate'              => array(
                'unique' => true
            )
        ),
        'email_privat' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_privat'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'email_sonstige' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_sonstige'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'email_feedback' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_feedback'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'tel_zentrale' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['tel_zentrale'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'tel_durchw' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['tel_durchw'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'tel_fax' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['tel_fax'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'tel_handy' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['tel_handy'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'tel_privat' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['tel_privat'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'tel_sonstige' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['tel_sonstige'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'strasse' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['strasse'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'hausnummer' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['hausnummer'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>16, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''"
        ),
        'plz' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['plz'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>16, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''"
        ),
        'ort' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['ort'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'land' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['land'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'zusatzfeld' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['zusatzfeld'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'freitextfeld' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['freitextfeld'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true, 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'adressfreigabe' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['adressfreigabe'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'singleSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['singleSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes')),
            'sql'                     => "binary(16) NULL"
        ),
        'postfach' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['postfach'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'postfach_plz' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['postfach_plz'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'postfach_ort' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['postfach_ort'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'personennummer' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['personennummer'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>16, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''",
            'realEstate'              => array(
                'unique' => true
            )
        ),
        'immobilientreuhaenderid' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['immobilientreuhaenderid'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>16, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''"
        ),
        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['published'],
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
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class tl_contact_person extends Contao\Backend
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
     * Check permissions to edit table tl_contact_person
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

        $id = strlen(Contao\Input::get('id')) ? Contao\Input::get('id') : CURRENT_ID;

        // Check current action
        switch (Contao\Input::get('act'))
        {
            case 'paste':
            case 'select':
                // Check CURRENT_ID here (see #247)
                if (!in_array(CURRENT_ID, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access provider ID ' . $id . '.');
                }
                break;

            case 'create':
                if (!Contao\Input::get('pid') || !in_array(Contao\Input::get('pid'), $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to create events in provider ID ' . Contao\Input::get('pid') . '.');
                }
                break;

            case 'cut':
            case 'copy':
                if (!in_array(Contao\Input::get('pid'), $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' contact person ID ' . $id . ' to provider ID ' . Contao\Input::get('pid') . '.');
                }
            // no break

            case 'edit':
            case 'show':
            case 'delete':
            case 'toggle':
                $objContactPerson = $this->Database->prepare("SELECT pid FROM tl_contact_person WHERE id=?")
                    ->limit(1)
                    ->execute($id);

                if ($objContactPerson->numRows < 1)
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid contact person ID ' . $id . '.');
                }

                if (!in_array($objContactPerson->pid, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' contact person ID ' . $id . ' of provider ID ' . $objContactPerson->pid . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'cutAll':
            case 'copyAll':
                if (!in_array($id, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access provider ID ' . $id . '.');
                }

                $objContactPerson = $this->Database->prepare("SELECT id FROM tl_contact_person WHERE pid=?")
                    ->execute($id);

                /** @var Symfony\Component\HttpFoundation\Session\SessionInterface $objSession */
                $objSession = Contao\System::getContainer()->get('session');

                $session = $objSession->all();
                $session['CURRENT']['IDS'] = array_intersect((array) $session['CURRENT']['IDS'], $objContactPerson->fetchEach('id'));
                $objSession->replace($session);
                break;

            default:
                if (Contao\Input::get('act'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid command "' . Contao\Input::get('act') . '".');
                }

                if (!in_array($id, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access provider ID ' . $id . '.');
                }
                break;
        }
    }

    /**
     * Stringify contact person und return it as string
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function stringifyContactPerson(array $arrRow): string
    {
        return '<div class="tl_content_left">' . $arrRow['name'] . ', ' . $arrRow['vorname'] . ' ' . ($arrRow['position'] ? '<span style="color:#999;padding-left:3px">(' . $arrRow['position'] . ')</span>' : '') . '</div>';
    }

    /**
     * Auto-generate the salutation of contact person if it has not been set yet
     *
     * @param string               $varValue
     * @param Contao\DataContainer $dc
     *
     * @return string
     */
    public function generateSalutation(string $varValue, Contao\DataContainer $dc): string
    {
        // Generate salutation if there is none
        if ($varValue == '')
        {
            if($dc->activeRecord->anrede == 'herr'){
                $salutation = &$GLOBALS['TL_LANG']['tl_contact_person']['salutationMr'][0];
            }else{
                $salutation = &$GLOBALS['TL_LANG']['tl_contact_person']['salutationMrs'][0];
            }

            $varValue = $salutation . ' ' . $GLOBALS['TL_LANG']['tl_contact_person'][$dc->activeRecord->anrede][0] . ' ' . ($dc->activeRecord->titel ? $dc->activeRecord->titel . ' ' : '') . $dc->activeRecord->vorname . ' ' . $dc->activeRecord->name;
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
    public function editContactPerson(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->canEditFieldsOf('tl_contact_person') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the copy contact person button
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
    public function copyContactPerson(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('create', 'contactperson') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }

    /**
     * Return the delete contact person button
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
    public function deleteContactPerson(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        $hasRealEstate = ContaoEstateManager\RealEstateModel::countByContactPerson($row['id']);
        return !$hasRealEstate ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
        if (!$this->User->hasAccess('tl_contact_person::published', 'alexf'))
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
     * Toggle the visibility of a contact person
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
        if (is_array($GLOBALS['TL_DCA']['tl_contact_person']['config']['onload_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_contact_person']['config']['onload_callback'] as $callback)
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
        if (!$this->User->hasAccess('tl_contact_person::published', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish contact person ID ' . $intId . '.');
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_contact_person WHERE id=?")
                ->limit(1)
                ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $time = time();

        // Update the database
        $this->Database->prepare("UPDATE tl_contact_person SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_contact_person']['config']['onsubmit_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_contact_person']['config']['onsubmit_callback'] as $callback)
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
