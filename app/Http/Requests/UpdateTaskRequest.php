<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $title
 * @property string|null $description
 * @property string $date
 * @property TaskStatusEnum $status
 * @property TaskPriorityEnum $priority
 */
class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'status' => ['required', new Enum(TaskStatusEnum::class)],
            'priority' => ['required', new Enum(TaskPriorityEnum::class)]
        ];
    }
}
