<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// Add palette selectors
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'setMarketingType';
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'setRealEstateType';

// Extend the regular palette
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('estate_manager_legend', 'publish_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE, true)
    ->addField(array('location', 'setMarketingType', 'setRealEstateType'), 'estate_manager_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('regular', 'tl_page')
;

// Extend the root palette
$objPaletteManipulator = Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('estate_manager_legend', 'publish_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE, true)
    ->addField(array('realEstateQueryLanguage', 'realEstateQueryCountry'), 'estate_manager_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
;
if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'])) {
    $objPaletteManipulator->applyToPalette('rootfallback', 'tl_page');
}

// Add subpalettes
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['setMarketingType']  = 'marketingType';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['setRealEstateType'] = 'realEstateType';

// Add fields
$GLOBALS['TL_DCA']['tl_page']['fields']['location'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['location'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('tl_page_estate_manager' ,'getLocations'),
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['setMarketingType'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['setMarketingType'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['marketingType'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['marketingType'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('kauf_erbpacht_miete_leasing' ,'kauf_erbpacht', 'miete_leasing'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_page'],
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['setRealEstateType'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['setRealEstateType'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['realEstateType'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['realEstateType'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('tl_page_estate_manager', 'getRealEstateTypes'),
    'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['realEstateQueryLanguage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['realEstateQueryLanguage'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'language', 'maxlength'=>5, 'nospace'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(5) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['realEstateQueryCountry'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['realEstateQueryCountry'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'alpha', 'maxlength'=>5, 'nospace'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(3) NOT NULL default ''"
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_page_estate_manager extends Contao\Backend
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
     * Get all locations and return them as array
     *
     * @return array
     */
    public function getLocations(): array
    {
        $arrLocations = array();
        $objLocations = ContaoEstateManager\ProviderModel::findAll();

        if ($objLocations === null)
        {
            return $arrLocations;
        }

        while ($objLocations->next())
        {
            $arrLocations[ $objLocations->id ] = $objLocations->postleitzahl . ' ' . $objLocations->ort . ' (' . $objLocations->firma . ')';
        }

        return $arrLocations;
    }

    /**
     * Return all real estate types as array
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getRealEstateTypes(Contao\DataContainer $dc): array
    {
        $objTypes = $this->Database->execute("SELECT id, title, longTitle FROM tl_real_estate_type");

        if ($objTypes->numRows < 1)
        {
            return array();
        }

        $arrTypes = array();

        while ($objTypes->next())
        {
            $arrTypes[$objTypes->id] = $objTypes->title . ' (' . $objTypes->longTitle . ')';
        }

        return $arrTypes;
    }
}
