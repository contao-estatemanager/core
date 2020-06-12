<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// Add palettes selector
$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'attachRealEstateFeedbackXml';

// Add subpalettes
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['attachRealEstateFeedbackXml'] = 'realEstateFeedbackTemplate';

// Add fields
$GLOBALS['TL_DCA']['tl_form']['fields']['attachRealEstateFeedbackXml'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form']['attachRealEstateFeedbackXml'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form']['fields']['realEstateFeedbackTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form']['realEstateFeedbackTemplate'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('tl_form_estate_manager', 'getTemplates'),
    'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

// Extend the default palettes
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField(array('attachRealEstateFeedbackXml'), 'email_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_form')
;


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_form_estate_manager extends Contao\Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return all real estate feedback XML templates as array
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return $this->getTemplateGroup('form_feedback_');
    }
}