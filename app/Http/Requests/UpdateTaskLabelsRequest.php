<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property array $label_ids
 */
class UpdateTaskLabelsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label_ids' => ['present', 'array'],
            'label_ids.*' => [
                'integer',
                Rule::exists('labels', 'id')
                    ->where('user_id', $this->user()->id),
            ],
        ];
    }
}
