<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\ExerciseOutputFormatter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ExerciseShowCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercise:show {exercise_number : Pick a number, 1 - 10.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'See the requirements for a specific exercise';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
        $exerciseTestClass = "Tests\\Exercises\\Exercise{$exerciseNumber}\\ExerciseTest";
        $exerciseRequest = "app/Http/Requests/Exercise{$exerciseNumber}FormRequest.php";

        $requirements = $exerciseTestClass::REQUIREMENTS;
        $formatter = new ExerciseOutputFormatter($requirements);

        $this->output->write($formatter->getHeader());

        $this->output->write("\n  <options=bold>Functional requirements</>\n");
        foreach ($requirements['functional'] as $requirement => $hints) {
            $this->output->write("    * $requirement\n");
        }

        $this->output->write("\n  <options=bold>Request fields</>\n");
        foreach ($requirements['request_fields'] as $field) {
            $this->output->write("    * $field\n");
        }

        $this->output->write("\n  <options=bold>Database fields</>\n");
        $this->output->table(['Field', 'Type'], $requirements['database_fields']);

        $this->output->write("  <info>Open $exerciseRequest to begin</info>\n");
    }
}
