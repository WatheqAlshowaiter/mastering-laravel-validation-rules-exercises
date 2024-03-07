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
        return [];
    }
}
