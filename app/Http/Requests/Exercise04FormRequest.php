<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise04FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 4` in your console.
 *
 */
class Exercise04FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pencils' => [
                'boolean',
                'required_without_all:pads,game_sheets'
            ],
            'pads' => [
                'boolean',
                'required_without_all:pencils,game_sheets'
            ],
            'game_sheets' => [
                'boolean',
                'required_without_all:pads,pencils'
            ],
        ];
    }
}
