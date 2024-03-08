<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise10FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 10` in your console.
 *
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

            'schedule_type'=>[
                'required',
                'string',
                'max:255',
                'in:date,days'
            ],
            'date'=>[
                'required_if:schedule_type,date',
                'string',
                'max:255',
                'date_format:Y-m-d',
                'after_or_equal:today'
            ],
            'days'=>[
                'required_if:schedule_type,days',
                'array',
            ],
            'days.*'=>[
                'integer',
                'distinct',
                'between:1,7'
            ]
        ];
    }
}
