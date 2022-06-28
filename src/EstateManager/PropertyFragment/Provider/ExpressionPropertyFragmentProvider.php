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
            $columns = implode(' ' . $this->getOperator($fragment->operator) . ' ', array_map(fn($column) => $this->replaceOperators($column), $columns));
        }
        else
        {
            $columns = $this->replaceOperators($columns[0]);
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
            QueryFragment::LIKE        => 'contains',    // Symfony 6.1
            QueryFragment::STARTS_WITH => 'starts with', // Symfony 6.1
            QueryFragment::ENDS_WITH   => 'ends with'    // Symfony 6.1
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
            QueryFragment::LIKE        => '"strpos("~field~", "~context.escape(value)~") !== false"',
            QueryFragment::STARTS_WITH => '"strpos("~field~", "~context.escape(value)~") === 0"',
            QueryFragment::ENDS_WITH   => '"(substr_compare("~field~", "~context.escape(value)~", -strlen("~context.escape(value)~"))==0)"'
        ];

        return $modifiers[$modifier] ?? null;
    }

    /**
     * Replace single equal signs to double one for using in expression language
     */
    public function replaceOperators($str): string
    {
        return preg_replace('/(?<![=!<>])=(?![=!])/m', '==', $str);
    }
}
