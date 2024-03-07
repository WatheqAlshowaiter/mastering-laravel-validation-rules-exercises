<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise08;

use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise08
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-08';

    public const REQUIREMENTS = [
        'description' => 'Submit a score sheet for a trivia game',
        'request_fields' => [
            'teams (an array, one row per team, every field to follow is within a teams row)',
            'teams[player_count]',
            'teams[team_name]',
            'teams[q1_points]',
            'teams[q2_points]',
            'teams[q3_points]',
            'teams[bonus_points]',
        ],
        'database_fields' => [
            ['player_count', 'TINYINT UNSIGNED'],
            ['team_name', 'VARCHAR(255)'],
            ['q1_points', 'TINYINT UNSIGNED'],
            ['q2_points', 'TINYINT UNSIGNED'],
            ['q3_points', 'TINYINT UNSIGNED'],
            ['bonus_points', 'TINYINT UNSIGNED'],
        ],
        'functional' => [
            'Score sheet must contain at least one team' => [
                'testTeamsRequired' => 'teams array is required',
            ],
            'Each team must have a player count' => [
                'testPlayerCountRequired' => 'each team must have a player count',
                'testPlayerCountRange' => 'must be at least one player on each team'
            ],
            'Each team must have a team name' => [
                'testTeamNameRequired' => 'each team must have a name',
            ],
            'Each team must have a score for all 4 questions' => [
                'testQ1Required' => 'each team must have a score for q1',
                'testQ2Required' => 'each team must have a score for q2',
                'testQ3Required' => 'each team must have a score for q3',
                'testBonusRequired' => 'each team must have a score for bonus',
            ],
            'Main round questions (q1, q2, q3) must be between 1 - 5 points' => [
                'testQ1Range' => 'each team q1 score must be between 1 - 5 points',
                'testQ2Range' => 'each team q2 score must be between 1 - 5 points',
                'testQ3Range' => 'each team q3 score must be between 1 - 5 points',
            ],
            'Bonus question must be between 0 - 50 points' => [
                'testBonusRange' => 'each team bonus score must be between 0 - 50 points',
            ],
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testTeamsArray' => 'teams field is an array',
                'testPlayerCountInteger' => 'each team player count must be an integer',
                'testTeamNameString' => 'each team name must be a string',
                'testQ1Integer' => 'each team q1 score count must be an integer',
                'testQ2Integer' => 'each team q2 score count must be an integer',
                'testQ3Integer' => 'each team q3 score count must be an integer',
                'testBonusInteger' => 'each team bonus score count must be an integer',
            ],
            'Prevent database overflow' => [
                'testPlayerCountRange' => 'player_count shouldn\'t allow a value too big for the database field',
                'testTeamNameLength' => 'team_name shouldn\'t allow a value too big for the database field',
            ],
        ],
    ];

    public function testTeamsRequired(): void
    {
        $this->assertFieldIsRequired('teams');
    }

    public function testPlayerCountRequired(): void
    {
        $this->assertArrayFieldIsRequired('teams', 'player_count');
    }

    public function testPlayerCountRange(): void
    {
        $this->assertArrayFieldIsBetweenIntegers('teams', 'player_count', 1, 255);
    }

    public function testTeamNameRequired(): void
    {
        $this->assertArrayFieldIsRequired('teams', 'team_name');
    }

    public function testQ1Required(): void
    {
        $this->assertArrayFieldIsRequired('teams', 'q1_points');
    }

    public function testQ2Required(): void
    {
        $this->assertArrayFieldIsRequired('teams', 'q2_points');
    }

    public function testQ3Required(): void
    {
        $this->assertArrayFieldIsRequired('teams', 'q3_points');
    }

    public function testBonusRequired(): void
    {
        $this->assertArrayFieldIsRequired('teams', 'bonus_points');
    }

    public function testQ1Range(): void
    {
        $this->assertArrayFieldIsBetweenIntegers('teams', 'q1_points', 1, 5);
    }

    public function testQ2Range(): void
    {
        $this->assertArrayFieldIsBetweenIntegers('teams', 'q2_points', 1, 5);
    }

    public function testQ3Range(): void
    {
        $this->assertArrayFieldIsBetweenIntegers('teams', 'q3_points', 1, 5);
    }

    public function testBonusRange(): void
    {
        $this->assertArrayFieldIsBetweenIntegers('teams', 'bonus_points', 0, 50);
    }

    public function testTeamsArray(): void
    {
        $this->assertFieldIsArray('teams');
    }

    public function testPlayerCountInteger(): void
    {
        $this->assertArrayFieldIsInteger('teams', 'player_count');
    }

    public function testTeamNameString(): void
    {
        $this->assertArrayFieldIsString('teams', 'team_name');
    }

    public function testQ1Integer(): void
    {
        $this->assertArrayFieldIsInteger('teams', 'q1_points');
    }

    public function testQ2Integer(): void
    {
        $this->assertArrayFieldIsInteger('teams', 'q2_points');
    }

    public function testQ3Integer(): void
    {
        $this->assertArrayFieldIsInteger('teams', 'q3_points');
    }

    public function testBonusInteger(): void
    {
        $this->assertArrayFieldIsInteger('teams', 'bonus_points');
    }

    public function testTeamNameLength(): void
    {
        $this->assertArrayFieldExpectedMaxLength('teams', 'team_name', 255);
    }
}
