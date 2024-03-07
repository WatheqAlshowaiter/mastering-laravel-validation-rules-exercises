<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise03;

use App\Models\Season;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise03
 */
class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE = 'exercise-03';

    public const REQUIREMENTS = [
        'description' => 'Create a new tournament season',
        'request_fields' => [
            'name',
            'number_scores (how many scores to use for tournament ranking)',
            'start_date (native date picker, like 2021-12-31)',
            'end_date (native date picker, like 2021-12-31)',
        ],
        'database_fields' => [
            ['name', 'VARCHAR(64)'],
            ['number_scores', 'SMALLINT UNSIGNED'],
            ['start_date', 'DATE'],
            ['end_date', 'DATE'],
        ],
        'functional' => [
            'Season must have a unique name in the seasons table' => [
                'testNameRequired' => 'name field is required',
                'testNameUnique' => 'name field must be unique'
            ],
            'Define how many scores are used for ranking' => [
                'testNumberScoresRequired' => 'number_scores field is required',
                'testNumberScoresRange' => 'number_scores should be at least 1',
            ],
            'Season must have a start and end date and be at least 1 day long' => [
                'testStartDateRequired' => 'start_date field is required',
                'testEndDateRequired' => 'end_date field is required',
                'testStartDateRange' => 'season must be at least 1 day long',
            ],
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testNameString' => 'name field is a string',
                'testNumberScoresInteger' => 'number_scores field is an integer',
                'testStartDateString' => 'start_date field is a string',
                'testStartDateIsValidFormat' => 'start_date field must be in expected format',
                'testEndDateString' => 'end_date field is a string',
                'testEndDateIsValidFormat' => 'end_date field must be in expected format',
            ],
            'Prevent database overflow' => [
                'testNameLength' => 'name shouldn\'t allow a value too big for the database field',
                'testNumberScoresRange' => 'number_scores must fit in an unsigned smallint field',
            ],
        ],
    ];

    public function testNameRequired(): void
    {
        $this->assertFieldIsRequired('name');
    }

    public function testNameUnique(): void
    {
        Season::factory()->create(['name' => 'existing-name']);
        $this->assertFieldIsUnique('name', 'existing-name');
    }

    public function testNumberScoresRequired(): void
    {
        $this->assertFieldIsRequired('number_scores');
    }

    public function testNumberScoresRange(): void
    {
        $this->assertFieldIsBetweenIntegers('number_scores', 1, 65535);
    }

    public function testStartDateRequired(): void
    {
        $this->assertFieldIsRequired('start_date');
    }

    public function testEndDateRequired(): void
    {
        $this->assertFieldIsRequired('end_date');
    }

    public function testStartDateRange(): void
    {
        $this->assertFieldIsAfterOtherDateField('end_date', 'start_date');
    }

    public function testNameString(): void
    {
        $this->assertFieldIsString('name');
    }

    public function testNumberScoresInteger(): void
    {
        $this->assertFieldIsInteger('number_scores');
    }

    public function testStartDateString(): void
    {
        $this->assertFieldIsString('start_date');
    }

    public function testStartDateIsValidFormat(): void
    {
        $this->assertFieldHasDateFormat('start_date', 'Y-m-d');
    }

    public function testEndDateString(): void
    {
        $this->assertFieldIsString('end_date');
    }

    public function testEndDateIsValidFormat(): void
    {
        $this->assertFieldHasDateFormat('end_date', 'Y-m-d');
    }

    public function testNameLength(): void
    {
        $this->assertFieldExpectedMaxLength('name', 64);
    }
}
