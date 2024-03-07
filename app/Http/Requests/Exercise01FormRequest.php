<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise01FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 1` in your console.
 */
class Exercise01FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'string',
                'max:255',
                'ends_with:.edu',
            ],
            'postal_code' => [
                'required',
                'string',
                'max:255',
                'digits:5'
            ],
        ];
    }
}
