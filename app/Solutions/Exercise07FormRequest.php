<?php

declare(strict_types=1);

namespace App\Solutions;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class Exercise07FormRequest
 * @package App\Solutions
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
                    ->where(function (Builder $query) {
                        $query->whereDate('event_date', '=', Carbon::today());
                    }),
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
