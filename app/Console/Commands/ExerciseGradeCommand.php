<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;
use Tests\ExerciseHintPrinter;
use Tests\ExercisePrinter;

/**
 * Class ExerciseGradeCommand
 * @package App\Console\Commands
 */
class ExerciseGradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "exercise:grade
                            {exercise_number : Pick a number, 1 - 10.}
                            {--hints : Nudges you toward the right solution. Don't use this unless you're stuck!}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grade your work on a specific exercise';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $validator = Validator::make($this->arguments(), [
            'exercise_number' => [
                'required',
                'integer',
                'between:1,10',
            ],
        ]);


        if ($validator->fails()) {
            $this->output->error('That is not a valid exercise number.');
            return -1;
        }


        $exerciseNumber = sprintf('%02d', $validator->validated()['exercise_number']);
        $exerciseTestPath = "tests/Exercises/Exercise{$exerciseNumber}/ExerciseTest.php";


        $exercisePrinter = $this->option('hints') ? ExerciseHintPrinter::class : ExercisePrinter::class;

        $process = (new Process(
            [PHP_BINARY, 'vendor/phpunit/phpunit/phpunit', $exerciseTestPath, "--printer=$exercisePrinter"],
        ));


        // output functional requirement and defensive sections using PHPUnit
        $result = $process->run(function ($type, $line) {
            $this->output->write($line);
        });



        return $result;
    }
}
