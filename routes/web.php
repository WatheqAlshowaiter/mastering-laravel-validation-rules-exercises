<?php

use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/exercise-01', [ExerciseController::class, 'exercise01'])->name('exercise-01');
Route::post('/exercise-02', [ExerciseController::class, 'exercise02'])->name('exercise-02');
Route::post('/exercise-03', [ExerciseController::class, 'exercise03'])->name('exercise-03');
Route::post('/exercise-04', [ExerciseController::class, 'exercise04'])->name('exercise-04');
Route::post('/exercise-05', [ExerciseController::class, 'exercise05'])->name('exercise-05');
Route::post('/exercise-06', [ExerciseController::class, 'exercise06'])->name('exercise-06');
Route::post('/exercise-07', [ExerciseController::class, 'exercise07'])->name('exercise-07');
Route::post('/exercise-08', [ExerciseController::class, 'exercise08'])->name('exercise-08');
Route::post('/exercise-09', [ExerciseController::class, 'exercise09'])->name('exercise-09');
Route::post('/exercise-10', [ExerciseController::class, 'exercise10'])->name('exercise-10');
