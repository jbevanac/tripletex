<?php

namespace Tripletex\Enum;

enum UserType: string
{
    case STANDARD = 'STANDARD';
    case EXTENDED = 'EXTENDED';
    case NO_ACCESS = 'NO_ACCESS';
}
