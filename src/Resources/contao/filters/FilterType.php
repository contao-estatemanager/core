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


use Contao\StringUtil;
use Model\Collection;

/**
 * Class FilterType
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class FilterType extends FilterWidget
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
    protected $strTemplate = 'filter_type';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-type';

    /**
     * Parent filter model
     *
     * @var FilterModel
     */
    protected $objFilter = null;

    /**
     * Groups
     * @var array
     */
    protected $arrGroups = array();

    /**
     * Select
     * @var array
     */
    protected $select = array();

    /**
     * Marketing type matched flag
     *
     * @var boolean
     */
    private $blnMarketingTypeMatched = false;

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
     * @param string $strKey   The attribute name
     * @param mixed  $varValue The attribute value
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'name':
                $this->strName = 'real-estate-type';
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

        $arrGroups = StringUtil::deserialize($this->objFilter->groups, true);

        $objGroups = RealEstateGroupModel::findPublishedByIds($arrGroups);

        if ($objGroups === null)
        {
            return '';
        }

        $objTypes = RealEstateTypeModel::findPublishedByPids($arrGroups);

        if ($objTypes === null)
        {
            return '';
        }

        $arrOptions = array();

        if ($this->objFilter->addBlankMarketingType)
        {
            $selected = $this->isMarketingOptionSelected('kauf_erbpacht_miete_leasing');

            $arrOptions[] = array
            (
                'type'     => 'option',
                'value'    => '',
                'selected' => $selected ? ' selected' : '',
                'label'    => $this->showPlaceholder ? Translator::translateFilter('all_types') : ''
            );
        }

        while ($objGroups->next())
        {
            if (!$this->mergeOptions)
            {
                $arrOptions[] = array
                (
                    'type'     => 'group_start',
                    'label'    => $objGroups->title
                );
            }

            if ($this->objFilter->addBlankRealEstateType)
            {
                $selected = $this->isMarketingOptionSelected($objGroups->vermarktungsart);

                $arrOptions[] = array
                (
                    'type'     => 'option',
                    'value'    => $objGroups->vermarktungsart,
                    'selected' => $selected ? ' selected' : '',
                    'label'    => 'Alle (' . $objGroups->title . ')'
                );
            }

            $objGroupTypes = $this->getGroupTypes($objTypes, $objGroups->id);

            if ($objGroupTypes === null)
            {
                continue;
            }

            while ($objGroupTypes->next())
            {
                $arrOptions[] = array
                (
                    'type'     => 'option',
                    'value'    => $objGroupTypes->id,
                    'selected' => $this->isRealEstateOptionSelected($objGroupTypes) ? ' selected' : '',
                    'label'    => $this->showLongTitle ? $objGroupTypes->longTitle : $objGroupTypes->title
                );
            }

            if (!$this->mergeOptions)
            {
                $arrOptions[] = array
                (
                    'type' => 'group_end'
                );
            }
        }

        $this->select = array
        (
            'options' => $arrOptions,
            'class' => 'real-estate-type'
        );

        return parent::parse($arrAttributes);
    }

    /**
     * Get current real estate type by a collection of types
     *
     * @return RealEstateTypeModel|null
     */
    protected function getCurrentType()
    {
        if (!$this->objFilter->addBlankMarketingType && !$this->objFilter->addBlankRealEstateType)
        {
            return RealEstateTypeModel::findOneByDefaultType(1);
        }

        return null;
    }

    /**
     * Datermine current real estate type by a collection of types
     *
     * @param Collection $objTypes
     * @param $pid
     *
     * @return Collection
     */
    protected function getGroupTypes($objTypes, $pid)
    {
        $arrTypes = array();

        while ($objTypes->next())
        {
            if ($objTypes->pid == $pid)
            {
                $arrTypes[] = $objTypes->current();
            }
        }

        $objTypes->reset();

        return new Collection($arrTypes, 'tl_real_estate_type');
    }

    /**
     * Is real estate type option selected
     *
     * @param RealEstateTypeModel $objType
     *
     * @return boolean
     */
    protected function isRealEstateOptionSelected($objType)
    {
        if ($this->objFilterSession->getCurrentRealEstateType() === null)
        {
            if (!$this->objFilter->addBlankMarketingType && $objType->defaultType)
            {
                return true;
            }

            return false;
        }

        if ($objType->id === $this->objFilterSession->getCurrentRealEstateType()->id)
        {
            return true;
        }

        return false;
    }

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate() {}
}
