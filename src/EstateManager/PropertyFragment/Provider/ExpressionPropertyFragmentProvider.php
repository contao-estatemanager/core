<?php

namespace ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\Provider;

use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\PropertyFragmentInterface;
use ContaoEstateManager\EstateManager\EstateManager\PropertyFragment\QueryFragment;

class ExpressionPropertyFragmentProvider implements PropertyFragmentInterface
{
    /**
     * @inheritDoc
     */
    public function parseFragment(QueryFragment $fragment): array
    {
        $columns = $fragment->columns;
        $values = $fragment->values;

        if(count($columns) > 1)
        {
            $columns = implode(' ' . $this->getOperator($fragment->operator) . ' ', array_map(fn($column) => $this->replaceEqual($column), $columns));
        }
        else
        {
            $columns = $this->replaceEqual($columns[0]);
        }

        return [$columns, $values];
    }

    /**
     * @inheritDoc
     */
    public function generate(array $columns, array $values): array
    {
        $collection = [];

        foreach ($columns as $key => $statement)
        {
            // ToDo: Change with str_starts_with if PHP8 and above
            if(strpos($statement, '?') !== false)
            {
                $collection[$key] = str_replace('?', QueryFragment::escape(array_shift($values)), $statement);
            }
            else
            {
                $collection[$key] = $statement;
            }
        }

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function getOperator(string $operator): ?string
    {
        $operators = [
            QueryFragment::IN          => 'in',
            QueryFragment::NOT_IN      => 'not in',
            QueryFragment::OR          => 'or',
            QueryFragment::AND         => 'and',
            QueryFragment::LIKE        => 'contains',
            QueryFragment::STARTS_WITH => 'starts with',
            QueryFragment::ENDS_WITH   => 'ends with'
        ];

        return $operators[$operator] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getModifier(string $modifier): ?string
    {
        $modifiers = [
            QueryFragment::IN          => 'field ~ " " ~ operator ~ " " ~ context.list(value, "[", "]")',
            QueryFragment::STARTS_WITH => 'field ~ " " ~ operator ~ " " ~ context.escape(value)',
            QueryFragment::ENDS_WITH   => 'field ~ " " ~ operator ~ " " ~ context.escape(value)'
        ];

        return $modifiers[$modifier] ?? null;
    }

    /**
     * Replace single equal sign to double for using in expression language
     */
    public function replaceEqual($str): string
    {
        return str_replace("=", "==", $str);
    }
}
