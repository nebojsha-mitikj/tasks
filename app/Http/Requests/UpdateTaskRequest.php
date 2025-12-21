<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TaskPriorityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $title
 * @property string|null $description
 * @property string $date
 * @property TaskPriorityEnum $priority
 */
class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'priority' => ['required', new Enum(TaskPriorityEnum::class)]
        ];
    }
}
