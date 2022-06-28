<?php

namespace ContaoEstateManager\EstateManager\EstateManager\PropertyFragment;

use Contao\System;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class QueryFragment
{
    /**
     * Operator and Modifier constants
     */
    const IN           = 'IN';
    const NOT_IN       = 'NOT_IN';
    const OR           = 'OR';
    const AND          = 'AND';
    const LIKE         = 'LIKE';
    const STARTS_WITH  = 'STARTS_WITH';
    const ENDS_WITH    = 'ENDS_WITH';

    /**
     * Columns and values
     */
    public array $columns = [];
    public array $values = [];

    /**
     * Default operator
     */
    public string $operator = self::OR;

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
        if(null !== $modifier)
        {
            $expression = new ExpressionLanguage();

            // HOOK: add custom expression language logic
            if (isset($GLOBALS['CEM_HOOKS']['parseQueryFragmentModifier']) && \is_array($GLOBALS['CEM_HOOKS']['parseQueryFragmentModifier']))
            {
                foreach ($GLOBALS['CEM_HOOKS']['parseQueryFragmentModifier'] as $callback)
                {
                    System::importStatic($callback[0])->{$callback[1]}($expression, $field, $operator, $value, $modifier);
                }
            }

            $this->columns[] = $expression->evaluate($modifier, [
                'field'     => $field,
                'value'     => $value,
                'operator'  => $operator,
                'context'   => $this      // ToDo: Exclude Expression Functions in its own class (escape, list, etc)?
            ]);
        }
        else
        {
            $this->columns[] = implode(" ", [$field, $operator, $value]);
        }

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

    public static function escape($v): string
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

    public static function list($v, $wrapStart = '(', $wrapEnd = ')', $escapeValue = true, $separator = ','): string
    {
        return $wrapStart . implode($separator, $escapeValue ? array_map(fn($val) => self::escape($val), $v) : $v) . $wrapEnd;
    }
}
