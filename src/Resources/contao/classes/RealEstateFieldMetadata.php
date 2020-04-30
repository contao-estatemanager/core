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

use Contao\Controller;

class RealEstateFieldMetadata
{
    private static $instance = null;

    private $arrGroups = null;

    private $arrFlags = null;

    private $arrOrder = null;

    private function __construct()
    {
        Controller::loadDataContainer('tl_real_estate');

        $arrOrderFields = null;

        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields'] as $field => $data)
            {
                if(!\is_array($data['realEstate']))
                {
                    continue;
                }

                foreach ($data['realEstate'] as $key => $value)
                {
                    switch($key)
                    {
                        case 'order':
                            $arrOrderFields[$field] = $value;
                            break;

                        case 'group':
                            if(null === $this->arrGroups || !\in_array($value, $this->arrGroups))
                            {
                                $this->arrGroups[$value] = array();
                            }

                            $this->arrGroups[$value][] = $field;
                            break;

                        default:
                            if(null === $this->arrFlags || !\in_array($key, $this->arrFlags))
                            {
                                $this->arrFlags[$key] = array();
                            }

                            $this->arrFlags[$key][] = $field;
                    }
                }
            }

            if(null !== $arrOrderFields)
            {
                // sort fields by value
                asort($arrOrderFields);

                // set field names
                $this->arrOrder = array_keys($arrOrderFields);
            }
        }
    }

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * Return all fields of the passed group name
     *
     * @param $groupName
     *
     * @return array
     */
    public function getGroupFields($groupName): array
    {
        return $this->arrGroups[$groupName];
    }

    /**
     * Return all fields of the passed flag name
     *
     * @param $flagName
     *
     * @return array
     */
    public function getFlagFields($flagName): array
    {
        return $this->arrFlags[$flagName];
    }

    /**
     * Return all sort fields in the correct order
     *
     * @return array
     */
    public function getOrderFields(): array
    {
        return $this->arrOrder;
    }

}