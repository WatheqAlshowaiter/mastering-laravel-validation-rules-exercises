<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise09;

use App\Http\Requests\Exercise09FormRequest;
use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise09
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-09';

    public const REQUIREMENTS = [
        'description' => 'Register a team with captain and players',
        'request_fields' => [
            'name',
            'players (an array, one row per player)',
            'players[first_name]',
            'players[last_name]',
            'players[email]',
            'players[phone]',
        ],
        'database_fields' => [
            ['team.name', 'VARCHAR(255)'],
            ['players.first_name', 'VARCHAR(255)'],
            ['players.last_name', 'VARCHAR(255)'],
            ['players.email', 'VARCHAR(255)'],
            ['players.phone', 'VARCHAR(255)'],
        ],
        'functional' => [
            'Team must have a name' => [
                'testNameRequired' => 'name is required',
            ],
            'Team must have at least one player' => [
                'testPlayersRequired' => 'players array is required',
            ],
            'Each player must have first name, last name, and email' => [
                'testFirstNameRequired' => 'player first name is required',
                'testLastNameRequired' => 'player last name is required',
                'testEmailRequired' => 'player email is required',
            ],
            'Each player must have a valid format for email' => [
                'testEmailFormat' => 'player email is not the right format',
            ],
            'The first player must have a phone number, rest of players it is optional' => [
                'testCaptainPhoneRequired' => 'captain phone number is required',
                'testPlayerPhoneNullable' => 'player phone numbers are optional',
            ],
            'If a phone number is provided, it must be in the format 111-111-1111' => [
                'testPhoneRegex' => 'phone number must be formatted as 111-111-1111',
            ]
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testNameString' => 'name field is a string',
                'testPlayersArray' => 'players field is an array',
                'testFirstNameString' => 'player first name is a string',
                'testLastNameString' => 'player last name is a string',
                'testEmailString' => 'player email is a string',
                'testPhoneString' => 'player phone is a string',
            ],
            'Prevent database overflow' => [
                'testNameLength' => 'name shouldn\'t allow a value too big for the database field',
                'testFirstNameLength' => 'player first name shouldn\'t allow a value too big for the database field',
                'testLastNameLength' => 'player last name shouldn\'t allow a value too big for the database field',
                'testEmailLength' => 'player email shouldn\'t allow a value too big for the database field',
            ],
        ],
    ];

    public function testNameRequired(): void
    {
        $this->assertFieldIsRequired('name');
    }

    public function testPlayersRequired(): void
    {
        $this->assertFieldIsRequired('players');
    }

    public function testFirstNameRequired(): void
    {
        $this->assertArrayFieldIsRequired('players', 'first_name');
    }

    public function testLastNameRequired(): void
    {
        $this->assertArrayFieldIsRequired('players', 'last_name');
    }

    public function testEmailRequired(): void
    {
        $this->assertArrayFieldIsRequired('players', 'email');
    }

    public function testEmailFormat(): void
    {
        $this->assertArrayFieldIsEmail('players', 'email');
    }

    public function testCaptainPhoneRequired(): void
    {
        $this->assertArrayFieldIsRequired('players', 'phone');
    }

    public function testPlayerPhoneNullable(): void
    {
        $rules = (new Exercise09FormRequest())->rules();

        $this->assertFieldHasRule('players.*.phone', $rules, 'nullable');
    }

    public function testPhoneRegex(): void
    {
        $this->assertArrayFieldIsRegex('players', 'phone');
    }

    public function testNameString(): void
    {
        $this->assertFieldIsString('name');
    }

    public function testPlayersArray(): void
    {
        $this->assertFieldIsArray('players');
    }

    public function testFirstNameString(): void
    {
        $this->assertArrayFieldIsString('players', 'first_name');
    }

    public function testLastNameString(): void
    {
        $this->assertArrayFieldIsString('players', 'last_name');
    }

    public function testEmailString(): void
    {
        $this->assertArrayFieldIsString('players', 'email');
    }

    public function testPhoneString(): void
    {
        $this->assertArrayFieldIsString('players', 'phone');
    }

    public function testNameLength(): void
    {
        $this->assertFieldExpectedMaxLength('name', 255);
    }

    public function testFirstNameLength(): void
    {
        $this->assertArrayFieldExpectedMaxLength('players', 'first_name', 255);
    }

    public function testLastNameLength(): void
    {
        $this->assertArrayFieldExpectedMaxLength('players', 'last_name', 255);
    }

    public function testEmailLength(): void
    {
        $this->assertArrayFieldExpectedMaxLength('players', 'email', 255);
    }
}
