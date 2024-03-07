<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise02;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise02
 */
class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE = 'exercise-02';

    public const REQUIREMENTS = [
        'description' => 'Allow user to change their password',
        'request_fields' => [
            'old_password (even though they are authenticated, require current password for extra check)',
            'password (the new password)',
            'password_confirmation (new password repeated)',
        ],
        'database_fields' => [
            ['password', 'VARCHAR(255)'],
        ],
        'functional' => [
            'Current password must be correct' => [
                'testCurrentPasswordRequired' => 'old_password field is required',
                'testCurrentPasswordIsCorrect' => 'old_password field must authenticate',
            ],
            'New password must be at least 8 characters long' => [
                'testPasswordRequired' => 'password field is required',
                'testPasswordLength' => 'password field must be at least 8 characters',
            ],
            'New password must be entered correctly twice' => [
                'testPasswordConfirmed' => 'password field must be entered twice and match',
            ]
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testOldPasswordString' => 'old_password field is a string',
                'testNewPasswordString' => 'password field is a string',
            ],
            // we store hashes, so they can't overflow the database
        ],
    ];

    public function testCurrentPasswordRequired(): void
    {
        $this->assertFieldIsRequired('old_password');
    }

    public function testCurrentPasswordIsCorrect(): void
    {
        $user = User::factory()->create();
        $this->assertFieldAuthenticatesPassword('old_password', $user);
    }

    public function testPasswordRequired(): void
    {
        $this->assertFieldIsRequired('password');
    }

    public function testPasswordLength(): void
    {
        $this->assertFieldExpectedMinLength('password', 8);
    }

    public function testPasswordConfirmed(): void
    {
        $this->assertFieldConfirmed('password');
    }

    public function testOldPasswordString(): void
    {
        $this->assertFieldIsString('old_password');
    }

    public function testNewPasswordString(): void
    {
        $this->assertFieldIsString('password');
    }
}
