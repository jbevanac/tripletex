<?php

namespace Tripletex\Enum;

enum InvoiceSendMethod: string
{
    case EMAIL = 'EMAIL';
    case EHF = 'EHF';
    case EFAKTURA = 'EFAKTURA';
    case AVTALEGIRO = 'AVTALEGIRO';
    case VIPPS = 'VIPPS';
    case MANUAL = 'MANUAL';
}
