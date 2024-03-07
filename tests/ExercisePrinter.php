<?php

declare(strict_types=1);

namespace Tests;

use App\Console\ExerciseOutputFormatter;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestResult;
use PHPUnit\TextUI\ResultPrinter;
use Str;

/**
 * Class ExercisePrinter
 * @package Tests
 *
 * The exercise runner only allows grading one exercise at a time, and one exercise equates to one test class.
 * This constraint allows us to make a lot of assumptions in the printer.
 *
 * Note: this is not a general purpose printer, and is only useful for these exercises.
 */
class ExercisePrinter implements ResultPrinter
{
    use TestListenerDefaultImplementation;

    protected $parsedResults;
    protected $requirements;
    protected $printHints = false;

    public function printResult(TestResult $result): void
    {
        $this->parseRequirements($result);

        $formatter = new ExerciseOutputFormatter($this->requirements);

        print $formatter->getHeader();

        if ($result->errorCount() > 0) {
            // if an exception is thrown, we need to abort the test run and show the exception
            // without this, we'd see a bunch of test failures and it would be confusing

            print "\n\n  <bg=red;fg=white>This exercise cannot be graded.</> Please review the error details\n";
            print "  " . $result->errors()[0]->thrownException()->getMessage() . "\n";

            return;
        }

        $this->parsedResults = $this->parseTestResult($result);

        $functionalPassed = $this->gradeFunctionalResults();
        $defensivePassed = $this->gradeDefensiveResults();

        if ($functionalPassed && $defensivePassed) {
            print "\n  <options=bold><fg=green>Congrats!</></> All done with this exercise. Move on to the next one.\n";
        }
    }

    public function write(string $buffer): void
    {
        // no-op, keeping output tidy
    }

    protected function gradeFunctionalResults(): bool
    {
        return $this->gradeSection('Functional requirements', $this->requirements['functional']);
    }

    protected function gradeDefensiveResults(): bool
    {
        return $this->gradeSection('Defensive programming / data integrity', $this->requirements['defensive']);
    }

    protected function gradeSection(string $heading, array $requirements): bool
    {
        $reqOutput = '';
        $reqPassed = true;
        foreach ($requirements as $requirement => $tests) {
            $allHintsPassed = true;
            $hintOutput = '';
            foreach ($tests as $test => $hint) {
                if ($this->parsedResults[$test] === false) {
                    $allHintsPassed = false;
                }
                if ($this->printHints) {
                    $hintIcon = $this->parsedResults[$test] ? "<fg=green>✓</>" : "<fg=red>x</>";
                    $hintOutput .= "    $hintIcon $hint\n";
                }
            }

            if (!$allHintsPassed) {
                $reqPassed = false;
            }

            $icon = $allHintsPassed ? "<fg=green>✓</>" : "<fg=red>x</>";

            $reqOutput .= "  $icon $requirement\n";
            $reqOutput .= $hintOutput;
        }

        $status = $reqPassed ? "<bg=green;fg=white> PASS </>" : "<bg=red;fg=white> FAIL </>";
        print "\n  $status <options=bold>$heading</>\n\n";
        print $reqOutput;

        return $reqPassed;
    }

    protected function parseRequirements(TestResult $result): void
    {
        $this->requirements = $this->getTestClassName($result)::REQUIREMENTS;
    }

    protected function parseTestResult(TestResult $result): Collection
    {
        $failures = collect($result->failures())
            ->mapWithKeys(function ($i) {
                return [Str::after($i->getTestName(), '::') => false];
            });


        $testResultsKeyedByName = collect($result->passed())
            ->keys()
            ->map(function ($i, $k) {
                return $i;
            })
            ->mapWithKeys(function ($i) {
                return [Str::after($i, '::') => true];
            })
            ->merge($failures);



        return $testResultsKeyedByName;
    }

    protected function getTestClassName(TestResult $result): string
    {
        if (count($result->passed()) > 0) {
            $fullTestMethod = array_key_first($result->passed());
        } elseif (count($result->failures()) > 0) {
            $fullTestMethod = $result->failures()[0]->getTestName();
        } elseif (count($result->errors()) > 0) {
            $fullTestMethod = $result->errors()[0]->getTestName();
        }

        return Str::before($fullTestMethod, '::');
    }
}
