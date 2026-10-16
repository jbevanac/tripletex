<?php

namespace Tripletex\Helpers;

use Tripletex\Reference;

/**
 * Values are Tripletex vat type ids, which do not always match the vat number (LOW is number 33).
 */
enum VatTypeNorway: int
{
    case STANDARD = 3;
    case REDUCED = 31;
    case LOW = 32;
    case EXPORT = 52;

    public function toReference(): Reference
    {
        return new Reference($this->value);
    }
}
