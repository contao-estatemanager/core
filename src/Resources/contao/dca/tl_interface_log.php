<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_DCA']['tl_interface_log'] = array
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
				'id'  => 'primary',
                'pid' => 'index'
			)
		)
	),

	// List
	'list'  => array
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
			'label_callback'          => array('tl_interface_log', 'colorize')
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
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_interface_log']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_interface_log']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
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
            'foreignKey'              => 'tl_interface.id',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['tstamp'],
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 6,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'level' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['level'],
			'filter'                  => true,
			'sorting'                 => true,
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		'source' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['source'],
			'filter'                  => true,
			'sorting'                 => true,
			'reference'               => &$GLOBALS['TL_LANG']['tl_interface_log'],
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'action' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['action'],
			'filter'                  => true,
			'sorting'                 => true,
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'username' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['username'],
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['text'],
			'search'                  => true,
			'sql'                     => "text NULL"
		),
		'data' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_interface_log']['data'],
			'search'                  => true,
			'sql'                     => "text NULL"
		)
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_interface_log extends Backend
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
		switch (strtolower($row['action']))
		{
			case 'info':
				$label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_blue">$2</span>', $label);
				break;

			case 'highlight':
				$label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_orange">$2</span>', $label);
				break;

			case 'success':
				$label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_green">$2</span>', $label);
				break;

			case 'error':
				$label = preg_replace('@^(.*</span> )(.*)$@U', '$1 <span class="tl_red">$2</span>', $label);
				break;

			default:
				if (isset($GLOBALS['TL_HOOKS']['colorizeLogEntries']) && \is_array($GLOBALS['TL_HOOKS']['colorizeLogEntries']))
				{
					foreach ($GLOBALS['TL_HOOKS']['colorizeLogEntries'] as $callback)
					{
						$this->import($callback[0]);
						$label = $this->{$callback[0]}->{$callback[1]}($row, $label);
					}
				}
				break;
		}

		return '<div class="ellipsis log_level_' . $row['level'] . '">' . $label . '</div>';
	}
}
