<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise10;

use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise10
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-10';

    public const REQUIREMENTS = [
        'description' => 'Create a scheduled task',
        'request_fields' => [
            'title',
            'schedule_type',
            'date (native date picker, like 2021-12-31)',
            'days[]',
        ],
        'database_fields' => [
            ['title', 'VARCHAR(255)'],
            ['schedule_type', 'VARCHAR(255)'],
            ['scheduled_date', 'DATE'],
            ['scheduled_days', 'VARCHAR(255)'],
        ],
        'functional' => [
            'Task must contain a title' => [
                'testTitleRequired' => 'title field is required',
            ],
            'Task must be scheduled for a specific date or any week day' => [
                'testScheduleTypeRequired' => 'schedule_type field is required',
                'testScheduleTypeExpectedValues' => 'schedule_type field rejects unexpected values',
                'testDateRequiredIfScheduleTypeIsDate' => 'date field is required if schedule_type field is date',
                'testDaysRequiredIfScheduleTypeIsDays' => 'days field is required if schedule_type field is days',
            ],
            'Task must not be in the past' => [
                'testDateIsInCorrectRange' => 'date cannot be before today',
            ],
            'Task days option must specify at least one day' => [
                'testDaysIsArray' => 'days should be an array',
            ],
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testTitleString' => 'title field is a string',
                'testDateIsValidFormat' => 'date field must be in expected format',
                'testEachDayIsInteger' => 'each day must be an integer',
                'testEachDayIsInRange' => 'each day must be between 1 and 7',
                'testEachDayIsDistinct' => 'each day must be unique',
            ],
            'Prevent database overflow' => [
                'testTitleLength' => 'title shouldn\'t allow a value too big for the database field',
            ],
        ],
    ];

    public function testTitleRequired(): void
    {
        $this->assertFieldIsRequired('title');
    }

    public function testScheduleTypeRequired(): void
    {
        $this->assertFieldIsRequired('schedule_type');
    }

    public function testScheduleTypeExpectedValues(): void
    {
        $this->assertFieldRejectsValue('schedule_type', 'xyz');
    }

    public function testDateRequiredIfScheduleTypeIsDate(): void
    {
        $this->assertFieldIsRequiredIf('date', 'schedule_type', 'date');
    }

    public function testDateIsValidFormat(): void
    {
        $this->assertFieldHasDateFormat('date', 'Y-m-d');
    }

    public function testDateIsInCorrectRange(): void
    {
        $this->assertFieldIsAfterEqualDate('date', 'today');
    }

    public function testDaysRequiredIfScheduleTypeIsDays(): void
    {
        $this->assertFieldIsRequiredIf('days', 'schedule_type', 'days');
    }

    public function testDaysIsArray(): void
    {
        $this->assertFieldIsArray('days');
    }

    public function testEachDayIsInteger(): void
    {
        $this->assertArrayValuesAreIntegers('days');
    }

    public function testEachDayIsInRange(): void
    {
        $this->assertArrayValuesAreBetweenIntegers('days', 1, 7);
    }

    public function testEachDayIsDistinct(): void
    {
        $this->assertArrayIntegersAreDistinct('days');
    }

    public function testTitleString(): void
    {
        $this->assertFieldIsString('title');
    }

    public function testTitleLength(): void
    {
        $this->assertFieldExpectedMaxLength('title', 255);
    }
}
