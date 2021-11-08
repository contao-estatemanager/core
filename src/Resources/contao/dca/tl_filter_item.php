<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_filter_item'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_filter',
        'enableVersioning'            => true,
        'markAsCopy'                  => 'label',
        'onload_callback' => array
        (
            array('tl_filter_item', 'checkPermission')
        ),
        'onsubmit_callback' => array
        (
            array('tl_filter_item', 'setFilterToggleMode')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid,invisible' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('sorting'),
            'panelLayout'             => 'filter,search,limit',
            'headerFields'            => array('title', 'tstamp'),
            'child_record_callback'   => array('tl_filter_item', 'listFilterItems')
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
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'href'                => 'act=paste&amp;mode=copy',
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
            ),
            'toggle' => array
            (
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_filter_item\')"',
                'button_callback'     => array('tl_filter_item', 'toggleIcon')
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
        '__selector__'          => array('type', 'countrySource', 'imageSubmit'),
        'default'               => '{type_legend},type',
        'country'               => '{type_legend},type,label;{field_config_legend},mandatory,placeholder;{country_options_legend},countrySource;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'location'              => '{type_legend},type,label;{field_config_legend},mandatory,placeholder;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'unique'                => '{type_legend},type,label;{field_config_legend},mandatory,placeholder,impreciseMode;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'type'                  => '{type_legend},type,label;{field_config_legend},mandatory,showLongTitle,mergeOptions,showPlaceholder;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'typeSeparated'         => '{type_legend},type;{field_config_legend},mandatory,showLongTitle,showLabel,showPlaceholder;{expert_legend:hide},class,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'toggle'                => '{type_legend},type;{field_config_legend},showLabel,showPlaceholder,rangeMode;{expert_legend:hide},class,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'reset'                 => '{type_legend},type,slabel;{image_legend:hide},imageSubmit;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
        'submit'                => '{type_legend},type,slabel;{image_legend:hide},imageSubmit;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'imageSubmit'                 => 'singleSRC',
        'countrySource_selection'     => 'countryOptions'
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
            'foreignKey'              => 'tl_filter.title',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'sorting' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'type' => array
        (
            'default'                 => 'type',
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_filter_item', 'getFilterItems'),
            'eval'                    => array('helpwizard'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
            'reference'               => &$GLOBALS['TL_LANG']['RFI'],
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'label' => array
        (
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'name' => array
        (
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'fieldname', 'spaceToUnderscore'=>true, 'maxlength'=>64, 'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'mandatory' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'countrySource' => array
        (
            'default'                 => 'pool',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('pool', 'selection'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_filter_item'],
            'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'countryOptions'  => array
        (
            'inputType' 	          => 'multiColumnWizard',
            'eval' 			          => array
            (
                'columnFields' => array
                (
                    'country' => array
                    (
                        'label'             => &$GLOBALS['TL_LANG']['tl_filter_item']['countryOptions'],
                        'inputType'         => 'select',
                        'options_callback'  => array('tl_filter_item', 'getRealEstateCountries'),
                        'eval' 		        => array('style'=>'width:100%', 'chosen'=>true)
                    )
                )
            ),
            'sql'                     => "blob NULL"
        ),
        'placeholder' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'search'                  => true,
            'eval'                    => array('decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'showLongTitle' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'impreciseMode' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'mergeOptions' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'rangeMode' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'showLabel' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'showPlaceholder' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'class' => array
        (
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'accesskey' => array
        (
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'alnum', 'maxlength'=>1, 'tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'tabindex' => array
        (
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
        ),
        'customTpl' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_filter_item', 'getFilterItemTemplates'),
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'slabel' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'imageSubmit' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'singleSRC' => array
        (
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'mandatory'=>true, 'tl_class'=>'clr'),
            'sql'                     => "binary(16) NULL"
        ),
        'invisible' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'sql'                     => "char(1) NOT NULL default ''"
        )
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_filter_item extends Contao\Backend
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
     * Check permissions to edit table tl_filter_item
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission(): void
    {
        if ($this->User->isAdmin)
        {
            return;
        }

        /** @var Symfony\Component\HttpFoundation\Session\SessionInterface $objSession */
        $objSession = Contao\System::getContainer()->get('session');

        // Set root IDs
        if (empty($this->User->filters) || !is_array($this->User->filters))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->filters;
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
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access filter ID ' . $id . '.');
                }
                break;

            case 'create':
            case 'cut':
            case 'copy':
                $pid = Contao\Input::get('pid');

                // Get filter ID
                if (Contao\Input::get('mode') == 1)
                {
                    $objField = $this->Database->prepare("SELECT pid FROM tl_filter_item WHERE id=?")
                        ->limit(1)
                        ->execute(Contao\Input::get('pid'));

                    if ($objField->numRows < 1)
                    {
                        throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid filter field ID ' . Contao\Input::get('pid') . '.');
                    }

                    $pid = $objField->pid;
                }

                if (!in_array($pid, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' filter field ID ' . $id . ' to filter ID ' . $pid . '.');
                }

                if (Contao\Input::get('act') == 'create')
                {
                    break;
                }
            // no break

            case 'edit':
            case 'show':
            case 'delete':
            case 'toggle':
                $objField = $this->Database->prepare("SELECT pid FROM tl_filter_item WHERE id=?")
                    ->limit(1)
                    ->execute($id);

                if ($objField->numRows < 1)
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid filter field ID ' . $id . '.');
                }

                if (!in_array($objField->pid, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' filter field ID ' . $id . ' of filter ID ' . $objField->pid . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'cutAll':
            case 'copyAll':
                if (!in_array($id, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access filter ID ' . $id . '.');
                }

                $objForm = $this->Database->prepare("SELECT id FROM tl_filter_item WHERE pid=?")
                    ->execute($id);

                $session = $objSession->all();
                $session['CURRENT']['IDS'] = array_intersect((array) $session['CURRENT']['IDS'], $objForm->fetchEach('id'));
                $objSession->replace($session);
                break;

            default:
                if (Contao\Input::get('act'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid command "' . Contao\Input::get('act') . '".');
                }

                if (!in_array($id, $root))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access filter ID ' . $id . '.');
                }
                break;
        }
    }

    /**
     * Set toggle mode field in type and typeSeparated filter items
     *
     * @param Contao\DataContainer $dc
     */
    public function setFilterToggleMode(Contao\DataContainer $dc): void
    {
        if ($dc->activeRecord->type === 'typeSeparated' || $dc->activeRecord->type === 'type')
        {
            $this->Database->prepare("UPDATE tl_filter SET toggleMode=? WHERE id=?")
                ->execute($dc->activeRecord->type, $dc->activeRecord->pid);
        }
    }

    /**
     * Add the type of filter item
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function listFilterItems(array $arrRow): string
    {
        $arrRow['required'] = $arrRow['mandatory'];
        $key = $arrRow['invisible'] ? 'unpublished' : 'published';

        $strType = '
<div class="cte_type ' . $key . '">' . $GLOBALS['TL_LANG']['RFI'][$arrRow['type']][0] . ($arrRow['name'] ? ' (' . $arrRow['name'] . ')' : '') . '</div>
<div class="limit_height' . (!Contao\Config::get('doNotCollapse') ? ' h32' : '') . '">';

        $strClass = $GLOBALS['TL_RFI'][$arrRow['type']];

        if (!class_exists($strClass))
        {
            return '';
        }

        /** @var Widget $objWidget */
        $objWidget = new $strClass($arrRow);

        $strWidget = $objWidget->parse();
        $strWidget = preg_replace('/ name="[^"]+"/i', '', $strWidget);
        $strWidget = str_replace(array(' type="submit"', ' autofocus', ' required'), array(' type="button"', '', ''), $strWidget);

        return $strType . Contao\StringUtil::insertTagToSrc($strWidget) . '
</div>' . "\n";
    }

    /**
     * Return a list of filter items
     *
     * @return array
     */
    public function getFilterItems(): array
    {
        return array_keys($GLOBALS['TL_RFI']);
    }

    /**
     * Return all real estate countries as array
     *
     * @return array
     */
    public function getRealEstateCountries(): array
    {
        Contao\System::loadLanguageFile('tl_real_estate_countries');

        return $GLOBALS['TL_LANG']['tl_real_estate_countries'];
    }

    /**
     * Return all filter item templates as array
     *
     * @return array
     */
    public function getFilterItemTemplates(): array
    {
        return $this->getTemplateGroup('filter_');
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
        if (!$this->User->hasAccess('tl_filter_item::invisible', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.$row['invisible'];

        if ($row['invisible'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label, 'data-state="' . ($row['invisible'] ? 1 : 0) . '"').'</a> ';
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
        if (is_array($GLOBALS['TL_DCA']['tl_filter_item']['config']['onload_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_filter_item']['config']['onload_callback'] as $callback)
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
        if (!$this->User->hasAccess('tl_filter_item::invisible', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish filter item ID ' . $intId . '.');
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_filter_item WHERE id=?")
                ->limit(1)
                ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $objVersions = new Contao\Versions('tl_filter_item', $intId);
        $objVersions->initialize();

        // Reverse the logic (form fields have invisible=1)
        $blnVisible = !$blnVisible;

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_filter_item']['fields']['invisible']['save_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_filter_item']['fields']['invisible']['save_callback'] as $callback)
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
        $this->Database->prepare("UPDATE tl_filter_item SET tstamp=$time, invisible='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->invisible = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_filter_item']['config']['onsubmit_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_filter_item']['config']['onsubmit_callback'] as $callback)
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
