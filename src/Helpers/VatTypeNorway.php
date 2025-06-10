<?php

namespace Tripletex\Helpers;

use Tripletex\Reference;

enum VatTypeNorway: int
{
    case STANDARD = 3;
    case REDUCED = 31;
    case LOW = 32;

    public function toReference(): Reference
    {
        return new Reference($this->value);
    }
}
