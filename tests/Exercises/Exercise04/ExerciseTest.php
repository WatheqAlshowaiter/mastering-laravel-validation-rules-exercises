<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise04;

use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise04
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-04';

    public const REQUIREMENTS = [
        'description' => 'Request game supplies',
        'request_fields' => [
            'pencils (checkbox)',
            'pads (checkbox)',
            'game_sheets (checkbox)',
        ],
        'database_fields' => [
            ['pencils', 'BIT'],
            ['pads', 'BIT'],
            ['game_sheets', 'BIT'],
        ],
        'functional' => [
            'User can request one, two, or all three types of game supplies' => [
                'testAtLeastOneIsRequired' => 'a user must pick at least one game supply',
            ],
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testPencilsBoolean' => 'pencils field is a boolean',
                'testPadsBoolean' => 'pencils field is a boolean',
                'testGameSheetsBoolean' => 'pencils field is a boolean',
            ],
        ],
    ];

    public function testAtLeastOneIsRequired(): void
    {
        $this->assertFieldIsRequiredWithoutAll('pencils', ['pads', 'game_sheets']);
        $this->assertFieldIsRequiredWithoutAll('pads', ['pencils', 'game_sheets']);
        $this->assertFieldIsRequiredWithoutAll('game_sheets', ['pads', 'pencils']);
    }

    public function testPencilsBoolean(): void
    {
        $this->assertFieldIsBoolean('pencils');
    }

    public function testPadsBoolean(): void
    {
        $this->assertFieldIsBoolean('pads');
    }

    public function testGameSheetsBoolean(): void
    {
        $this->assertFieldIsBoolean('game_sheets');
    }
}
