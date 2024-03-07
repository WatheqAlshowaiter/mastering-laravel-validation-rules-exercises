<?php

declare(strict_types=1);

namespace App\Solutions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise01FormRequest
 * @package App\Solutions
 */
class Exercise01FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'ends_with:.edu',
                'max:255',
            ],
            'postal_code' => [
                'required',
                'digits:5',
            ],
        ];
    }
}
