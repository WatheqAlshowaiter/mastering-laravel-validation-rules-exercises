<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise02FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 2` in your console.
 *
 */
class Exercise02FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_password'=> [
                'required',
                'string',
                'current_password'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }
}
