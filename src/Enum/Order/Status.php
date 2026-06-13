<?php

namespace Tripletex\Enum\Order;

// Logistics only — verify these 10 values against the OpenAPI spec
enum Status: string
{
    case NONE = 'NONE';
    case OPEN = 'OPEN';
    case APPROVED = 'APPROVED';
    case CONFIRMED = 'CONFIRMED';
    case BACK_ORDER_READY = 'BACK_ORDER_READY';
    case DEVIATION_DETECTED = 'DEVIATION_DETECTED';
    case DEVIATION_OPEN = 'DEVIATION_OPEN';
    case DEVIATION_CLOSED = 'DEVIATION_CLOSED';
    case READY_FOR_SHIPPING = 'READY_FOR_SHIPPING';
    case SHIPPED = 'SHIPPED';
}
