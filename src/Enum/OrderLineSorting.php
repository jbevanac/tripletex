<?php

namespace Tripletex\Enum;

// Verify these 4 values against the OpenAPI spec
enum OrderLineSorting: string
{
    case ID = 'ID';
    case PRODUCT = 'PRODUCT';
    case CUSTOM = 'CUSTOM';
    case MANUAL = 'MANUAL';
}
