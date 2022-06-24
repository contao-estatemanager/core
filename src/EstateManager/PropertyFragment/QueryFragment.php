<?php

namespace ContaoEstateManager\EstateManager\EstateManager\PropertyFragment;

use Contao\System;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class QueryFragment
{
    /**
     * Operators
     */
    const OPERATOR_IN           = 'IN';
    const OPERATOR_OR           = 'OR';
    const OPERATOR_AND          = 'AND';
    const OPERATOR_LIKE         = 'LIKE';
    const OPERATOR_STARTS_WITH  = 'STARTS_WITH';
    const OPERATOR_ENDS_WITH    = 'ENDS_WITH';

    /**
     * Modifiers
     */
    const MODIFIER_IN           = 'IN';
    const MODIFIER_STARTS_WITH  = 'STARTS_WITH';
    const MODIFIER_ENDS_WITH    = 'ENDS_WITH';

    /**
     * Columns and values
     */
    public array $columns = [];
    public array $values = [];

    /**
     * Default operator
     */
    public string $operator = self::OPERATOR_OR;

    /**
     * Custom parameter
     */
    public ?array $parameter;

    /**
     * Initialize QueryFragment with custom parameters
     */
    public function __construct(?array $param = null)
    {
        $this->parameter = $param;
    }

    public function column($column): QueryFragment
    {
        if(null === $column)
        {
            return $this;
        }

        $this->columns[] = $column;

        return $this;
    }

    public function columnParts($field, $operator, $value, $modifier = null): QueryFragment
    {
        // Check if a modifier was passed
        if(null === $modifier)
        {
            $modifier = 'field operator value';
        }

        $this->columns[] = (new ExpressionLanguage())->evaluate($modifier, [
            'field'     => $field,
            'value'     => $value,
            'operator'  => $operator,
            'context'   => $this
        ]);

        return $this;
    }

    public function value($value): QueryFragment
    {
        if(null === $value)
        {
            return $this;
        }

        $this->values = array_merge($this->values, (array) $value);

        return $this;
    }

    public function operator(string $operator): QueryFragment
    {
        $this->operator = $operator;

        return $this;
    }

    public function escape($v): string
    {
        $connection = System::getContainer()->get('database_connection');

        switch (\gettype($v))
        {
            case 'string':
                return $connection->quote($v);
            case 'boolean':
                return ($v === true) ? 1 : 0;
            case 'object':
            case 'array':
                return $connection->quote(serialize($v));
            default:
                return $v ?? 'NULL';
        }
    }
}
