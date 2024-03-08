<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise09FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 9` in your console.
 *
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
            'players'=>[
                'required',
                'array',
            ],
            'players.*.first_name'=>[
                'required',
                'string',
                'max:255',
            ],
            'players.*.last_name'=>[
                'required',
                'string',
                'max:255',
            ],
            'players.*.email'=>[
                'required',
                'string',
                'email',
                'max:255',
            ],
            'players.0.phone' => [
                'required',
            ],
            'players.*.phone'=>[
                'nullable',
                'string',
                'max:255',
                'regex:/^\d{3}-\d{3}-\d{4}$/'
            ],
        ];
    }
}
