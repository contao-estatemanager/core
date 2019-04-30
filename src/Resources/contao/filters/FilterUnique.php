<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


/**
 * Class FilterUnique
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class FilterUnique extends FilterWidget
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'filter_unique';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-unique';

    /**
     * Initialize the object
     *
     * @param array $arrAttributes An optional attributes array
     */
    public function __construct($arrAttributes=null)
    {
        if (is_array($arrAttributes))
        {
            $arrAttributes['name'] = 'unique';
        }

        parent::__construct($arrAttributes);
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

            case 'placeholder':
                $this->arrAttributes[$strKey] = $varValue;
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Rudimentary generate method
     */
    public function generate() {}
}
