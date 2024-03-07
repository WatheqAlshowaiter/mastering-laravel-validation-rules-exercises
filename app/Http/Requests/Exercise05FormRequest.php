<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\SkillPosting;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Exercise05FormRequest
 * @package App\Http\Requests
 *
 * Note: to see the requirements for this exercise, run `php artisan exercise:show 5` in your console.
 *
 * @see SkillPosting
 */
class Exercise05FormRequest extends FormRequest
{
    // You can find a list of valid categories in /app/Models/SkillPosting.php
    public function rules(): array
    {
        //     Functional requirements
        //     * One of the categories should be designated as the primary category
        //     * A skill can be offered onsite, remote, or both

        return [
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'categories' => [
                'required',
                'array',
                'min:1',
                Rule::in(SkillPosting::VALID_CATEGORIES),
            ],
            'categories.*' => [
                'string',
                'distinct',
            ],
            'primary_category' => [
                'required',
                'string',
                'in_array:categories',
            ],
            'is_remote' => [
                'required_without:is_onsite',
                'boolean'
            ],
            'is_onsite' => [
                'required_without:is_remote',
                'boolean'
            ],
            'minimum_rate' => [
                'required',
                'integer',
                'between:0,65535',
            ],
            'maximum_rate' => [
                'required',
                'integer',
                'between:0,65535',
                'gte:minimum_rate',
            ],

        ];
    }
}
