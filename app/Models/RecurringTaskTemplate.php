<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskRecurEnum;
use App\Enums\WeekdayEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property TaskRecurEnum $recur
 * @property TaskPriorityEnum $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * Relationships
 * @property-read User $user
 * @property-read Collection<int, RecurringTaskTemplateWeekday> $weekdays
 * @property-read Collection<int, RecurringTaskTemplatePeriod> $periods
 * @property-read Collection<int, Task> $tasks
 * @property-read Collection<int, Label> $labels
 *
 * @method static Builder|RecurringTaskTemplate query()
 */
class RecurringTaskTemplate extends Model
{
    protected $appends = ['is_active'];

    protected $table = 'recurring_task_templates';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'recur',
        'priority',
    ];

    protected $casts = [
        'recur' => TaskRecurEnum::class,
        'priority' => TaskPriorityEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function periods(): HasMany
    {
        return $this->hasMany(RecurringTaskTemplatePeriod::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_recurring_task_template')
            ->withTimestamps();
    }

    public function weekdays(): HasMany
    {
        return $this->hasMany(RecurringTaskTemplateWeekday::class);
    }

    public function syncWeekdays(array $weekdays): void
    {
        $this->weekdays()->delete();
        if ($this->recur !== TaskRecurEnum::WEEKLY) {
            return;
        }
        foreach ($weekdays as $weekday) {
            $this->weekdays()->create(['weekday' => $weekday]);
        }
    }

    public function saveFromPayload(array $data): void
    {
        $labelIds = $data['label_ids'] ?? [];
        $weekdays = $data['weekdays'] ?? [];
        unset($data['label_ids'], $data['weekdays']);

        $this->fill($data)->save();

        $this->labels()->sync($labelIds);
        $this->syncWeekdays($weekdays);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereHas('periods', function ($query) {
            $query->whereNull('end_date');
        });
    }

    public function scopeBelongsToUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->periods()->whereNull('end_date')->exists();
    }

    public function isDueOnDate(Carbon $date): bool
    {
        return match ($this->recur) {
            TaskRecurEnum::DAILY => true,
            TaskRecurEnum::WEEKDAYS => $date->isWeekday(),
            TaskRecurEnum::WEEKENDS => $date->isWeekend(),
            TaskRecurEnum::WEEKLY => $this->weekdays
                ->pluck('weekday')
                ->contains(WeekdayEnum::from(strtolower($date->englishDayOfWeek))),
        };
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc');
    }

}
