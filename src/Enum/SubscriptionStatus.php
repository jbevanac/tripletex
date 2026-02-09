<?php

namespace Tripletex\Enum;

enum SubscriptionStatus: string
{
    case ACTIVE = 'ACTIVE';
    case DISABLED = 'DISABLED';
    case DISABLED_TOO_MANY_ERRORS = 'DISABLED_TOO_MANY_ERRORS';
    case DISABLED_RATE_LIMIT_EXCEEDED = 'DISABLED_RATE_LIMIT_EXCEEDED';
    case DISABLED_MISUSE = 'DISABLED_MISUSE';
}