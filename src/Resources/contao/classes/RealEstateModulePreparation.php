<?php

namespace ContaoEstateManager;

use Contao\PageModel;
use Contao\StringUtil;

class RealEstateModulePreparation extends RealEstate
{
    /**
     * $objModule
     * @var ModuleRealEstate
     */
    private $objModule;

    /**
     * RealEstateModulePreparation
     *
     * Initialize the object
     *
     * @param RealEstateModel   $objRealEstate
     * @param ModuleRealEstate  $objModule
     * @param int|null          $typeId
     */
    public function __construct(RealEstateModel $objRealEstate, $objModule, int $typeId=null)
    {
        parent::__construct($objRealEstate, $typeId);

        /** @var ModuleRealEstate objModule */
        $this->objModule  = $objModule;
    }

    /**
     * Generate and return the expose url
     *
     * @param int|PageModel $varPage
     *
     * @return string
     */
    public function generateExposeUrl($varPage=null): string
    {
        if(null === $varPage && $this->objModule->jumpTo)
        {
            $varPage = $this->objModule->jumpTo;
        }

        return parent::generateExposeUrl($varPage);
    }

    /**
     * Return a collection of parsed real estate fields
     *
     * @param array $fields
     *
     * @return array
     */
    public function getFields(array $fields = null): array
    {
        if(null === $fields && $this->objModule->fields)
        {
            $fields = StringUtil::deserialize($this->objModule->fields);
        }

        return parent::getFields($fields);
    }

    /**
     * Return image uuid's of the real estate
     *
     * @param array $arrFields
     * @param int $max
     *
     * @return array
     */
    public function getImagesUuids(array $arrFields = null, int $max = null): array
    {
        if(null === $arrFields && $this->objModule->galleryModules)
        {
            $arrFields = StringUtil::deserialize($this->objModule->galleryModules);
        }

        if(null === $max && $this->objModule->numberOfItems)
        {
            $max = $this->objModule->numberOfItems;
        }

        return parent::getImagesUuids($arrFields, $max);
    }

    /**
     * Return status token
     *
     * @param array $validStatusToken
     *
     * @return array
     */
    public function getStatusTokens(array $validStatusToken=null): array
    {
        if(null === $validStatusToken && $this->objModule->statusTokens)
        {
            $validStatusToken = StringUtil::deserialize($this->objModule->statusTokens);
        }

        return parent::getStatusTokens($validStatusToken);
    }

    /**
     * Return the location
     *
     * @param bool $forceCompleteAddress
     *
     * @return array
     */
    public function getLocation(bool $forceCompleteAddress=null): array
    {
        if(null === $forceCompleteAddress)
        {
            $forceCompleteAddress = !!$this->objModule->forceFullAddress;
        }

        return parent::getLocation($forceCompleteAddress);
    }

    /**
     * Return the location
     *
     * @param bool $forceCompleteAddress
     *
     * @return string
     */
    public function getLocationString(bool $forceCompleteAddress=null): string
    {
        if(null === $forceCompleteAddress)
        {
            $forceCompleteAddress = !!$this->objModule->forceFullAddress;
        }

        return parent::getLocationString($forceCompleteAddress);
    }

    /**
     * Returns all detail fields
     *
     * @param bool $includeAddress
     *
     * @return array|null
     */
    public function getDetails(bool $includeAddress=null): ?array
    {
        if(null === $includeAddress)
        {
            $includeAddress = !!$this->objModule->includeAddress;
        }

        return parent::getDetails($includeAddress);
    }

    /**
     * Return details from real estate
     *
     * @param null|array    $separateGroups: area, price, attribute, detail
     * @param bool          $includeAddress
     * @param null|array    $validGroups
     * @param string        $defaultGroup: Allows you to add non-assignable fields to a custom group name or add them to an existing group
     *
     * @return array        array('group1' [,group2,group3,...])
     */
    public function getPropertiesByGroup(array $separateGroups=null, bool $includeAddress = null, array $validGroups=null, string $defaultGroup='detail'): array
    {
        if(null === $separateGroups && $this->objModule->detailBlocks)
        {
            $separateGroups = StringUtil::deserialize($this->objModule->detailBlocks);
        }

        if(null === $includeAddress)
        {
            $includeAddress = !!$this->objModule->includeAddress;
        }

        if(null === $validGroups && $this->objModule->detailBlocks)
        {
            $validGroups = StringUtil::deserialize($this->objModule->detailBlocks);
        }

        return parent::getPropertiesByGroup($separateGroups, $includeAddress, $validGroups, $defaultGroup);
    }

    /**
     * Return main details from real estate
     *
     * @param int $max
     *
     * @return array
     */
    public function getMainDetails(int $max=null): array
    {
        if(null === $max && $this->objModule->numberOfItems)
        {
            $max = $this->objModule->numberOfItems;
        }

        return parent::getMainDetails($max);
    }

    /**
     * Return main details from real estate
     *
     * @param int $max
     *
     * @return array
     */
    public function getMainAttributes(int $max=null): array
    {
        if(null === $max && $this->objModule->numberOfItems)
        {
            $max = $this->objModule->numberOfItems;
        }

        return parent::getMainAttributes($max);
    }

    /**
     * Return texts from real estate
     *
     * @param array $validTexts
     * @param int   $maxTextLength
     *
     * @return array|null
     */
    public function getTexts(array $validTexts=null, int $maxTextLength=null): ?array
    {
        if(null === $validTexts && $this->objModule->textBlocks)
        {
            $validTexts = $this->objModule->textBlocks;
        }

        if(null === $maxTextLength)
        {
            $maxTextLength = $this->objModule->maxTextLength;
        }

        return parent::getTexts($validTexts, $maxTextLength);
    }

    /**
     * Return data of the assigned contact person
     *
     * @param bool $forceCompleteAddress
     * @param bool $useProviderForwarding
     *
     * @return array|null
     *
     * @throws \Exception
     */
    public function getContactPerson(bool $forceCompleteAddress=null, bool $useProviderForwarding=null): ?array
    {
        if(null === $forceCompleteAddress)
        {
            $forceCompleteAddress = !!$this->objModule->forceFullAddress;
        }

        if(null === $useProviderForwarding)
        {
            $useProviderForwarding = !!$this->objModule->useProviderForwarding;
        }

        return parent::getContactPerson($forceCompleteAddress, $useProviderForwarding);
    }
}
