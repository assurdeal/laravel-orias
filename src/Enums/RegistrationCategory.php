<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Enums;

enum RegistrationCategory: string
{
    case COA = 'COA';
    case AGA = 'AGA';
    case MA = 'MA';
    case MIA = 'MIA';
}
