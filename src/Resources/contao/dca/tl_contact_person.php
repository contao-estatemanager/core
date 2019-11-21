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
                'label'               => &$GLOBALS['TL_LANG']['tl_contact_person']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
                'button_callback'     => array('tl_contact_person', 'editContactPerson')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_contact_person']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_contact_person', 'copyContactPerson')
            ),
            'cut' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_contact_person']['cut'],
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.svg'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_contact_person']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_contact_person', 'deleteContactPerson')
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_contact_person']['toggle'],
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_contact_person\')"',
                'button_callback'     => array('tl_contact_person', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_contact_person']['show'],
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
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'unique' => true
            )
        ),
        'email_direkt' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_direkt'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''",
            'realEstate'                => array(
                'unique' => true
            )
        ),
        'email_privat' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_contact_person']['email_privat'],
            'exclude'                 => true,
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
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Config::get('validImageTypes')),
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
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>16, 'tl_class'=>'w50'),
            'sql'                     => "varchar(16) NOT NULL default ''",
            'realEstate'                => array(
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

use ContaoEstateManager\RealEstateModel;

class tl_contact_person extends Backend
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
     * Check permissions to edit table tl_contact_person
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Stringify contact person und return it as string
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function stringifyContactPerson($arrRow)
    {
        return '<div class="tl_content_left">' . $arrRow['name'] . ', ' . $arrRow['vorname'] . ' ' . ($arrRow['position'] ? '<span style="color:#999;padding-left:3px">(' . $arrRow['position'] . ')</span>' : '') . '</div>';
    }

    /**
     * Auto-generate the salutation of contact person if it has not been set yet
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function generateSalutation($varValue, DataContainer $dc)
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
    public function editContactPerson($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_contact_person') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function copyContactPerson($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('create', 'contactperson') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function deleteContactPerson($row, $href, $label, $title, $icon, $attributes)
    {
        $hasRealEstate = RealEstateModel::countByContactPerson($row['id']);
        return $this->User->hasAccess('delete', 'contactperson') && !$hasRealEstate ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (\strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
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

        return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
    }

    /**
     * Toggle the visibility of a contact person
     *
     * @param integer       $intId
     * @param boolean       $blnVisible
     * @param DataContainer $dc
     */
    public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        // Trigger the onload_callback
        if (\is_array($GLOBALS['TL_DCA']['tl_contact_person']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_contact_person']['config']['onload_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (\is_callable($callback))
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
        if (\is_array($GLOBALS['TL_DCA']['tl_contact_person']['config']['onsubmit_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_contact_person']['config']['onsubmit_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (\is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }
    }
}
