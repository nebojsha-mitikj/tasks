<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\WeekdayEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $recurring_task_template_id
 * @property string $weekday
 *
 * Relationships
 * @property-read RecurringTaskTemplate $recurringTaskTemplate
 */
class RecurringTaskTemplateWeekday extends Model
{
    protected $table = 'recurring_task_template_weekdays';

    protected $fillable = [
        'recurring_task_template_id',
        'weekday',
    ];

    protected $casts = [
        'weekday' => WeekdayEnum::class,
    ];

    public function recurringTaskTemplate(): BelongsTo
    {
        return $this->belongsTo(RecurringTaskTemplate::class);
    }
}
