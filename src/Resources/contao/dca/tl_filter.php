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
            'fields'                  => array('title')
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
                'href'                => 'table=tl_filter_item',
                'icon'                => 'edit.svg'
            ),
            'editheader' => array
            (
                'href'                => 'act=edit',
                'icon'                => 'header.svg',
                'button_callback'     => array('tl_filter', 'editHeader')
            ),
            'copy' => array
            (
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array('tl_filter', 'copyFilter')
            ),
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_filter', 'deleteFilter')
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
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'alias' => array
        (
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
            'exclude'                 => true,
            'inputType'               => 'pageTree',
            'foreignKey'              => 'tl_page.title',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'groups' => array
        (
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
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'addBlankRealEstateType' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'submitOnChange' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'toggleFilter'  => array
        (
            'exclude'                 => true,
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
            'default'                 => '1,2,3,4,5,6,7,8',
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''",
        ),
        'customTpl' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_filter', 'getFilterWrapperTemplates'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'attributes' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'novalidate' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'toggleMode' => array
        (
            'sql'                     => "varchar(32) NOT NULL default 'typeSeparated'"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_filter extends Contao\Backend
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
     * Check permissions to edit table tl_filter
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
        if (empty($this->User->filters) || !is_array($this->User->filters))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->filters;
        }

        $GLOBALS['TL_DCA']['tl_filter']['list']['sorting']['root'] = $root;

        // Check permissions to add filter
        if (!$this->User->hasAccess('create', 'filterp'))
        {
            $GLOBALS['TL_DCA']['tl_filter']['config']['closed'] = true;
            $GLOBALS['TL_DCA']['tl_filter']['config']['notCreatable'] = true;
            $GLOBALS['TL_DCA']['tl_filter']['config']['notCopyable'] = true;
        }

        // Check permissions to delete filter
        if (!$this->User->hasAccess('delete', 'filterp'))
        {
            $GLOBALS['TL_DCA']['tl_filter']['config']['notDeletable'] = true;
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
                if (!$this->User->hasAccess('create', 'filterp'))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to create filter.');
                }
                break;

            case 'edit':
            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Contao\Input::get('id'), $root) || (Contao\Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'filterp')))
                {
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' form ID ' . Contao\Input::get('id') . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'copyAll':
                $session = $objSession->all();

                if (Contao\Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'filterp'))
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
                    throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Contao\Input::get('act') . ' filter.');
                }
                break;
        }
    }

    /**
     * Add the new filter to the permissions
     *
     * @param integer $insertId
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
        if (empty($this->User->filters) || !is_array($this->User->filters))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->filters;
        }

        // The form is enabled already
        if (in_array($insertId, $root))
        {
            return;
        }

        /** @var Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $objSessionBag */
        $objSessionBag = Contao\System::getContainer()->get('session')->getBag('contao_backend');

        $arrNew = $objSessionBag->get('new_records');

        if (is_array($arrNew['tl_filter']) && in_array($insertId, $arrNew['tl_filter']))
        {
            // Add the permissions on group level
            if ($this->User->inherit != 'custom')
            {
                $objGroup = $this->Database->execute("SELECT id, filters, filterp FROM tl_user_group WHERE id IN(" . implode(',', array_map('\intval', $this->User->groups)) . ")");

                while ($objGroup->next())
                {
                    $arrFilterp = Contao\StringUtil::deserialize($objGroup->filterp);

                    if (is_array($arrFilterp) && in_array('create', $arrFilterp))
                    {
                        $arrFilters = Contao\StringUtil::deserialize($objGroup->filters, true);
                        $arrFilters[] = $insertId;

                        $this->Database->prepare("UPDATE tl_user_group SET filters=? WHERE id=?")
                            ->execute(serialize($arrFilters), $objGroup->id);
                    }
                }
            }

            // Add the permissions on user level
            if ($this->User->inherit != 'group')
            {
                $objUser = $this->Database->prepare("SELECT filters, filterp FROM tl_user WHERE id=?")
                    ->limit(1)
                    ->execute($this->User->id);

                $arrFilterp = Contao\StringUtil::deserialize($objUser->filterp);

                if (is_array($arrFilterp) && in_array('create', $arrFilterp))
                {
                    $arrFilters = Contao\StringUtil::deserialize($objUser->filters, true);
                    $arrFilters[] = $insertId;

                    $this->Database->prepare("UPDATE tl_user SET filters=? WHERE id=?")
                        ->execute(serialize($arrFilters), $this->User->id);
                }
            }

            // Add the new element to the user object
            $root[] = $insertId;
            $this->User->filters = $root;
        }
    }

    /**
     * Auto-generate a filter alias if it has not been set yet
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

        // Generate alias if there is none
        if (!$varValue)
        {
            $autoAlias = true;

            $varValue = Contao\System::getContainer()->get('contao.slug.generator')->generate(Contao\StringUtil::stripInsertTags($dc->activeRecord->title));
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
    public function getRealEstateGroups(): array
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
    public function getFilterWrapperTemplates(): array
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
    public function editHeader(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->canEditFieldsOf('tl_filter') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function copyFilter(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('create', 'filterp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
    public function deleteFilter(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        return $this->User->hasAccess('delete', 'filterp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.Contao\StringUtil::specialchars($title).'"'.$attributes.'>'.Contao\Image::getHtml($icon, $label).'</a> ' : Contao\Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
    }
}
