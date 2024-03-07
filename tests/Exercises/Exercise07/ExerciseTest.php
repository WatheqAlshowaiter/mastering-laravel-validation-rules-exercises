<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise07;

use App\Http\Requests\Exercise07FormRequest;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise07
 */
class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE = 'exercise-07';

    public const REQUIREMENTS = [
        'description' => 'Allow in-person registration for trivia game',
        'request_fields' => [
            'participant_code (4-letter code for this game given out in person by the trivia host)',
            'team_id (ID number for teams that are registered with the trivia league)',
            'team_name',
            'players (how many players on the team)',
            'accept_terms (checkbox they must check to play)',
        ],
        'database_fields' => [
            ['team_id', 'INT UNSIGNED'],
            ['team_name', 'VARCHAR(255)'],
            ['players', 'TINYINT UNSIGNED'],
            ['game.participant_code', 'CHAR(4)'],
            ['game.event_date', 'DATE'],
            ['team.id', 'INT UNSIGNED'],
        ],
        'functional' => [
            'Participant code must match a game being played today' => [
                'testParticipantCodeRequired' => 'participant_code is required',
                'testParticipantCodeLength' => 'participant_code is exactly 4 characters',
                'testParticipantCodeAlpha' => 'participant_code can only be letters',
                'testParticipantCodeExists' => 'participant_code must match an existing game',
                'testParticipantCodeMatchesToday' => 'participant_code must match a game being played today',
            ],
            'If a Team ID is provided, it must match a registered league team' => [
                'testTeamIdNullable' => 'team_id should be optional',
                'testTeamIdExists' => 'team_id must match a registered league team',
            ],
            'Registration must include a team name' => [
                'testTeamNameRequired' => 'team_name is required',
            ],
            'Registration must include how many people are playing' => [
                'testPlayersRequired' => 'players is required',
                'testPlayersRange' => 'must be at least one player'
            ],
            'Registration must include acceptance of terms' => [
                'testAcceptTermsAccepted' => 'accept_terms must be checked',
            ]
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testParticipantCodeString' => 'participant_code field is a string',
                'testTeamIdInteger' => 'team_id field is an integer',
                'testTeamNameString' => 'team_name field is a string',
                'testPlayersInteger' => 'players field is an integer',
            ],
            'Prevent database overflow' => [
                'testTeamNameLength' => 'team_name shouldn\'t allow a value too big for the database field',
                'testPlayersRange' => 'players must fit in an unsigned tinyint field',
            ],
            'Bail early to avoid unnecessary database calls' => [
                'testParticipantCodeBails' => 'participant_code will make a database call',
                'testTeamIdBails' => 'team_id validation will make a database call',
            ],
        ],
    ];

    public function testParticipantCodeRequired(): void
    {
        $this->assertFieldIsRequired('participant_code');
    }

    public function testParticipantCodeLength(): void
    {
        $this->assertFieldSize('participant_code', 4);
    }

    public function testParticipantCodeAlpha(): void
    {
        $this->assertFieldAlpha('participant_code', '1234');
    }

    public function testParticipantCodeExists(): void
    {
        Game::factory()->create([
            'participant_code' => 'xxxx',
            // factory sets event_date to today by default
        ]);

        $this->assertFieldWillFailExistsCheck('participant_code', 'aaaa');
    }

    public function testParticipantCodeMatchesToday(): void
    {
        Game::factory()->create([
            'participant_code' => 'yyyy',
            'event_date' => '2000-01-15',
        ]);

        $this->assertFieldWillFailExistsCheck('participant_code', 'yyyy');
    }

    public function testTeamIdNullable(): void
    {
        $rules = (new Exercise07FormRequest())->rules();

        $this->assertFieldHasRule('team_id', $rules, 'nullable');
    }

    public function testTeamIdExists(): void
    {
        Team::factory()->create([
            'id' => 555,
        ]);

        $this->assertFieldWillFailExistsCheck('team_id', '111');
    }

    public function testTeamNameRequired(): void
    {
        $this->assertFieldIsRequired('team_name');
    }

    public function testPlayersRequired(): void
    {
        $this->assertFieldIsRequired('players');
    }

    public function testAcceptTermsAccepted(): void
    {
        $this->assertFieldAccepted('accept_terms');
    }

    public function testParticipantCodeString(): void
    {
        $this->assertFieldIsString('participant_code');
    }

    public function testTeamIdInteger(): void
    {
        $this->assertFieldIsInteger('team_id');
    }

    public function testPlayersInteger(): void
    {
        $this->assertFieldIsInteger('players');
    }

    public function testTeamNameString(): void
    {
        $this->assertFieldIsString('team_name');
    }

    public function testTeamNameLength(): void
    {
        $this->assertFieldExpectedMaxLength('team_name', 255);
    }

    public function testPlayersRange(): void
    {
        $this->assertFieldIsBetweenIntegers('players', 1, 255);
    }

    public function testParticipantCodeBails(): void
    {
        $rules = (new Exercise07FormRequest())->rules();

        $this->assertFieldHasRule('participant_code', $rules, 'bail');
    }

    public function testTeamIdBails(): void
    {
        $rules = (new Exercise07FormRequest())->rules();

        $this->assertFieldHasRule('team_id', $rules, 'bail');
    }
}
