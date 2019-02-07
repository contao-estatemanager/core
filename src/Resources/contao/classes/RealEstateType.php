<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


class RealEstateType
{

    private static $instance = null;

    private $objTypes = null;

    private function __construct()
    {
        $this->objTypes = RealEstateTypeModel::findByPublished(1);
    }

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function getTypeByRealEstate($objRealEstate)
    {
        $arrTypes = $this->objTypes->fetchAll();
        
        foreach ($arrTypes as $index => $type)
        {
            if (!empty($type['nutzungsart']) && $type['nutzungsart'] !== $objRealEstate->nutzungsart) {
                unset($arrTypes[$index]);
                continue;
            }

            if (($type['vermarktungsart'] === 'miete_leasing' && ($objRealEstate->vermarktungsartKauf || $objRealEstate->vermarktungsartErbpacht)) || ($type['vermarktungsart'] === 'kauf_erbpacht' && ($objRealEstate->vermarktungsartMietePacht || $objRealEstate->vermarktungsartLeasing)) ) {
                unset($arrTypes[$index]);
                continue;
            }

            if (!empty($type['objektart']) && $type['objektart'] !== $objRealEstate->objektart) {
                unset($arrTypes[$index]);
                continue;
            }
        }

        if(count($arrTypes) > 1)
        {
            foreach ($arrTypes as $type)
            {
                if ($type['nutzungsart'] === '' || $type['vermarktungsart'] === '' || $type['objektart'] === '')
                {
                    return $this->getTypeById($type['id']);
                }
            }
        }
        else
        {
            return $this->getTypeById(array_shift($arrTypes)['id']);
        }
    }

    public function getTypeById($typeId)
    {
        $this->objTypes->reset();

        while ($this->objTypes->next())
        {
            if ($this->objTypes->id === $typeId) {
                return $this->objTypes->current();
            }
        }

        return null;
    }
}