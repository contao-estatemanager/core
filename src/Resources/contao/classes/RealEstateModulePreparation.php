<?php

namespace ContaoEstateManager;

use Contao\StringUtil;

class RealEstateModulePreparation extends RealEstate
{
    /**
     * $objModule
     * @var ModuleRealEstate
     */
    private $objModule = null;

    /**
     * RealEstateModulePreparation
     *
     * Initialize the object
     *
     * @param RealEstateModel   $objRealEstate
     * @param ModuleRealEstate  $objModule
     * @param int|null          $typeId
     */
    public function __construct(RealEstateModel $objRealEstate, ModuleRealEstate $objModule, int $typeId=null)
    {
        /** @var ModuleRealEstate objModule */
        $this->objModule  = $objModule;

        parent::__construct($objRealEstate, $typeId);
    }

    public function generateExposeUrl($varPage=null): string
    {
        if(null === $varPage && $this->objModule->jumpTo)
        {
            $varPage = $this->objModule->jumpTo;
        }

        return parent::generateExposeUrl($varPage);
    }

    public function getFields(array $fields = null): array
    {
        if(null === $fields && $this->objModule->fields)
        {
            $fields = StringUtil::deserialize($this->objModule->fields);
        }

        return parent::getFields($fields);
    }

    public function getImageBundle(array $arrFields = null, int $max = null): array
    {
        if(null === $arrFields && $this->objModule->galleryModules)
        {
            $arrFields = StringUtil::deserialize($this->objModule->galleryModules);
        }

        if(null === $max && $this->objModule->numberOfItems)
        {
            $max = $this->objModule->numberOfItems;
        }

        return parent::getImageBundle($arrFields, $max);
    }

    // ToDo: Alle Funktionen aufnehmen
    // ToDo: Templates auf Basis dieser Klasse aufbereiten
    // ToDo: Überall wo expliziet auf DCA-Felder zugegriffen wird, mit der FieldMetadata-Klasse arbeiten
}