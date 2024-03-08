<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise07FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 7` in your console.
 *
 */
class Exercise07FormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'participant_code' => [
                'bail',
                'required',
                'string',
                'size:4',
                'alpha',
                Rule::exists('games', 'participant_code')
                    ->where(
                        fn ($query) =>
                        $query->whereDate('event_date', today())
                    ),
            ],
            'team_id' => [
                'bail',
                'nullable',
                'integer',
                'exists:teams,id',
            ],
            'team_name' => [
                'required',
                'string',
                'max:255',
            ],
            'players' => [
                'required',
                'integer',
                'between:1,255',
            ],
            'accept_terms' => [
                'accepted',
            ],
        ];
    }
}
