<?php

namespace Tripletex\Query\Filters;

final class FieldsFilter extends AbstractStringableFilter
{

    protected function name(): string
    {
        return 'fields';
    }
}
