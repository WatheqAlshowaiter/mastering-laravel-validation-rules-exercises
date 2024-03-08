<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise08FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 8` in your console.
 *
 */
class Exercise08FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'teams' => [
                'required',
                'array',
            ],
            'teams.*.player_count' => [
                'required',
                'integer',
                'between:1,255',
            ],
            'teams.*.team_name' => [
                'required',
                'string',
                'max:255',
            ],
            'teams.*.q1_points' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'teams.*.q2_points' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'teams.*.q3_points' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'teams.*.bonus_points' => [
                'required',
                'integer',
                'between:0,50',
            ],
        ];
    }
}
