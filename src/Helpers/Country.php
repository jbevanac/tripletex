<?php

namespace Tripletex\Helpers;

use Tripletex\Reference;

enum Country: int
{
    case NORWAY = 161;

    public function toReference(): Reference
    {
        return new Reference($this->value);
    }
}
