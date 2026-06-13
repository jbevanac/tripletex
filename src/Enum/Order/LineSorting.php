<?php

namespace Tripletex\Enum\Order;

enum LineSorting: string
{
    case ID = 'ID';
    case PRODUCT = 'PRODUCT';
    case CUSTOM = 'CUSTOM';
    case MANUAL = 'MANUAL';
}
