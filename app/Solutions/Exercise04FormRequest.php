<?php

declare(strict_types=1);

namespace App\Solutions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise04FormRequest
 * @package App\Solutions
 */
class Exercise04FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pencils' => [
                'required_without_all:pads,game_sheets',
                'boolean',
            ],
            'pads' => [
                'required_without_all:pencils,game_sheets',
                'boolean',
            ],
            'game_sheets' => [
                'required_without_all:pads,pencils',
                'boolean',
            ],
        ];
    }
}
