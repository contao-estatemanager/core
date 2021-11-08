<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_interface_history'] = array
(
// Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_interface',
        'closed'                      => true,
        'notEditable'                 => true,
        'notCopyable'                 => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 2,
            'fields'                  => array('tstamp DESC', 'id DESC'),
            'panelLayout'             => 'filter;sort,search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('tstamp', 'text'),
            'format'                  => '<span style="color:#999;padding-right:3px">[%s]</span> %s',
            'label_callback'          => array('tl_interface_history', 'colorize')
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
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            ),
        )
    ),

    // Fields
    'fields' => array
    (
        'id'     => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
        ),
        'tstamp' => array
        (
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 6,
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'source' => array
        (
            'filter'                  => true,
            'sorting'                 => true,
            'reference'               => &$GLOBALS['TL_LANG']['tl_interface_history'],
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'action' => array
        (
            'filter'                  => true,
            'sorting'                 => true,
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'username' => array
        (
            'search'                  => true,
            'filter'                  => true,
            'sorting'                 => true,
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'text' => array
        (
            'search'                  => true,
            'sql'                     => "text NULL"
        ),
        'status' => array
        (
            'search'                  => true,
            'filter'                  => true,
            'sql'                     => "int(1) NOT NULL default '0'"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_interface_history extends Contao\Backend
{

    /**
     * Colorize the log entries depending on their category
     *
     * @param array  $row
     * @param string $label
     *
     * @return string
     */
    public function colorize($row, $label)
    {
        switch ($row['action'])
        {
            case 'CONFIGURATION':
            case 'REPOSITORY':
                $label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_blue">$2</span>', $label);
                break;

            case 'CRON':
                $label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_green">$2</span>', $label);
                break;

            case 'ERROR':
                $label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_red">$2</span>', $label);
                break;

            default:
                if (isset($GLOBALS['TL_HOOKS']['colorizeLogEntries']) && is_array($GLOBALS['TL_HOOKS']['colorizeLogEntries']))
                {
                    foreach ($GLOBALS['TL_HOOKS']['colorizeLogEntries'] as $callback)
                    {
                        $this->import($callback[0]);
                        $label = $this->{$callback[0]}->{$callback[1]}($row, $label);
                    }
                }
                break;
        }

        return '<div class="ellipsis">' . $label . '</div>';
    }
}
