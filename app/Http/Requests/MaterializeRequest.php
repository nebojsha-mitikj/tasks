<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $date
 * @property string|null $status
 */
class MaterializeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'status' => ['nullable', new Enum(TaskStatusEnum::class)],
        ];
    }
}
