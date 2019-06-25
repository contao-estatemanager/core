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
        'dataContainer'             => 'Table',
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
            'fields'                  => array('id'),
            'flag'                    => 1
        ),
        'label' => array
        (
            'fields'                  => array('id'),
            'format'                  => '%s'
        ),
        'operations' => array
        (
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_interface_history']['show'],
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
        'file' => array
        (
            'sql'                     => "varchar(1024) NOT NULL default ''"
        ),
        'synctime' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'filetime' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'user' => array
        (
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'status' => array
        (
            'sql'                     => "int(1) NOT NULL default '0'"
        ),
    )
);
