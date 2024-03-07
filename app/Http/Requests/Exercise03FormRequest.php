<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise03FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 3` in your console.
 *
 */
class Exercise03FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:64',
                'unique:seasons',
            ],
            'number_scores' => [
                'required',
                'int',
                'between:1,65535',
            ],
            'start_date' => [
                'required',
                'string',
                'date_format:Y-m-d',
            ],
            'end_date' => [
                'required',
                'string',
                'date_format:Y-m-d',
                'after:start_date',
            ],
        ];
    }
}
