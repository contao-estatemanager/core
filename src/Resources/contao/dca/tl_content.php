<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */


// Add palettes
array_insert($GLOBALS['TL_DCA']['tl_content']['palettes'], 0, array
(
    'realEstateFilter'   => '{type_legend},type,headline;{include_legend},filter;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop'
));

// Add fields
array_insert($GLOBALS['TL_DCA']['tl_content']['fields'], 0, array
(
    'filter' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['filter'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_content_estate_manager', 'getFilter'),
        'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50 wizard'),
        'wizard' => array
        (
            array('tl_content_estate_manager', 'editFilter')
        ),
        'sql'                     => "int(10) unsigned NOT NULL default '0'"
    ),
));

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class tl_content_estate_manager extends Backend
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
     * Return the edit filter wizard
     *
     * @param DataContainer $dc
     *
     * @return string
     */
    public function editFilter(DataContainer $dc)
    {
        return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=filter&amp;table=tl_filter_item&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_content']['editalias'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_content']['editalias'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_content']['editalias'][0]) . '</a>';
    }

    /**
     * Get all filter and return them as array
     *
     * @return array
     */
    public function getFilter()
    {
        if (!$this->User->isAdmin && !\is_array($this->User->filter))
        {
            return array();
        }

        $arrFilter = array();
        $objFilter = $this->Database->execute("SELECT id, title FROM tl_filter ORDER BY title");

        while ($objFilter->next())
        {
            if ($this->User->hasAccess($objFilter->id, 'filter'))
            {
                $arrFilter[$objFilter->id] = $objFilter->title . ' (ID ' . $objFilter->id . ')';
            }
        }

        return $arrFilter;
    }
}