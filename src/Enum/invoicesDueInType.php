<?php

namespace Tripletex\Enum;

enum invoicesDueInType: string
{
    case DAYS = 'DAYS';
    case MONTHS = 'MONTHS';
    case RECURRING_DAY_OF_MONTH = 'RECURRING_DAY_OF_MONTH';
}
