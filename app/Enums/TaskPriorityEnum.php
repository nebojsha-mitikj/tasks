<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumValues;

enum TaskPriorityEnum: string
{
    use EnumValues;
    case NONE = 'none';
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public static function ordered(): array
    {
        return [
            self::HIGH->value,
            self::MEDIUM->value,
            self::LOW->value,
            self::NONE->value,
        ];
    }
}
