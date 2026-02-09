<?php

namespace Tripletex\Query\Filters;

final class FieldsFilter extends AbstractStringAbleFilter
{

    protected function name(): string
    {
        return 'fields';
    }
}
