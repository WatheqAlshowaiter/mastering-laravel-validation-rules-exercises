<?php

declare(strict_types=1);

namespace App\Solutions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class Exercise10FormRequest
 * @package App\Solutions
 */
class Exercise10FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'schedule_type' => [
                'required',
                Rule::in(['date', 'days']),
            ],
            'date' => [
                'required_if:schedule_type,date',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
            'days' => [
                'required_if:schedule_type,days',
                'array',
            ],
            'days.*' => [
                'integer',
                'between:1,7',
                'distinct',
            ]
        ];
    }
}
