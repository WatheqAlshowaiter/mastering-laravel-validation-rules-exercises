<?php

declare(strict_types=1);

namespace App\Solutions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise06FormRequest
 * @package App\Solutions
 */
class Exercise06FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'workflow_type' => [
                'required',
                'string',
                'in:shipping,receiving',
            ],
            'processed_date' => [
                'required',
                'string',
                'date_format:Y-m-d',
                'before_or_equal:today',
            ],
            'waybill_number' => [
                'required',
                'string',
                'max:255',
            ],
            'is_damaged' => [
                'prohibited_unless:workflow_type,receiving',
                'boolean',
            ],
            'damage_description' => [
                'required_if:is_damaged,1',
                'string',
                'max:1500',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1500',
            ],
        ];
    }
}
