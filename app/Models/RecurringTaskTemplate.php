<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskRecurEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
 * @property-read Collection<int, RecurringTaskTemplatePeriod> $periods
 * @property-read Collection<int, Task> $tasks
 *
 * @method static Builder|RecurringTaskTemplate query()
 */
class RecurringTaskTemplate extends Model
{

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
}
