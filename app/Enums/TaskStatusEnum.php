<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum TaskStatusEnum: string
{
    use EnumValues;
    CASE TO_DO = 'to-do';
    case IN_PROGRESS = 'in-progress';
    case COMPLETED = 'completed';
}
