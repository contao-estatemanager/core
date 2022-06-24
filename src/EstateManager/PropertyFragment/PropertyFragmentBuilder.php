<?php

namespace ContaoEstateManager\EstateManager\EstateManager\PropertyFragment;

use Contao\Date;
use Contao\StringUtil;
use Contao\Validator;
use ContaoEstateManager\Filter;
use Symfony\Component\HttpFoundation\ParameterBag;

class PropertyFragmentBuilder
{
    /**
     * Basic fragments
     */
    const FRAGMENT_BASIC = 'BASIC';
    const FRAGMENT_COUNTRY = 'COUNTRY';
    const FRAGMENT_LANGUAGE = 'LANGUAGE';
    const FRAGMENT_LOCATION = 'LOCATION';
    const FRAGMENT_PRICE = 'PRICE';
    const FRAGMENT_ROOM = 'ROOM';
    const FRAGMENT_AREA = 'AREA';
    const FRAGMENT_PERIOD = 'PERIOD';
    const FRAGMENT_PROVIDER = 'PROVIDER';

    /**
     * The module used in fragments
     */
    private $module = null;

    /**
     * The object type used in fragments
     */
    private $objType = null;

    /**
     * Privat vars
     */
    private array $fragments = [];
    private array $columns = [];
    private array $values = [];

    private PropertyFragmentInterface $provider;
    private ParameterBag $data;

    /**
     * Initialize PropertyFragment class
     */
    public function __construct(ParameterBag $data, PropertyFragmentInterface $provider)
    {
        $this->data = $data;
        $this->provider = $provider;
    }

    /**
     * Set current object type
     */
    public function setObjType($objType): void
    {
        $this->objType = $objType;
    }

    /**
     * Set current module
     */
    public function setModule($module): void
    {
        $this->module = $module;
    }

    /**
     * Adds a custom Fragment
     */
    public function addFragment(string $fragmentName, callable $callback): void
    {
        $this->fragments[$fragmentName] = $callback;
    }

    /**
     * Apply a fragment
     */
    public function apply(string $fragment)
    {
        switch ($fragment)
        {
            case self::FRAGMENT_BASIC:
                $this->basicFragment();
                break;
            case self::FRAGMENT_LANGUAGE:
                $this->languageFragment();
                break;
            case self::FRAGMENT_COUNTRY:
                $this->countryFragment();
                break;
            case self::FRAGMENT_LOCATION:
                $this->locationFragment();
                break;
            case self::FRAGMENT_AREA:
                $this->areaFragment();
                break;
            case self::FRAGMENT_PRICE:
                $this->priceFragment();
                break;
            case self::FRAGMENT_PERIOD:
                $this->periodFragment();
                break;
            case self::FRAGMENT_ROOM:
                $this->roomFragment();
                break;
            case self::FRAGMENT_PROVIDER:
                $this->providerFragment();
                break;
            default:
                if($callback = ($this->fragments[$fragment] ?? null))
                {
                    // ToDo: Execute custom fragment callback
                }
        }
    }

    /**
     * Apply multiple fragments
     */
    public function applyMultiple(array $fragments)
    {
        foreach ($fragments as $fragment)
        {
            $this->apply($fragment);
        }
    }

    /**
     * Generate and return fragment structure
     */
    public function generate(): array
    {
        return $this->provider->generate($this->columns, $this->values);
    }

    /**
     * Add a new QueryFragment object
     */
    public function setQueryFragment(QueryFragment $fragment): void
    {
        [$column, $value] = $this->provider->parseFragment($fragment);

        if(is_array($value))
        {
            foreach ($value as $val)
            {
                $this->values[] = $val;
            }
        }
        elseif($value)
        {
            $this->values[] = $value;
        }

        $this->columns[] = $column;
    }

    /**
     * Add base property fragments
     */
    private function basicFragment(): void
    {
        if(null === $this->objType)
        {
            return;
        }

        if ($this->objType->vermarktungsart === Filter::MARKETING_TYPE_BUY)
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("vermarktungsartKauf='1'")
                    ->column("vermarktungsartErbpacht='1'")
                    ->operator(QueryFragment::OPERATOR_OR)
            );
        }
        elseif ($this->objType->vermarktungsart === Filter::MARKETING_TYPE_RENT)
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("vermarktungsartMietePacht='1'")
                    ->column("vermarktungsartLeasing='1'")
                    ->operator(QueryFragment::OPERATOR_OR)
            );
        }

        if ($this->objType->nutzungsart)
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("nutzungsart=?")
                    ->value($this->objType->nutzungsart)
            );
        }

        if ($this->objType->objektart)
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("objektart=?")
                    ->value($this->objType->objektart)
            );
        }
    }

    /**
     * Add language property fragment
     */
    private function languageFragment(): void
    {
        if ($lang = $this->data->get('language'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("sprache=?")
                    ->value($lang)
            );
        }
    }

    /**
     * Add country property fragment
     */
    private function countryFragment(): void
    {
        if ($country = $this->data->get('country'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("land=?")
                    ->value($country)
            );
        }
        elseif($country = $this->data->get('pageCountry'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("land=?")
                    ->value($country)
            );
        }
    }

    /**
     * Add location property fragment
     */
    private function locationFragment(): void
    {
        if ($location = $this->data->get('location'))
        {
            $matches = [];

            if (preg_match('/[0-9]{3,5}/', $location, $matches, PREG_UNMATCHED_AS_NULL))
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->columnParts(
                            'plz',
                            $this->provider->getOperator(QueryFragment::OPERATOR_STARTS_WITH),
                            $matches[0],
                            $this->provider->getModifier(QueryFragment::MODIFIER_STARTS_WITH)
                        )
                );

                $location = trim(str_replace($matches[0], '', $location));
            }

            if ($location)
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->columnParts(
                            'ort',
                            $this->provider->getOperator(QueryFragment::OPERATOR_STARTS_WITH),
                            $location,
                            $this->provider->getModifier(QueryFragment::MODIFIER_STARTS_WITH)
                        )
                        ->columnParts(
                            'regionalerZusatz',
                            $this->provider->getOperator(QueryFragment::OPERATOR_STARTS_WITH),
                            $location,
                            $this->provider->getModifier(QueryFragment::MODIFIER_STARTS_WITH)
                        )
                        ->operator(QueryFragment::OPERATOR_OR)
                );
            }
        }
    }

    /**
     * Add price property fragment
     */
    private function priceFragment(): void
    {
        if(null === $this->objType)
        {
            return;
        }

        if ($this->data->get('price_per') === 'square_meter')
        {
            if ($priceFrom = $this->data->get('price_from'))
            {
                if ($this->objType->vermarktungsart === Filter::MARKETING_TYPE_RENT)
                {
                    $this->setQueryFragment(
                        (new QueryFragment())
                            ->column("mietpreisProQm>=?")
                            ->value($priceFrom)
                    );
                }
                else
                {
                    $this->setQueryFragment(
                        (new QueryFragment())
                            ->column("kaufpreisProQm>=?")
                            ->value($priceFrom)
                    );
                }
            }

            if ($priceTo = $this->data->get('price_to'))
            {
                if ($this->objType->vermarktungsart === Filter::MARKETING_TYPE_RENT)
                {
                    $this->setQueryFragment(
                        (new QueryFragment())
                            ->column("mietpreisProQm<=?")
                            ->value($priceTo)
                    );
                }
                else
                {
                    $this->setQueryFragment(
                        (new QueryFragment())
                            ->column("kaufpreisProQm<=?")
                            ->value($priceTo)
                    );
                }
            }
        }
        else
        {
            if ($priceFrom = $this->data->get('price_from'))
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->column($this->objType->price . ">=?")
                        ->value($priceFrom)
                );
            }
            if ($priceTo = $this->data->get('price_to'))
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->column($this->objType->price . "<=?")
                        ->value($priceTo)
                );
            }
        }
    }

    /**
     * Add room property fragment
     */
    private function roomFragment(): void
    {
        if ($roomFrom = $this->data->get('room_from'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("anzahlZimmer>=?")
                    ->value($roomFrom)
            );
        }

        if ($roomTo = $this->data->get('room_to'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column("anzahlZimmer<=?")
                    ->value($roomTo)
            );
        }
    }

    /**
     * Add area property fragment
     */
    private function areaFragment(): void
    {
        if(null === $this->objType)
        {
            return;
        }

        if ($areaFrom = $this->data->get('area_from'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column($this->objType->area . ">=?")
                    ->value($areaFrom)
            );
        }
        if ($areaTo = $this->data->get('area_to'))
        {
            $this->setQueryFragment(
                (new QueryFragment())
                    ->column($this->objType->area . "<=?")
                    ->value($areaTo)
            );
        }
    }

    /**
     * Add period property fragment
     */
    private function periodFragment(): void
    {
        if ($periodFrom = $this->data->get('period_from'))
        {
            if (Validator::isDate($periodFrom))
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->column("abdatum<=?")
                        ->column("abdatum=''")
                        ->value((new Date($periodFrom))->tstamp)
                        ->operator(QueryFragment::OPERATOR_OR)
                );
            }
        }
        if ($periodTo = $this->data->get('period_to'))
        {
            if (Validator::isDate($periodTo))
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->column("bisdatum<=?")
                        ->column("bisdatum=''")
                        ->value((new Date($periodTo))->tstamp)
                        ->operator(QueryFragment::OPERATOR_OR)
                );
            }
        }
    }

    /**
     * Add provider property fragment
     */
    private function providerFragment(): void
    {
        if ($this->module === null)
        {
            return;
        }

        if ($this->module->filterByProvider)
        {
            $arrProvider = StringUtil::deserialize($this->module->provider, true);

            if (\count($arrProvider))
            {
                $this->setQueryFragment(
                    (new QueryFragment())
                        ->columnParts(
                            'provider',
                            $this->provider->getOperator(QueryFragment::OPERATOR_IN),
                            '(' . implode(',', array_map('intval', $arrProvider)) . ')',
                            $this->provider->getModifier(QueryFragment::MODIFIER_IN)
                        )
                );
            }
        }
    }
}
