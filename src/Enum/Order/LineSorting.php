<?php

namespace Tripletex\Enum\Order;

// Verify these 4 values against the OpenAPI spec
enum LineSorting: string
{
    case ID = 'ID';
    case PRODUCT = 'PRODUCT';
    case CUSTOM = 'CUSTOM';
    case MANUAL = 'MANUAL';
}
