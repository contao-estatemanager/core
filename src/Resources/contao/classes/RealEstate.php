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

use Contao\Config;
use Contao\Controller;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;

/**
 * Provide methods to handle real estates.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class RealEstate extends System
{
    /**
     * RealEstate Object
     * @var null
     */
    private $objRealEstate;

    /**
     * Type Object
     * @var RealEstateType|null
     */
    private $objType;

    /**
     * Formatter Object
     * @var RealEstateFormatter|null
     */
    private $formatter;

    /**
     * Object links
     * @var null
     */
    private $links;

    /**
     * RealEstate
     */
    public function __construct($objRealEstate, int $typeId=null)
    {
        parent::__construct();

        Controller::loadDataContainer('tl_real_estate');

        $this->objRealEstate = $objRealEstate;

        /** @var RealEstateType $realEstateType */
        $realEstateType = RealEstateType::getInstance();

        if ($typeId === null)
        {
            $this->objType = $realEstateType->getTypeByRealEstate($objRealEstate);
        }
        else
        {
            $this->objType = $realEstateType->getTypeById($typeId);
        }

        $this->formatter = RealEstateFormatter::getInstance();
        $this->formatter->setRealEstateModel($objRealEstate);

        // collect links
        $arrLinks = StringUtil::deserialize($this->objRealEstate->links, true);

        foreach ($arrLinks as $link)
        {
            if(!$link)
            {
                continue;
            }

            $this->links[] = $link;
        }
    }

    /**
     * Return a parameter/value
     */
    public function __get($name)
    {
        if(property_exists($this, $name))
        {
            return $this->{$name};
        }

        switch($name)
        {
            case 'title':
                return $this->objRealEstate->objekttitel;

            default:
                if ($this->objRealEstate->{$name})
                {
                    return $this->objRealEstate->{$name};
                }
        }

        return parent::__get($name);
    }

    /**
     * Return a formatted parameter/value
     */
    public function get(string $name): ?array
    {
        return $this->formatter->getFormattedCollection($name);
    }

    /**
     * Returns the current type
     */
    public function getType(): RealEstateTypeModel
    {
        return $this->objType;
    }

    /**
     * Generate and return the expose url
     */
    public function generateExposeUrl($varPage): string
    {
        if(is_numeric($varPage))
        {
            $objPage = PageModel::findByPk($varPage);
        }
        else $objPage = $varPage;

        if (!$objPage instanceof PageModel)
        {
            global $objPage;
        }

        $params = (Config::get('useAutoItem') ? '/' : '/items/') . ($this->objRealEstate->alias ?: $this->objRealEstate->id);

        return StringUtil::ampersand($objPage->getFrontendUrl($params));
    }

    /**
     * Return a collection of parsed real estate fields
     */
    public function getFields(array $fields=null): array
    {
        $arrFields = [];

        if(!$fields)
        {
            return $arrFields;
        }

        foreach ($fields as $field)
        {
            if($this->formatter->isFilled($field))
            {
                $val = $this->formatter->getFormattedCollection($field);

                if(null !== $val)
                {
                    $arrFields[] = $val;
                }
            }
        }

        return $arrFields;
    }

    /**
     * Return the first assignable image uuid
     */
    public function getMainImageUuid(): string
    {
        if ($this->objRealEstate->titleImageSRC)
        {
            return $this->objRealEstate->titleImageSRC;
        }

        $arrFields = RealEstateFieldMetadata::getInstance()->getGroupFields('image');

        foreach ($arrFields as $field)
        {
            if ($this->objRealEstate->{$field} && $field !== 'titleImageSRC')
            {
                return StringUtil::deserialize($this->objRealEstate->{$field})[0];
            }
        }

        return '';
    }

    /**
     * Return image uuid's of the real estate
     */
    public function getImagesUuids(array $arrFields=null, int $max=null): array
    {
        $return = [];

        if(!$arrFields)
        {
            $arrFields = RealEstateFieldMetadata::getInstance()->getGroupFields('image');
        }

        $index = 1;

        foreach ($arrFields as $field)
        {
            if ($this->objRealEstate->{$field})
            {
                if($field === 'titleImageSRC')
                {
                    $return[] = $this->objRealEstate->titleImageSRC;

                    if ($max !== null && intval($max) === $index++){
                        break;
                    }
                }
                else
                {
                    $arrImages = StringUtil::deserialize($this->objRealEstate->{$field});

                    foreach ($arrImages as $image)
                    {
                        $return[] = $image;

                        if ($max !== null && intval($max) === $index++){
                            break 2;
                        }
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Return status token
     */
    public function getStatusTokens(array $validStatusToken=null): array
    {
        $return = [];

        if(!$validStatusToken)
        {
            return $return;
        }

        if (\in_array('new', $validStatusToken) && strtotime(Config::get('statusTokenNewDisplayDuration'), $this->objRealEstate->dateAdded) > time())
        {
            $return[] = array
            (
                'value' => Translator::translateValue('neu'),
                'class' => 'new'
            );
        }
        if (\in_array('reserved', $validStatusToken) && $this->objRealEstate->verkaufstatus === 'reserviert')
        {
            $return[] = array
            (
                'value' => Translator::translateValue('reserviert'),
                'class' => 'reserved'
            );
        }
        if (\in_array('sold', $validStatusToken) && $this->objRealEstate->verkaufstatus === 'verkauft' && ($this->objRealEstate->vermarktungsartKauf || $this->objRealEstate->vermarktungsartErbpacht))
        {
            $return[] = array
            (
                'value' => Translator::translateValue('verkauft'),
                'class' => 'sold'
            );
        }
        if (\in_array('rented', $validStatusToken) && !!$this->objRealEstate->vermietet && ($this->objRealEstate->vermarktungsartMietePacht || $this->objRealEstate->vermarktungsartLeasing))
        {
            $return[] = array
            (
                'value' => Translator::translateValue('vermietet'),
                'class' => 'rented'
            );
        }

        // HOOK: get status tokens
        if (isset($GLOBALS['CEM_HOOKS']['getStatusTokens']) && \is_array($GLOBALS['CEM_HOOKS']['getStatusTokens']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getStatusTokens'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($validStatusToken, $return, $this);
            }
        }

        return $return;
    }

    /**
     * Return marketing token
     */
    public function getMarketingToken(): ?array
    {
        if($this->objRealEstate->vermarktungsartKauf || $this->objRealEstate->vermarktungsartErbpacht)
        {
            return array(
                'value' => Translator::translateValue('for_sale'),
                'class' => 'for_sale'
            );
        }

        if($this->objRealEstate->vermarktungsartMietePacht || $this->objRealEstate->vermarktungsartLeasing)
        {
            return array(
                'value' => Translator::translateValue('for_rent'),
                'class' => 'for_rent'
            );
        }

        return null;
    }

    /**
     * Return the location
     */
    public function getLocation(bool $forceCompleteAddress=false): array
    {
        $arrAddress = [];

        if ($this->objRealEstate->objektadresseFreigeben || $forceCompleteAddress === true)
        {
            if ($this->objRealEstate->strasse)
            {
                $arrAddress['strasse'] = $this->objRealEstate->strasse;

                if ($this->objRealEstate->hausnummer)
                {
                    $arrAddress['hausnummer'] = $this->objRealEstate->hausnummer;
                }
            }
        }

        if ($this->objRealEstate->plz)
        {
            $arrAddress['plz'] = $this->objRealEstate->plz;
        }

        if ($this->objRealEstate->ort)
        {
            $arrAddress['ort'] = $this->objRealEstate->ort;

            if ($this->objRealEstate->regionalerZusatz)
            {
                $arrAddress['reagionalerZusatz'] = $this->objRealEstate->regionalerZusatz;
            }
        }

        return $arrAddress;
    }

    /**
     * Return location as string
     */
    public function getLocationString(bool $forceCompleteAddress=false): string
    {
        $strAddress = '';
        $arrAddress = $this->getLocation($forceCompleteAddress);

        if($arrAddress['strasse'] ?? null && $arrAddress['hausnummer'] ?? null)
        {
            $strAddress .= $arrAddress['strasse'] . ' ' . $arrAddress['hausnummer'] . ', ';
        }
        elseif($arrAddress['strasse'] ?? null)
        {
            $strAddress .= $arrAddress['strasse'] . ', ';
        }

        if($arrAddress['plz'] ?? null)
        {
            $strAddress .= $arrAddress['plz'] . ' ';
        }

        if($arrAddress['reagionalerZusatz'] ?? null)
        {
            $strAddress .= $arrAddress['ort'] . ' - ' . $arrAddress['reagionalerZusatz'];
        }
        else
        {
            $strAddress .= $arrAddress['ort'];
        }

        return $strAddress;
    }


    /**
     * Returns the price that can be assigned first
     */
    public function getMainPrice(): array
    {
        // check whether the price is filled and not zero
        if($this->objRealEstate->{$this->objType->price} && intval($this->objRealEstate->{$this->objType->price}))
        {
            return $this->formatter->getFormattedCollection($this->objType->price);
        }
        elseif($this->objRealEstate->{'freitextPreis'})
        {
            return $this->formatter->getFormattedCollection('freitextPreis');
        }
        else
        {
            return array(
                'value' => Translator::translateValue('auf_anfrage'),
                'label' => Translator::translateLabel('auf_anfrage'),
                'key'   => 'auf_anfrage',
                'class' => 'auf_anfrage'
            );
        }
    }

    /**
     * Returns the area that can be assigned first
     */
    public function getMainArea(): array
    {
        return $this->formatter->getFormattedCollection($this->objType->area);
    }

    /**
     * Returns all area fields
     */
    public function getAreas(): ?array
    {
        return $this->getPropertiesByGroup(null, false, ['area'])['detail'];
    }

    /**
     * Returns all price fields
     */
    public function getPrices(): ?array
    {
        return $this->getPropertiesByGroup(null, false, ['price'])['detail'];
    }

    /**
     * Returns all attribute fields
     */
    public function getAttributes(): ?array
    {
        return $this->getPropertiesByGroup(null, false, ['attribute'])['detail'];
    }

    /**
     * Returns all detail fields
     */
    public function getDetails(bool $includeAddress = false): ?array
    {
        return $this->getPropertiesByGroup(null, $includeAddress, ['detail'])['detail'];
    }

    /**
     * Returns all energy pass fields
     */
    public function getEnergy(): ?array
    {
        return $this->getPropertiesByGroup(null, false, ['energie'])['detail'];
    }

    /**
     * Return details from real estate
     */
    public function getPropertiesByGroup(array $separateGroups=null, bool $includeAddress = false, array $validGroups = null, string $defaultGroup = 'detail', ?array $sortingFields = null): array
    {
        $availableGroups = [];
        $groupSorting = ['area', 'price', 'attribute', 'detail', 'energie'];

        // set available groups and sort order
        if(!$validGroups)
        {
            $availableGroups = $groupSorting;
        }
        else
        {
            // we have to sort the fields, which contain several options, to be able to fill the groups correctly
            foreach ($groupSorting as $index)
            {
                if(\in_array($index, $validGroups))
                {
                    $availableGroups[] = $index;
                }
            }
        }

        if($includeAddress)
        {
            $availableGroups[] = 'address';
        }

        $collection = [];

        // loop through the real estate fields
        foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields'] as $field => $data)
        {
            // check whether the field may be included
            if(!isset($data['realEstate']) || !$this->formatter->isValid($field))
            {
                continue;
            }

            // get available config keys
            $configKeys = array_keys($data['realEstate']);
            $currentGroup = $data['realEstate']['group'] ?? [];

            // check if there a match with available flags / groups
            if(!\count(array_intersect($configKeys, $availableGroups)) && !count(array_intersect($availableGroups, (array) $currentGroup)))
            {
                continue;
            }

            // check if the fields have to be assigned to groups
            if(null === $separateGroups)
            {
                $val = $this->formatter->getFormattedCollection($field);

                if(null !== $val)
                {
                    $collection[ $defaultGroup ][ $field ] = $val;
                }
            }
            else
            {
                $allocationGroup  = $defaultGroup;
                $sortedGroupOrder = array();

                // sort order
                foreach ($availableGroups as $aGroup)
                {
                    if(\in_array($aGroup, $separateGroups))
                    {
                        $sortedGroupOrder[] = $aGroup;
                    }
                }

                // loop through given groups
                foreach ($sortedGroupOrder as $group)
                {
                    // check if the group is assignable
                    if(\in_array($group, $configKeys))
                    {
                        $allocationGroup = $group;
                        break;
                    }
                }

                $val = $this->formatter->getFormattedCollection($field);

                if($val !== null)
                {
                    $collection[ $allocationGroup ][ $field ] = $val;
                }
            }
        }

        // sort fields within the group
        foreach ($collection as $group => $fieldList) {
            $collection[ $group ] = $this->sort($fieldList, $sortingFields);
        }

        return $collection;
    }

    /**
     * Return main details from real estate
     */
    public function getMainDetails(int $max=null): array
    {
        $return = [];
        $arrMainDetails = StringUtil::deserialize($this->objType->mainDetails, true);

        // HOOK: get main details
        if (isset($GLOBALS['CEM_HOOKS']['getMainDetails']) && \is_array($GLOBALS['CEM_HOOKS']['getMainDetails']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getMainDetails'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrMainDetails, $this->objRealEstate, $max, $this);
            }
        }

        $index = 1;
        $max = $max !== null ? intval($max) : $max;

        foreach ($arrMainDetails as $detail)
        {
            if ($this->formatter->isValid($detail['field']))
            {
                $return[] = $this->formatter->getFormattedCollection($detail['field']);

                if ($max !== null && $max === $index++)
                {
                    break;
                }
            }
        }

        return $return;
    }

    /**
     * Return main attributes from real estate
     */
    public function getMainAttributes(int $max=null): array
    {
        $return = [];
        $arrMainAttributes = StringUtil::deserialize($this->objType->mainAttributes);

        if(null === $arrMainAttributes)
        {
            return $return;
        }

        $index = 1;

        foreach ($arrMainAttributes as $attribute)
        {
            if ($this->formatter->isFilled($attribute['field']))
            {
                $varValue = $this->objRealEstate->{$attribute['field']};

                // Check whether the field must be deserialized
                $varUnserialized = @unserialize($varValue);

                if (\is_array($varUnserialized))
                {
                    $arrFields = $varUnserialized;
                }
                else
                {
                    $arrFields = array($attribute['field']);
                }

                foreach ($arrFields as $field)
                {
                    $return[] = array(
                        'value' => $this->formatter->formatValue($attribute['field']),
                        'label' => Translator::translateAttribute($field, $attribute['field']),
                        'key'   => $attribute['field'],
                        'class' => $this->formatter->getClass($attribute['field'])
                    );

                    if ($max !== null && $max === $index++){
                        break 2;
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Return texts from real estate
     */
    public function getTexts(array $validTexts=null, int $maxTextLength=0): ?array
    {
        if(!$validTexts)
        {
            $validTexts = RealEstateFieldMetadata::getInstance()->getGroupFields('text');
        }

        $return = null;

        foreach ($validTexts as $field)
        {
            $textCollection = $this->formatter->getFormattedCollection($field);

            if($textCollection !== null && $textCollection['value'])
            {
                $textCollection['value'] = $this->formatter->shortenText($textCollection['value'], $maxTextLength);

                $return[ $field ] = $textCollection;
            }
        }

        return $return;
    }

    /**
     * Return object of the assigned provider
     */
    public function getProvider()
    {
        return $this->objRealEstate->getRelated('provider');
    }

    /**
     * Return data of the assigned contact person
     */
    public function getContactPerson(bool $forceCompleteAddress=false, bool $useProviderForwarding=false): ?array
    {
        $objContactPerson = $this->objRealEstate->getRelated('contactPerson');

        if(null === $objContactPerson)
        {
            return null;
        }

        $contactPerson = $objContactPerson->row();

        # Remove address fields
        if(!$objContactPerson->adressfreigabe && $forceCompleteAddress === false)
        {
            $arrAddressFields = ['strasse', 'hausnummer', 'plz', 'ort', 'land', 'zusatzfeld'];

            foreach ($arrAddressFields as $arrAddressField)
            {
                unset($contactPerson[ $arrAddressField ]);
            }
        }

        if($useProviderForwarding)
        {
            $objProvider = $objContactPerson->getRelated('pid');
        }

        if($useProviderForwarding && $objProvider->forwardingMode === 'provider') {

            if($objProvider->telefon)
            {
                $contactPerson['tel_zentrale'] = $objProvider->telefon;
            }

            if($objProvider->email)
            {
                $contactPerson['email_zentrale'] = $objProvider->email;
            }
        }

        return $contactPerson;
    }

    /**
     * Generate the main image
     */
    public function generateMainImage($imgSize, bool $blnImageFallback=true, $strTemplate=null): string
    {
        $objFile = FilesModel::findByUuid($this->getMainImageUuid());

        return self::parseImageTemplate($objFile, $imgSize, $blnImageFallback, $strTemplate);
    }

    /**
     * Generate all images
     */
    public function generateGallery($imgSize, array $arrFields=null, int $max=null, ?string $strTemplate=null): array
    {
        $return = [];
        $arrImages = $this->getImagesUuids($arrFields, $max);
        $objFiles = FilesModel::findMultipleByUuids($arrImages);

        if ($objFiles !== null)
        {
            while ($objFiles->next())
            {
                $strOutput = self::parseImageTemplate($objFiles->current(), $imgSize, false, $strTemplate);

                if (empty($strOutput))
                {
                    continue;
                }

                $return[] = $strOutput;
            }
        }

        if (!\count($return))
        {
            $return[] = self::parseImageTemplate(null, $imgSize, true, $strTemplate);
        }

        return $return;
    }

    /**
     * Parse an image with the picture_default template
     */
    public static function parseImageTemplate($objFile, $imgSize, bool $blnImageFallback=true, ?string $strTemplate=null): string
    {
        // ToDo: Check after merge
        if ($objFile === null || !file_exists($path = (System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFile->path)) || !filesize($path))
        {
            // Set default image
            if($blnImageFallback && $defaultImage = Config::get('defaultImage'))
            {
                $objFile = FilesModel::findByUuid($defaultImage);
            }
            else
            {
                return '';
            }
        }

        $arrImage = array
        (
            'id'         => $objFile->id,
            'singleSRC'  => $objFile->path,
            'title'      => '',              // ToDo: Set title from meta
            'filesModel' => $objFile,
            'size'       => $imgSize,
            'caption'    => null
        );

        if(!$strTemplate)
        {
            $strTemplate = 'picture_default';
        }

        $objTemplate = new FrontendTemplate($strTemplate);

        Controller::addImageToTemplate($objTemplate, $arrImage, null, null, $objFile);

        $objTemplate->setData($objTemplate->picture);

        return $objTemplate->parse();
    }

    /**
     * Sorts an array by order fields
     */
    private function sort($arrList, ?array $sortingFields = null): array
    {
        $ordered = [];
        $arrFieldOrder = RealEstateFieldMetadata::getInstance()->getOrderFields();

        $repositionField = static function(&$arr, $fieldName){
            if(false !== ($pos = array_search($fieldName, $arr)))
            {
                unset($arr[ $pos ]);
                array_unshift($arr, $fieldName);
            }
        };

        // Check module sorting fields
        if(null !== $sortingFields)
        {
            $orderCompareFields = array_intersect($sortingFields, $arrFieldOrder);

            foreach (array_reverse($orderCompareFields) as $orderCompareField)
            {
                $repositionField($arrFieldOrder, $orderCompareField);
            }
        }

        // Check object type sorting fields
        if($this->objType->orderFields ?? null)
        {
            $orderValues = StringUtil::deserialize($this->objType->orderedFields, true);

            foreach (array_reverse($orderValues) as $order)
            {
                $repositionField($arrFieldOrder, $order['field']);
            }
        }

        foreach ($arrFieldOrder as $key) {
            if (array_key_exists($key, $arrList)) {
                $ordered[$key] = $arrList[$key];
                unset($arrList[$key]);
            }
        }

        return $ordered + $arrList;
    }
}
