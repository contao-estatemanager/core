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
use Contao\System;
use Contao\Model\Collection;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\Validator;
use ContaoEstateManager\EstateManager\Exception\ObjectTypeException;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Handle real estate filtering
 *
 * Usage:
 *  $manager = SessionManager::getInstance();
 *
 *  // Use active session in controllers
 *  $manager->setPage(1);
 *
 *  // Use request parameter instead of session (Default: MODE_SESSION)
 *  $manager->setMode(SessionManager::MODE_REQUEST);
 *
 *  // Set filter parameter
 *  $manager->set('preis_ab', 420000);
 *
 *  // Get filter parameter
 *  $manager->get('preis_ab');
 *
 *  $parameter = $manager->getParameter([0,1,2]);
 *  $parameter = $manager->getTypeParameter($objType);
 *  $parameter = $manager->getParameterByGroups([0,1,2]);
 *  ...
 *
 * @todo: Rename to FilterManger? The filter should also work via request parameters in the future, so the naming would be wrong.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class SessionManager extends System
{
    const STORAGE_KEY = 'FILTER_DATA';

    const MODE_SESSION = 0;
    const MODE_REQUEST = 1;

    /**
     * Object instance (Singleton).
     */
    protected static $objInstance;

    /**
     * PageModel of the current page.
     */
    protected PageModel $objPage;

    /**
     * PageModel of the current root page.
     */
    protected PageModel $objRootPage;

    /**
     * Real estate group object.
     */
    protected ?Collection $objGroups;

    /**
     * Real estate type object.
     */
    protected ?Collection $objTypes;

    /**
     * Selected marketing type
     * @var string
     */
    protected $marketingType = 'kauf_erbpacht_miete_leasing';

    /**
     * Selected real estate type
     * @var RealEstateTypeModel
     */
    protected $objCurrentType;

    /**
     * Current mode.
     */
    protected ?int $mode;

    /**
     * Prevent direct instantiation (Singleton).
     */
    protected function __construct($pageId=null)
    {
        parent::__construct();

        // Initialize session
        $_SESSION[self::STORAGE_KEY] = $_SESSION[self::STORAGE_KEY] ?? [];

        // Set default mode
        $this->setMode(self::MODE_SESSION);

        // Set page
        $this->setPage($pageId);

        $this->objGroups = RealEstateGroupModel::findAllPublished();
        $this->objTypes = RealEstateTypeModel::findAllPublished();
    }

    /**
     * Prevent cloning of the object (Singleton).
     */
    final public function __clone() {}

    /**
     * Return the current object instance (Singleton).
     */
    public static function getInstance($pageId=null): ?self
    {
        if (TL_MODE !== 'FE')
        {
            return null;
        }

        if (static::$objInstance === null)
        {
            static::$objInstance = new static($pageId);
            static::$objInstance->initialize();
        }

        return static::$objInstance;
    }

    /**
     * Initialize session.
     *
     * @todo Use Symfony Session
     */
    protected function initialize(): void
    {
        $d = $this->data();
        $submitted = $this->filterSubmitted();

        if (!$submitted)
        {
            $objGroups = $this->getGroupCollectionByReferencePage($this->objPage->id);
            $objTypes = $this->getTypeCollectionByReferencePage($this->objPage->id);

            // Objekttyp und Objektgruppe auf Referenzseite gefunden
            if ($objGroups->count() > 0 && $objTypes->count() > 0)
            {
                foreach ($objTypes as $objType)
                {
                    if ($d->get('real-estate-type') == $objType->id)
                    {
                        $this->marketingType = ($d->has('marketing-type') || $d->get('marketing-type') === 'kauf_erbpacht_miete_leasing') ? 'kauf_erbpacht_miete_leasing' : $objType->vermarktungsart;
                        $this->objCurrentType = $objType;

                        return;
                    }
                }

                foreach ($objGroups as $objGroup)
                {
                    if ($d->get('marketing-type') === $objGroup->vermarktungsart)
                    {
                        $this->marketingType = $objGroup->vermarktungsart;
                        $this->objCurrentType = null;

                        $this->set('real-estate-type', '');

                        return;
                    }
                }
            }

            if ($objGroups->count() === 0 && $objTypes->count() === 0)
            {
                $this->marketingType = 'kauf_erbpacht_miete_leasing';
                $this->objCurrentType = null;

                $this->set('marketing-type', $this->marketingType);
                $this->set('real-estate-type', '');

                return;
            }

            if ($objGroups->count() === 0 && $objTypes->count() > 0)
            {
                foreach ($objTypes as $objType)
                {
                    //$this->marketingType = ($d->get('marketing-type') === '' || $d->get('marketing-type') === 'kauf_erbpacht_miete_leasing') ? 'kauf_erbpacht_miete_leasing' : $objType->vermarktungsart;
                    $this->marketingType = $objType->vermarktungsart;
                    $this->objCurrentType = $objType;

                    $this->set('marketing-type', $this->marketingType);
                    $this->set('real-estate-type', $objType->id);

                    return;
                }
            }

            foreach ($objGroups as $objGroup)
            {
                $this->marketingType = $objGroup->vermarktungsart;
                $this->objCurrentType = null;

                $this->set('marketing-type', $objGroup->vermarktungsart);
                $this->set('real-estate-type', '');

                return;
            }
        }

        if(!empty($d->get('real-estate-type')))
        {
            $objType = $this->getTypeById(intval($d->get('real-estate-type')));

            $this->marketingType = $objType->vermarktungsart;
            $this->objCurrentType = $objType;

            $this->set('marketing-type', $this->marketingType);
            $this->set('real-estate-type', $objType->id);
            return;
        }

        if(!empty($d->get('marketing-type')))
        {
            $this->marketingType = $d->get('marketing-type');
            $this->objCurrentType = null;
        }
    }

    /**
     * Return true if filter submitted during this request and unset session indicator
     *
     * @return boolean
     */
    protected function filterSubmitted()
    {
        if($submitted = $_SESSION['FILTER_DATA']['FILTER_SUBMITTED'] ?? null)
        {
            unset($_SESSION['FILTER_DATA']['FILTER_SUBMITTED']);
        }

        return !!$submitted;
    }

    /**
     * Set page scope by PageModel or ID.
     */
    public function setPage($page): void
    {
        if($page === null)
        {
            /** @var PageModel $objPage */
            global $objPage;
        }
        elseif(is_numeric($page))
        {
            $objPage = PageModel::findById($page);
        }
        elseif($page instanceof PageModel)
        {
            $objPage = $page;
        }

        $this->objPage = $objPage->loadDetails();
        $this->objRootPage = PageModel::findByPk($this->objPage->rootId);
    }

    /**
     * Set source mode.
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * Get data by current mode.
     *
     * @todo Use Symfony Session
     */
    protected function data(): ParameterBag
    {
        switch ($this->mode)
        {
            case self::MODE_REQUEST:
                $dataContainer = System::getContainer()->get('request_stack')->getCurrentRequest();
                $dataContainer = $dataContainer->query->all();
                break;

            default:
                $dataContainer = $_SESSION[self::STORAGE_KEY];
        }

        return new ParameterBag($dataContainer);
    }

    /**
     * Set a new key-value pair for applying filtering.
     *
     * @todo Use Symfony Session
     */
    public function set($key, $value): void
    {
        switch ($this->mode)
        {
            case self::MODE_REQUEST:
                $request = System::getContainer()->get('request_stack')->getCurrentRequest();
                $request->query->set($key, $value);
                break;

            default:
                $_SESSION[self::STORAGE_KEY][$key] = $value;
        }
    }

    /**
     * Return the value of a given key with the possibility to define a default value if the key is not found.
     */
    public function get($key, $default = '')
    {
        return $this->data()->get($key, $default);
    }

    /**
     * Returns true if the parameter is defined.
     */
    public function has($key): bool
    {
        return $this->data()->has($key);
    }

    /**
     * Collect and return parameters for a given group, considering the selected type.
     */
    public function getParameter(array $arrGroups, $objModule = null): array
    {
        if ($this->objCurrentType !== null)
        {
            return $this->getTypeParameter($this->objCurrentType, $objModule);
        }

        if (is_array($arrGroups) && $this->marketingType !== 'kauf_erbpacht_miete_leasing')
        {
            // Unset real estate groups if marketing type not apply
            foreach ($this->objGroups as $objGroup)
            {
                if (($index = array_search($objGroup->id, $arrGroups)) !== false)
                {
                    if ($objGroup->vermarktungsart !== $this->marketingType)
                    {
                        unset($arrGroups[$index]);
                    }
                }
            }
        }

        return $this->getParameterByGroups($arrGroups, $objModule, true);
    }

    /**
     * Collect and return parameter by a given type.
     *
     * @todo: Maybe it makes sense to outsource all QueryFragments to a FilterFragment class? I am unsure.
     */
    protected function getTypeParameter(?RealEstateTypeModel $objType, $objModule = null): array
    {
        $arrColumns = [];
        $arrValues = [];
        $arrOptions = [];

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $objModule);

        if ($objType === null)
        {
            throw new ObjectTypeException('No object type could be found.');
        }

        $this->addQueryFragmentBasics($objType, $arrColumns, $arrValues);
        $this->addQueryFragmentCountry($arrColumns, $arrValues);
        $this->addQueryFragmentLocation($arrColumns, $arrValues);
        $this->addQueryFragmentPrice($objType, $arrColumns, $arrValues);
        $this->addQueryFragmentRoom($arrColumns, $arrValues);
        $this->addQueryFragmentArea($objType, $arrColumns, $arrValues);
        $this->addQueryFragmentPeriod($arrColumns, $arrValues);

        $arrOptions['order']  = $this->getOrderOption();

        // HOOK: get filtered type parameter
        if (isset($GLOBALS['CEM_HOOKS']['getFilteredTypeParameter']) && \is_array($GLOBALS['CEM_HOOKS']['getFilteredTypeParameter']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getFilteredTypeParameter'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $objModule);
            }
        }

        return [$arrColumns, $arrValues, $arrOptions];
    }

    /**
     * Collect and return parameter by a given set of groups.
     */
    public function getParameterByGroups(array $arrGroups, $objModule, bool $blnFiltered=false): array
    {
        $arrColumns = [];
        $arrValues = [];
        $arrOptions = [];
        $arrTypeColumns = [];

        $objTypes = $this->getTypeCollectionByPids($arrGroups);

        if (null === $objTypes)
        {
            throw new ObjectTypeException('No object type could be found.');
        }

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $objModule);
        //$this->addQueryFragmentCountry($arrColumns, $arrValues); // ToDo: Sollen normale Immobilienlisten anhand eines Landes filtern? Woher kommt diese Information? (aus dem Modul?)

        foreach ($objTypes as $objType)
        {
            $arrColumn = [];

            $this->addQueryFragmentBasics($objType, $arrColumn, $arrValues);

            if ($blnFiltered)
            {
                $this->addQueryFragmentCountry($arrColumn, $arrValues);
                $this->addQueryFragmentLocation($arrColumn, $arrValues);
                $this->addQueryFragmentPrice($objType, $arrColumn, $arrValues);
                $this->addQueryFragmentRoom($arrColumn, $arrValues);
                $this->addQueryFragmentArea($objType, $arrColumn, $arrValues);
                $this->addQueryFragmentPeriod($arrColumn, $arrValues);
            }

            // HOOK: modify parameter fragments
            if (isset($GLOBALS['CEM_HOOKS']['getGroupQueryFragments']) && \is_array($GLOBALS['CEM_HOOKS']['getGroupQueryFragments']))
            {
                foreach ($GLOBALS['CEM_HOOKS']['getGroupQueryFragments'] as $callback)
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($objType, $arrColumn, $arrValues, $objModule);
                }
            }

            $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
        }

        $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        $arrOptions['order'] = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['CEM_HOOKS']['getParameterByGroups']) && \is_array($GLOBALS['CEM_HOOKS']['getParameterByGroups']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getParameterByGroups'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $objModule);
            }
        }

        return [$arrColumns, $arrValues, $arrOptions];
    }

    /**
     * Collect and return parameter by a given set of types.
     */
    public function getParameterByTypes(array $arrTypes, $objModule): array
    {
        $arrColumns = [];
        $arrValues = [];
        $arrOptions = [];

        $arrTypeColumns = [];

        $objTypes = $this->getTypeCollectionByIds($arrTypes);

        if ($objTypes === null)
        {
            throw new ObjectTypeException('No object type could be found.');
        }

        $this->addQueryFragmentLanguage($arrColumns, $arrValues);
        $this->addQueryFragmentProvider($arrColumns, $objModule);
        //$this->addQueryFragmentCountry($arrColumns, $arrValues); // ToDo: Sollen normale Immobilienlisten anhand eines Landes filtern? Woher kommt diese Information? (aus dem Modul?)

        foreach ($objTypes as $objType)
        {
            $arrColumn = [];

            $this->addQueryFragmentBasics($objType, $arrColumn, $arrValues);

            // HOOK: modify parameter fragments
            if (isset($GLOBALS['CEM_HOOKS']['getTypeQueryFragments']) && \is_array($GLOBALS['CEM_HOOKS']['getTypeQueryFragments']))
            {
                foreach ($GLOBALS['CEM_HOOKS']['getTypeQueryFragments'] as $callback)
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($objType, $arrColumn, $arrValues, $objModule);
                }
            }

            $arrTypeColumns[] = '(' . implode(' AND ', $arrColumn) . ')';
        }

        $arrColumns[] = '(' . implode(' OR ', $arrTypeColumns) . ')';
        $arrOptions['order'] = $this->getOrderOption();

        // HOOK: get type parameter by groups
        if (isset($GLOBALS['CEM_HOOKS']['getParameterByTypes']) && \is_array($GLOBALS['CEM_HOOKS']['getParameterByTypes']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['getParameterByTypes'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $objModule);
            }
        }

        return [$arrColumns, $arrValues, $arrOptions];
    }

    /**
     * Add language query fragment.
     */
    protected function addQueryFragmentLanguage(array &$arrColumns, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();

        if ($this->objRootPage->realEstateQueryLanguage)
        {
            $arrColumns[] = "$t.sprache=?";
            $arrValues[]  = $this->objRootPage->realEstateQueryLanguage;
        }
    }

    /**
     * Add country query fragment.
     */
    protected function addQueryFragmentCountry(array &$arrColumns, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();

        if ($country = $this->data()->get('country'))
        {
            $arrColumns[] = "$t.land=?";
            $arrValues[] = $country;
        }
        elseif ($this->objRootPage->realEstateQueryCountry)
        {
            $arrColumns[] = "$t.land=?";
            $arrValues[] = $this->objRootPage->realEstateQueryCountry;
        }
    }

    /**
     * Add query fragment for the location field.
     */
    protected function addQueryFragmentLocation(array &$arrColumn, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();

        if ($location = $this->data()->get('location'))
        {
            $matches = [];

            if (preg_match('/[0-9]{3,5}/', $location, $matches, PREG_UNMATCHED_AS_NULL))
            {
                $arrColumn[] = "$t.plz LIKE ?";
                $arrValues[] = $matches[0].'%';
                $location = trim(str_replace($matches[0], '', $location));
            }

            if ($location)
            {
                $arrColumn[] = "($t.ort LIKE ? OR $t.regionalerZusatz LIKE ?)";
                $arrValues[] = $location.'%';
                $arrValues[] = $location.'%';
            }
        }
    }

    /**
     * Add query fragment for price fields.
     */
    protected function addQueryFragmentPrice(RealEstateTypeModel $objRealEstateType, array &$arrColumn, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();
        $d = $this->data();

        if ($d->get('price_per') === 'square_meter')
        {
            if ($priceFrom = $d->get('price_from'))
            {
                if ($objRealEstateType->vermarktungsart === 'miete_leasing')
                {
                    $arrColumn[] = "$t.mietpreisProQm>=?";
                    $arrValues[] = $priceFrom;
                }
                else
                {
                    $arrColumn[] = "$t.kaufpreisProQm>=?";
                    $arrValues[] = $priceFrom;
                }
            }

            if ($priceTo = $d->get('price_to'))
            {
                if ($objRealEstateType->vermarktungsart === 'miete_leasing')
                {
                    $arrColumn[] = "$t.mietpreisProQm<=?";
                    $arrValues[] = $priceTo;
                }
                else
                {
                    $arrColumn[] = "$t.kaufpreisProQm<=?";
                    $arrValues[] = $priceTo;
                }
            }
        }
        else
        {
            if ($priceFrom = $d->get('price_from'))
            {
                $arrColumn[] = "$t.$objRealEstateType->price>=?";
                $arrValues[] = $priceFrom;
            }
            if ($priceTo = $d->get('price_to'))
            {
                $arrColumn[] = "$t.$objRealEstateType->price<=?";
                $arrValues[] = $priceTo;
            }
        }
    }

    /**
     * Add query fragment for room fields.
     */
    protected function addQueryFragmentRoom(array &$arrColumn, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();
        $d = $this->data();

        if ($roomFrom = $d->get('room_from'))
        {
            $arrColumn[] = "$t.anzahlZimmer>=?";
            $arrValues[] = $roomFrom;
        }

        if ($roomTo = $d->get('room_to'))
        {
            $arrColumn[] = "$t.anzahlZimmer<=?";
            $arrValues[] = $roomTo;
        }
    }

    /**
     * Add query fragment for area fields.
     */
    protected function addQueryFragmentArea(RealEstateTypeModel $objRealEstateType, array &$arrColumn, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();
        $d = $this->data();

        if ($areaFrom = $d->get('area_from'))
        {
            $arrColumn[] = "$t.$objRealEstateType->area>=?";
            $arrValues[] = $areaFrom;
        }
        if ($areaTo = $d->get('area_to'))
        {
            $arrColumn[] = "$t.$objRealEstateType->area<=?";
            $arrValues[] = $areaTo;
        }
    }

    /**
     * Add query fragment for period fields.
     */
    protected function addQueryFragmentPeriod(array &$arrColumn, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();
        $d = $this->data();

        if ($periodFrom = $d->get('period_from'))
        {
            if (Validator::isDate($periodFrom))
            {
                $arrColumn[] = "($t.abdatum<=? OR abdatum='')";

                $date = new \Date($periodFrom);
                $arrValues[] = $date->tstamp;
            }
        }
        if ($periodTo = $d->get('period_to'))
        {
            if (Validator::isDate($periodTo))
            {
                $arrColumn[] = "($t.bisdatum>=? OR $t.bisdatum='')";

                $date = new \Date($periodTo);
                $arrValues[] = $date->tstamp;
            }
        }
    }

    /**
     * Add provider query fragment.
     */
    protected function addQueryFragmentProvider(array &$arrColumns, $objModule=null): void
    {
        if ($objModule === null)
        {
            return;
        }

        $t = RealEstateModel::getTable();

        if ($objModule->filterByProvider)
        {
            $arrProvider = StringUtil::deserialize($objModule->provider, true);

            if (\count($arrProvider))
            {
                $arrColumns[] = "$t.provider IN (" . implode(',', $arrProvider) . ")";
            }
        }
    }

    /**
     * Add basic real estate type query fragment.
     */
    protected function addQueryFragmentBasics(RealEstateTypeModel $objType, array &$arrColumn, array &$arrValues): void
    {
        $t = RealEstateModel::getTable();

        if ($objType->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumn[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        elseif ($objType->vermarktungsart === 'miete_leasing')
        {
            $arrColumn[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }

        if ($objType->nutzungsart)
        {
            $arrColumn[] = "$t.nutzungsart=?";
            $arrValues[] = $objType->nutzungsart;
        }

        if ($objType->objektart)
        {
            $arrColumn[] = "$t.objektart=?";
            $arrValues[] = $objType->objektart;
        }
    }

    /**
     * Get a real estate group model by its ID.
     */
    public function getGroupById(int $id): ?RealEstateGroupModel
    {
        if ($this->objGroups === null)
        {
            return null;
        }

        foreach ($this->objGroups as $objGroup)
        {
            if ($objGroup->id === $id)
            {
                return $objGroup;
            }
        }

        return null;
    }

    /**
     * Get collection of real estate group models by their IDs.
     */
    public function getGroupCollectionByIds(array $arrIds= [], ?string $marketingType=null): ?Collection
    {
        if (empty($arrIds) || $this->objGroups === null)
        {
            return null;
        }

        $arrModels = [];

        foreach ($this->objGroups as $objGroup)
        {
            if (in_array($objGroup->id, $arrIds))
            {
                if ($marketingType === null)
                {
                    $arrModels[] = $objGroup;
                }
                elseif ($marketingType === $objGroup->vermarktungsart)
                {
                    $arrModels[] = $objGroup;
                }
            }
        }

        return new Collection($arrModels, 'tl_real_estate_group');
    }

    /**
     * Get collection of real estate group models by their reference page.
     */
    public function getGroupCollectionByReferencePage(int $id): ?Collection
    {
        $arrModels = [];

        foreach ($this->objGroups as $objGroup)
        {
            if ($objGroup->referencePage === $id)
            {
                $arrModels[] = $objGroup;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_group');
    }

    /**
     * Get a real estate type model by its ID.
     */
    public function getTypeById(int $id): ?RealEstateTypeModel
    {
        if ($this->objTypes === null)
        {
            return null;
        }

        foreach ($this->objTypes as $objType)
        {
            if ($objType->id == $id)
            {
                return $objType;
            }
        }

        return null;
    }

    /**
     * Get collection of real estate type models by their IDs.
     */
    public function getTypeCollectionByIds(array $arrIds = []): ?Collection
    {
        if (empty($arrIds) || $this->objTypes === null)
        {
            return null;
        }

        $arrModels = [];

        foreach ($this->objTypes as $objType)
        {
            if (in_array($objType->id, $arrIds))
            {
                $arrModels[] = $objType;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_type');
    }

    /**
     * Get collection of real estate type models by their parent IDs.
     */
    public function getTypeCollectionByPids(array $arrPids = []): ?Collection
    {
        if (empty($arrPids) || $this->objTypes === null)
        {
            return null;
        }

        $arrModels = [];

        foreach ($this->objTypes as $objType)
        {
            if (in_array($objType->pid, $arrPids))
            {
                $arrModels[] = $objType;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_type');
    }

    /**
     * Get collection of real estate type models by their reference page.
     */
    public function getTypeCollectionByReferencePage(int $id): ?Collection
    {
        $arrModels = [];

        foreach ($this->objTypes as $objType)
        {
            if ($objType->referencePage === $id)
            {
                $arrModels[] = $objType;
            }
        }

        return new Collection($arrModels, 'tl_real_estate_type');
    }

    public function getSelectedMarketingType(): string
    {
        $strMarketingType = 'kauf_erbpacht_miete_leasing';

        if ($marketingType = $this->data()->get('marketing-type'))
        {
            $strMarketingType = $marketingType;
        }

        return $strMarketingType;
    }

    /**
     * Return the selected real estate type model.
     */
    public function getSelectedType(): ?RealEstateTypeModel
    {
        $objType = null;

        if ($realEstateType = $this->data()->get('real-estate-type'))
        {
            $objType = $this->getTypeById($realEstateType);
        }

        /*if ($objType !== null && $objType->vermarktungsart !== $this->getSelectedMarketingType())
        {
            $objType = $this->getTypeById($objType->similarType);
        }*/

        return $objType;
    }

    /**
     * Return the order option as string.
     */
    protected function getOrderOption(): string
    {
        $strOrder = $_SESSION['SORTING'] ?? null;

        if ($strOrder === null)
        {
            return (Config::get('defaultSorting') ?: 'tstamp') . ' DESC';
        }

        if (strpos($strOrder, '_asc'))
        {
            $strOrder = str_replace('_asc', '', $strOrder) . ' ASC';
        }
        elseif (strpos($strOrder, '_desc'))
        {
            $strOrder = str_replace('_desc', '', $strOrder) . ' DESC';
        }

        return $strOrder;
    }

    /**
     * Get current real estate type
     */
    public function getCurrentRealEstateType(): ?RealEstateTypeModel
    {
        $objType = null;

        if ($realEstateType = $this->data()->get('real-estate-type'))
        {
            $objType = $this->getTypeById($realEstateType);
        }

        return $objType;
    }

    /**
     * Determine current reference page
     */
    public function getJumpToPage(array $arrGroups): ?PageModel
    {
        $d = $this->data();

        // Filterung nach Objekttyp
        if ($realEstateType = $d->get('real-estate-type'))
        {
            $objType = $this->getTypeById($realEstateType);

            // Wenn Objektyp eine Referenzseite hat --> Zur Referenzseite weiterleiten
            if (in_array($objType->pid, $arrGroups) && ($objJumpTo = $objType->getRelated('referencePage')) instanceof PageModel)
            {
                return $objJumpTo;
            }

            // Wenn Objekttyp keine Referenzseite hat --> Zur Referenzseite der Gruppe weiterleiten
            if (($objJumpTo = $objType->getRelated('pid')->getRelated('referencePage')) instanceof PageModel)
            {
                return $objJumpTo;
            }
        }

        // Filterung nach Vermarktungsart
        if ($marketingType = $d->get('marketing-type'))
        {
            $objGroups = $this->getGroupCollectionByIds($arrGroups, $marketingType);

            // Wenn genau eine Objektgruppe gefunden wurde --> Zur Referenzseite weiterleiten
            // Wurden mehr als eine Objektgruppe gefunden --> Zur Weiterleitungsseite des Filters weiterleiten (Fallback) --> Alle Immobilien mehrerer Objektgruppen, aber ausschließlich einer Vermarktungsart werden in Übersichtsseite angezeigt
            if ($objGroups !== null && $objGroups->count() === 1)
            {
                if (($objJumpTo = $objGroups->getRelated('referencePage')) instanceof PageModel)
                {
                    return $objJumpTo;
                }
            }
        }

        // Zur Weiterleitungsseite des Filters weiterleiten (Fallback)
        return null;
    }
}
