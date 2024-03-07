<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise01;

use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise01
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-01';

    public const REQUIREMENTS = [
        'description' => 'Allow students to start registration',
        'request_fields' => [
            'email (will send confirmation link, no DNS check needed)',
            'postal_code',
        ],
        'database_fields' => [
            ['email', 'VARCHAR(255)'],
            ['postal_code', 'VARCHAR(255)'],
        ],
        'functional' => [
            'Students must provide their school email address (.edu domain)' => [
                'testEmailRequired' => 'email field is required',
                'testEmailProperFormat' => 'email field must be formatted correctly',
                'testEmailEduTopLevelDomain' => 'email field must be from .edu top-level domain',
            ],
            'Student must provide a 5-digit US postal code' => [
                'testPostalCodeRequired' => 'postal_code field is required',
                'testPostalCodeLength' => 'postal_code field must be exactly 5 digits',
            ],
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testEmailString' => 'email field is a string',
            ],
            'Prevent database overflow' => [
                'testEmailLength' => 'email shouldn\'t allow a value too big for the database field',
            ],
        ],
    ];

    public function testEmailRequired(): void
    {
        $this->assertFieldIsRequired('email');
    }

    public function testEmailProperFormat(): void
    {
        $this->assertFieldIsEmail('email');
    }

    public function testEmailEduTopLevelDomain(): void
    {
        $this->assertFieldSuffix('email', '.edu');
    }

    public function testPostalCodeRequired(): void
    {
        $this->assertFieldIsRequired('postal_code');
    }

    public function testPostalCodeLength(): void
    {
        $this->assertFieldDigits('postal_code', 5);
    }

    public function testEmailString(): void
    {
        $this->assertFieldIsString('email');
    }

    public function testEmailLength(): void
    {
        $this->assertFieldExpectedMaxLength('email', 255);
    }
}
