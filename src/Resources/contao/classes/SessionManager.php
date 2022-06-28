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
use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\QueryFragment;
use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\Provider\SqlPropertyFragmentProvider;
use ContaoEstateManager\EstateManager\Exception\ObjectTypeException;
use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\PropertyFragmentBuilder;
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
     */
    protected string $marketingType = Filter::MARKETING_TYPE_ALL;

    /**
     * Selected real estate type
     */
    protected ?RealEstateTypeModel $objCurrentType = null;

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
        $_SESSION[Filter::STORAGE_KEY] = $_SESSION[Filter::STORAGE_KEY] ?? [];

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
                    if ($d->get(Filter::PROPERTY_TYPE_KEY) == $objType->id)
                    {
                        $this->marketingType = ($d->has(Filter::MARKETING_TYPE_KEY) || $d->get(Filter::MARKETING_TYPE_KEY) === Filter::MARKETING_TYPE_ALL) ? Filter::MARKETING_TYPE_ALL : $objType->vermarktungsart;
                        $this->objCurrentType = $objType;

                        return;
                    }
                }

                foreach ($objGroups as $objGroup)
                {
                    if ($d->get(Filter::MARKETING_TYPE_KEY) === $objGroup->vermarktungsart)
                    {
                        $this->marketingType = $objGroup->vermarktungsart;
                        $this->objCurrentType = null;

                        $this->set(Filter::PROPERTY_TYPE_KEY, '');

                        return;
                    }
                }
            }

            if ($objGroups->count() === 0 && $objTypes->count() === 0)
            {
                $this->marketingType = Filter::MARKETING_TYPE_ALL;
                $this->objCurrentType = null;

                $this->set(Filter::MARKETING_TYPE_KEY, $this->marketingType);
                $this->set(Filter::PROPERTY_TYPE_KEY, '');

                return;
            }

            if ($objGroups->count() === 0 && $objTypes->count() > 0)
            {
                foreach ($objTypes as $objType)
                {
                    //$this->marketingType = ($d->get(Filter::MARKETING_TYPE_KEY) === '' || $d->get(Filter::MARKETING_TYPE_KEY) === Filter::MARKETING_TYPE_ALL) ? Filter::MARKETING_TYPE_ALL : $objType->vermarktungsart;
                    $this->marketingType = $objType->vermarktungsart;
                    $this->objCurrentType = $objType;

                    $this->set(Filter::MARKETING_TYPE_KEY, $this->marketingType);
                    $this->set(Filter::PROPERTY_TYPE_KEY, $objType->id);

                    return;
                }
            }

            foreach ($objGroups as $objGroup)
            {
                $this->marketingType = $objGroup->vermarktungsart;
                $this->objCurrentType = null;

                $this->set(Filter::MARKETING_TYPE_KEY, $objGroup->vermarktungsart);
                $this->set(Filter::PROPERTY_TYPE_KEY, '');

                return;
            }
        }

        if(!empty($d->get(Filter::PROPERTY_TYPE_KEY)))
        {
            $objType = $this->getTypeById(intval($d->get(Filter::PROPERTY_TYPE_KEY)));

            $this->marketingType = $objType->vermarktungsart;
            $this->objCurrentType = $objType;

            $this->set(Filter::MARKETING_TYPE_KEY, $this->marketingType);
            $this->set(Filter::PROPERTY_TYPE_KEY, $objType->id);
            return;
        }

        if(!empty($d->get(Filter::MARKETING_TYPE_KEY)))
        {
            $this->marketingType = $d->get(Filter::MARKETING_TYPE_KEY);
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
        if($submitted = $_SESSION[Filter::STORAGE_KEY][Filter::SUBMITTED_KEY] ?? null)
        {
            unset($_SESSION[Filter::STORAGE_KEY][Filter::SUBMITTED_KEY]);
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

        if ($lang = $this->objRootPage->realEstateQueryLanguage)
        {
            $this->set('language', $lang);
        }

        if ($country = $this->objRootPage->realEstateQueryCountry)
        {
            $this->set('pageCountry', $country);
        }
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
                $dataContainer = $_SESSION[Filter::STORAGE_KEY];
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
                $_SESSION[Filter::STORAGE_KEY][$key] = $value;
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
     * Returns all parameter.
     */
    public function all(): array
    {
        return $this->data()->all();
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

        if (is_array($arrGroups) && $this->marketingType !== Filter::MARKETING_TYPE_ALL)
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
     */
    protected function getTypeParameter(?RealEstateTypeModel $objType, $objModule = null): array
    {
        if (null === $objType)
        {
            throw new ObjectTypeException('No object type could be found.');
        }

        $fragments = new PropertyFragmentBuilder($this->data(), new SqlPropertyFragmentProvider());
        $fragments->setObjType($objType);
        $fragments->setModule($objModule);

        // Apply fragments
        $fragments->applyMultiple([
            PropertyFragmentBuilder::FRAGMENT_BASIC,
            PropertyFragmentBuilder::FRAGMENT_LANGUAGE,
            PropertyFragmentBuilder::FRAGMENT_PROVIDER,
            PropertyFragmentBuilder::FRAGMENT_COUNTRY,
            PropertyFragmentBuilder::FRAGMENT_LOCATION,
            PropertyFragmentBuilder::FRAGMENT_PRICE,
            PropertyFragmentBuilder::FRAGMENT_ROOM,
            PropertyFragmentBuilder::FRAGMENT_AREA,
            PropertyFragmentBuilder::FRAGMENT_PERIOD
        ]);

        [$arrColumns, $arrValues] = $fragments->generate();

        $arrOptions = [
            'order' => $this->getOrderOption()
        ];

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
        if (null === $objTypes = $this->getTypeCollectionByPids($arrGroups))
        {
            throw new ObjectTypeException('No object type could be found.');
        }

        $fragments = new PropertyFragmentBuilder($this->data(), new SqlPropertyFragmentProvider());
        $fragments->setModule($objModule);

        // Apply fragments
        $fragments->applyMultiple([
            PropertyFragmentBuilder::FRAGMENT_LANGUAGE,
            PropertyFragmentBuilder::FRAGMENT_PROVIDER,
            //PropertyFragmentBuilder::FRAGMENT_COUNTRY // ToDo: Sollen normale Immobilienlisten anhand eines Landes filtern? Woher kommt diese Information? (aus dem Modul?)
        ]);

        // Subfragment collection
        $arrSubFragments = [];

        foreach ($objTypes as $objType)
        {
            $subFragments = new PropertyFragmentBuilder($this->data(), new SqlPropertyFragmentProvider());
            $subFragments->setModule($objModule);
            $subFragments->setObjType($objType);

            // Apply basic fragments
            $subFragments->apply(PropertyFragmentBuilder::FRAGMENT_BASIC);

            if ($blnFiltered)
            {
                $subFragments->applyMultiple([
                    PropertyFragmentBuilder::FRAGMENT_COUNTRY,
                    PropertyFragmentBuilder::FRAGMENT_LOCATION,
                    PropertyFragmentBuilder::FRAGMENT_PRICE,
                    PropertyFragmentBuilder::FRAGMENT_ROOM,
                    PropertyFragmentBuilder::FRAGMENT_AREA,
                    PropertyFragmentBuilder::FRAGMENT_PERIOD,
                ]);
            }

            // Get generated columns and values from subfragments
            [$arrSubColumns, $arrSubValues] = $subFragments->generate();

            // HOOK: modify parameter fragments
            if (isset($GLOBALS['CEM_HOOKS']['getGroupQueryFragments']) && \is_array($GLOBALS['CEM_HOOKS']['getGroupQueryFragments']))
            {
                foreach ($GLOBALS['CEM_HOOKS']['getGroupQueryFragments'] as $callback)
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($objType, $arrSubColumns, $arrSubValues, $objModule);
                }
            }

            $arrSubFragments[] = [$arrSubColumns, $arrSubValues];
        }

        // Create a single QueryFragment for all subfragments
        $queryFragment = new QueryFragment(['prefix' => false]);

        // Add OR operator for all columns in this fragment
        $queryFragment->operator(QueryFragment::OR);

        // Add all columns and values from subfragments to the QueryFragment
        foreach ($arrSubFragments as $subColumn)
        {
            $queryFragment->column('(' . implode(' AND ', $subColumn[0]) . ')');
            $queryFragment->value($subColumn[1]);
        }

        // Apply subfragments
        $fragments->setQueryFragment($queryFragment);

        // Get generated columns and values
        [$arrColumns, $arrValues] = $fragments->generate();

        // Add order options
        $arrOptions = [
            'order' => $this->getOrderOption()
        ];

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
        if (null === $objTypes = $this->getTypeCollectionByIds($arrTypes))
        {
            throw new ObjectTypeException('No object type could be found.');
        }

        $fragments = new PropertyFragmentBuilder($this->data(), new SqlPropertyFragmentProvider());
        $fragments->setModule($objModule);

        // Apply fragments
        $fragments->applyMultiple([
            PropertyFragmentBuilder::FRAGMENT_LANGUAGE,
            PropertyFragmentBuilder::FRAGMENT_PROVIDER,
            //PropertyFragmentBuilder::FRAGMENT_COUNTRY // ToDo: Sollen normale Immobilienlisten anhand eines Landes filtern? Woher kommt diese Information? (aus dem Modul?)
        ]);

        // Subfragment collection
        $arrSubFragments = [];

        foreach ($objTypes as $objType)
        {
            $subFragments = new PropertyFragmentBuilder($this->data(), new SqlPropertyFragmentProvider());
            $subFragments->setModule($objModule);
            $subFragments->setObjType($objType);

            // Apply basic fragments
            $subFragments->apply(PropertyFragmentBuilder::FRAGMENT_BASIC);

            // Get generated columns and values from subfragments
            [$arrSubColumns, $arrSubValues] = $subFragments->generate();

            // HOOK: modify parameter fragments
            if (isset($GLOBALS['CEM_HOOKS']['getTypeQueryFragments']) && \is_array($GLOBALS['CEM_HOOKS']['getTypeQueryFragments']))
            {
                foreach ($GLOBALS['CEM_HOOKS']['getTypeQueryFragments'] as $callback)
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($objType, $arrSubColumns, $arrSubValues, $objModule);
                }
            }

            $arrSubFragments[] = [$arrSubColumns, $arrSubValues];
        }

        // Create a single QueryFragment for all subfragments
        $queryFragment = new QueryFragment(['prefix' => false]);

        // Add OR operator for all columns in this fragment
        $queryFragment->operator(QueryFragment::OPERATOR_OR);

        // Add all columns and values from subfragments to the QueryFragment
        foreach ($arrSubFragments as $subColumn)
        {
            $queryFragment->column('(' . implode(' AND ', $subColumn[0]) . ')');
            $queryFragment->value($subColumn[1]);
        }

        // Apply subfragments
        $fragments->setQueryFragment($queryFragment);

        // Get generated columns and values
        [$arrColumns, $arrValues] = $fragments->generate();

        // Add order options
        $arrOptions = [
            'order' => $this->getOrderOption()
        ];

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
        $strMarketingType = Filter::MARKETING_TYPE_ALL;

        if ($marketingType = $this->data()->get(Filter::MARKETING_TYPE_KEY))
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

        if ($realEstateType = $this->data()->get(Filter::PROPERTY_TYPE_KEY))
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

        if ($realEstateType = $this->data()->get(Filter::PROPERTY_TYPE_KEY))
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
        if ($realEstateType = $d->get(Filter::PROPERTY_TYPE_KEY))
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
        if ($marketingType = $d->get(Filter::MARKETING_TYPE_KEY))
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
