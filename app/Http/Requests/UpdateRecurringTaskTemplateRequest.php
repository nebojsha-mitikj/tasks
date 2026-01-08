<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskRecurEnum;
use App\Enums\WeekdayEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $title
 * @property string|null $description
 * @property TaskPriorityEnum $priority
 * @property TaskRecurEnum $recur
 * @property array<int, WeekdayEnum> $weekdays
 * @property array $label_ids
 */
class UpdateRecurringTaskTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'priority' => ['required', new Enum(TaskPriorityEnum::class)],
            'recur' => ['required', new Enum(TaskRecurEnum::class)],
            'weekdays' => [
                'nullable',
                'array',
                Rule::requiredIf(fn () => $this->input('recur') === TaskRecurEnum::WEEKLY->value),
                Rule::prohibitedIf(fn () => $this->input('recur') !== TaskRecurEnum::WEEKLY->value),
            ],
            'weekdays.*' => ['sometimes', new Enum(WeekdayEnum::class), 'distinct'],
            'label_ids' => ['present', 'array'],
            'label_ids.*' => [
                'integer',
                Rule::exists('labels', 'id')
                    ->where('user_id', $this->user()->id),
            ]
        ];
    }
}
