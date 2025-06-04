<?php

namespace Tripletex\Enum;

enum SubscriptionInvoicingTimeInAdvanceOrArrears: string
{
    case ADVANCE = 'ADVANCE';
    case ARREARS = 'ARREARS';
}
