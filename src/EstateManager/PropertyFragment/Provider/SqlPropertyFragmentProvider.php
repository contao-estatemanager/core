<?php

namespace ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\Provider;

use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\PropertyFragmentInterface;
use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\QueryFragment;
use ContaoEstateManager\RealEstateModel;

class SqlPropertyFragmentProvider implements PropertyFragmentInterface
{
    /**
     * @inheritDoc
     */
    public function parseFragment(QueryFragment $fragment): array
    {
        $columns = $fragment->columns;
        $values = $fragment->values;

        if($fragment->parameter['prefix'] ?? true)
        {
            $columns = array_map(fn($v) => $this->setTablePrefix($v), $columns);
        }

        if(count($columns) > 1)
        {
            $columns = '(' . implode(' ' . $this->getOperator($fragment->operator) . ' ', $columns) . ')';
        }
        else
        {
            $columns = $columns[0];
        }

        return [$columns, $values];
    }

    /**
     * @inheritDoc
     */
    public function generate(array $columns, array $values): array
    {
        return [$columns, $values];
    }

    /**
     * @inheritDoc
     */
    public function getOperator(string $operator): ?string
    {
        $operators = [
            QueryFragment::IN          => 'IN',
            QueryFragment::NOT_IN      => 'NOT IN',
            QueryFragment::OR          => 'OR',
            QueryFragment::AND         => 'AND',
            QueryFragment::LIKE        => 'LIKE',
            QueryFragment::STARTS_WITH => 'LIKE',
            QueryFragment::ENDS_WITH   => 'LIKE'
        ];

        return $operators[$operator] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getModifier(string $modifier): ?string
    {
        $modifiers = [
            QueryFragment::IN          => 'field ~ " " ~ operator ~ " " ~ context.list(value)',
            QueryFragment::STARTS_WITH => 'field ~ " " ~ operator ~ " " ~ context.escape(value ~ "%")',
            QueryFragment::ENDS_WITH   => 'field ~ " " ~ operator ~ " " ~ context.escape("%" ~ value)'
        ];

        return $modifiers[$modifier] ?? null;
    }

    /**
     * Return the given string with the table prefix
     */
    private function setTablePrefix($str): string
    {
        return RealEstateModel::getTable() . '.' . $str;
    }

}
