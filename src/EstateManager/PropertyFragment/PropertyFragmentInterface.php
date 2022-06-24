<?php

namespace ContaoEstateManager\EstateManager\EstateManager\PropertyFragment;


interface PropertyFragmentInterface
{
    /**
     * Generates a provider specific result
     */
    public function generate(array $columns, array $values);

    /**
     * Return parsed columns and values
     */
    public function parseFragment(QueryFragment $fragment): array;

    /**
     * Return operators of the provider
     */
    public function getOperator(string $operator): ?string;

    /**
     * Return modifiers of the provider
     *
     * Can be used to pass a modifier that changes the column parts using an ExpressionLanguage format string.
     *
     * Existing expression variables:
     *  field:    The column name
     *  value:    The value
     *  operator: The operator string
     *  context:  The context class to use functions from it like `context.escape()`
     */
    public function getModifier(string $operator): ?string;
}
