<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $recurring_task_template_id
 * @property string $title
 * @property string|null $description
 * @property Carbon $date
 * @property TaskStatusEnum $status
 * @property TaskPriorityEnum $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * Relationships
 * @property-read User $user
 * @property-read RecurringTaskTemplate|null $recurringTaskTemplate
 * @property-read Collection<int, Label> $labels
 *
 * @method static Builder|Task query()
 */
class Task extends Model
{

    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'recurring_task_template_id',
        'title',
        'description',
        'date',
        'status',
        'priority'
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recurringTaskTemplate(): BelongsTo
    {
        return $this->belongsTo(RecurringTaskTemplate::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_task')
            ->withTimestamps();
    }


}
