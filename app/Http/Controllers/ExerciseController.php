<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Exercise01FormRequest;
use App\Http\Requests\Exercise02FormRequest;
use App\Http\Requests\Exercise03FormRequest;
use App\Http\Requests\Exercise04FormRequest;
use App\Http\Requests\Exercise05FormRequest;
use App\Http\Requests\Exercise06FormRequest;
use App\Http\Requests\Exercise07FormRequest;
use App\Http\Requests\Exercise08FormRequest;
use App\Http\Requests\Exercise09FormRequest;
use App\Http\Requests\Exercise10FormRequest;

/**
 * Class ExerciseController
 * @package App\Http\Controllers
 *
 * Note: Controller logic is outside the scope of the exercises, so these are just placeholders to allow the form
 *       request validation to be evaluated. In a real app, we'd never shove this many methods on a controller either.
 */
class ExerciseController extends Controller
{
    public function exercise01(Exercise01FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise02(Exercise02FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise03(Exercise03FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise04(Exercise04FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise05(Exercise05FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise06(Exercise06FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise07(Exercise07FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise08(Exercise08FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise09(Exercise09FormRequest $request): string
    {
        return 'ok';
    }

    public function exercise10(Exercise10FormRequest $request): string
    {
        return 'ok';
    }
}
