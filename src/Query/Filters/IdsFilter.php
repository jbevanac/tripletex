<?php

namespace Tripletex\Query\Filters;

final class IdsFilter extends AbstractStringAbleFilter
{

    protected function name(): string
    {
        return 'ids';
    }
}
