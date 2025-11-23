<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumValues;

enum TaskRecurEnum: string
{
    use EnumValues;
    case DAILY = 'daily';
    case WEEKDAYS = 'weekdays';
    case WEEKENDS = 'weekends';
}
