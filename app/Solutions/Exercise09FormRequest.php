<?php

declare(strict_types=1);

namespace App\Solutions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise09FormRequest
 * @package App\Solutions
 */
class Exercise09FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'players' => [
                'required',
                'array',
            ],
            'players.*.first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'players.*.last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'players.*.email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'players.0.phone' => [
                'required',
            ],
            'players.*.phone' => [
                'nullable',
                'string',
                'regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',
            ]
        ];
    }
}
