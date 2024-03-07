<?php

declare(strict_types=1);

namespace App\Solutions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise02FormRequest
 * @package App\Solutions
 */
class Exercise02FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                'string',
                'current_password',
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
