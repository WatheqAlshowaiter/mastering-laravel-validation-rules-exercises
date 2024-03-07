<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\SkillPosting;
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
        return [];
    }
}
