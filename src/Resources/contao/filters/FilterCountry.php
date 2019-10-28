<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager;


use Contao\PageModel;
use Contao\StringUtil;

/**
 * Class FilterCountry
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class FilterCountry extends FilterWidget
{

    /**
     * Submit user input
     *
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'filter_country';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-country';

    /**
     * Initialize the object
     *
     * @param array       $arrAttributes Attributes array
     * @param FilterModel $objFilter     Parent filter model
     */
    public function __construct($arrAttributes, $objFilter=null)
    {
        parent::__construct($arrAttributes, $objFilter);
    }

    /**
     * Add specific attributes
     *
     * @param string $strKey   The attribute key
     * @param mixed  $varValue The attribute value
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'name':
                $this->strName = 'country';
                break;

            case 'mandatory':
                if ($varValue)
                {
                    $this->arrAttributes['required'] = 'required';
                }
                else
                {
                    unset($this->arrAttributes['required']);
                }
                parent::__set($strKey, $varValue);
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Parse the template file and return it as string
     *
     * @param array $arrAttributes An optional attributes array
     *
     * @return string The template markup
     */
    public function parse($arrAttributes=null)
    {
        $strClass = 'select';

        // Custom class
        if ($this->strClass != '')
        {
            $strClass .= ' ' . $this->strClass;
        }

        $this->strClass = $strClass;

        $options = $this->getOptions();

        \System::loadLanguageFile('tl_real_estate_filter');
        \System::loadLanguageFile('tl_real_estate_countries');

        $arrOptions = array();

        foreach ($options as $option)
        {
            $arrOptions[] = array
            (
                'value'    => $option,
                'selected' => $option === $_SESSION['FILTER_DATA']['country'] ? ' selected' : '',
                'label'    => $GLOBALS['TL_LANG']['tl_real_estate_countries'][$option]
            );
        }

        usort($arrOptions, function($a, $b){
            return $a['label'][0] > $b['label'][0];
        });

        array_unshift($arrOptions, array
        (
            'value'    => '',
            'selected' => '',
            'label'    => $this->placeholder
        ));

        $this->options = $arrOptions;

        return parent::parse($arrAttributes);
    }

    protected function getOptions()
    {
        $arrOptions = array();

        switch ($this->countrySource)
        {
            case 'pool':
                $language = '';

                if (TL_MODE == 'FE')
                {
                    /** @var \PageModel $objPage */
                    global $objPage;
                    $pageDetails = $objPage->loadDetails();
                    $objRootPage = PageModel::findByPk($pageDetails->rootId);

                    if ($objRootPage->realEstateQueryLanguage)
                    {
                        $language = "WHERE sprache='".$objRootPage->realEstateQueryLanguage."'";
                    }
                }

                $this->import('Database');

                $query = 'SELECT DISTINCT land FROM tl_real_estate '.$language.' ORDER BY land';
                $objCountry = $this->Database->prepare($query)
                    ->execute();

                while ($objCountry->next())
                {
                    $arrOptions[] = $objCountry->land;
                }
                break;
            case 'selection':
                $countryOptions = \StringUtil::deserialize($this->countryOptions, true);

                foreach ($countryOptions as $option)
                {
                    $arrOptions[] = $option['country'];
                }
                break;
        }

        return $arrOptions;
    }

    /**
     * Rudimentary generate method
     */
    public function generate() {}
}
