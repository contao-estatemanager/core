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
                'label'               => &$GLOBALS['TL_LANG']['tl_filter_item']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter_item']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.svg'
            ),
            'cut' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter_item']['cut'],
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.svg'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter_item']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter_item']['toggle'],
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s,\'tl_filter_item\')"',
                'button_callback'     => array('tl_filter_item', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_filter_item']['show'],
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
        'type'                  => '{type_legend},type,label;{field_config_legend},mandatory,showLongTitle,mergeOptions;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible',
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['type'],
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['label'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['name'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'fieldname', 'spaceToUnderscore'=>true, 'maxlength'=>64, 'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'mandatory' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['mandatory'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'countrySource' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['countrySource'],
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['countryOptions'],
            'inputType' 	          => 'multiColumnWizard',
            'eval' 			          => array
            (
                'columnFields' => array
                (
                    'country' => array
                    (
                        'label'             => &$GLOBALS['TL_LANG']['tl_filter_item']['countryOptions'],
                        'exclude'           => true,
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['placeholder'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'showLongTitle' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['showLongTitle'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'impreciseMode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['impreciseMode'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'mergeOptions' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['mergeOptions'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'rangeMode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['rangeMode'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'showLabel' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['showLabel'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'showPlaceholder' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['showPlaceholder'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'class' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['class'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'accesskey' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['accesskey'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'alnum', 'maxlength'=>1, 'tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'tabindex' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['tabindex'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
        ),
        'customTpl' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['customTpl'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_filter_item', 'getFilterItemTemplates'),
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'slabel' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['slabel'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'imageSubmit' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['imageSubmit'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'singleSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['singleSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'mandatory'=>true, 'tl_class'=>'clr'),
            'sql'                     => "binary(16) NULL"
        ),
        'invisible' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_filter_item']['invisible'],
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
        return;
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
    public function getFilterItems()
    {
        return array_keys($GLOBALS['TL_RFI']);

        $arrItems = $GLOBALS['TL_RFI'];

        // Add the translation
        foreach (array_keys($arrItems) as $key)
        {
            $arrItems[$key] = $key;
        }

        return $arrItems;
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
        if (is_array($GLOBALS['TL_DCA']['tl_filter_item']['config']['onload_callback']))
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
        if (is_array($GLOBALS['TL_DCA']['tl_filter_item']['fields']['invisible']['save_callback']))
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
        if (is_array($GLOBALS['TL_DCA']['tl_filter_item']['config']['onsubmit_callback']))
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
