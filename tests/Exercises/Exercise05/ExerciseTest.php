<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise05;

use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise05
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-05';

    public const REQUIREMENTS = [
        'description' => 'Post a skill to a job board',
        'request_fields' => [
            'title',
            'categories',
            'primary_category',
            'is_remote',
            'is_onsite',
            'minimum_rate (whole number with no formatting)',
            'maximum_rate (whole number with no formatting)',
        ],
        'database_fields' => [
            ['title', 'VARCHAR(255)'],
            ['categories', 'VARCHAR(255)'],
            ['primary_category', 'VARCHAR(255)'],
            ['is_remote', 'BIT'],
            ['is_onsite', 'BIT'],
            ['minimum_rate', 'UNSIGNED SMALLINT'],
            ['maximum_rate', 'UNSIGNED SMALLINT'],
        ],
        'functional' => [
            'Skill must contain a title' => [
                'testTitleRequired' => 'title field is required',
            ],
            'Skill must have at least one category' => [
                'testCategoriesRequired' => 'categories are required',
                'testCategoriesAreValid' => 'each category must be from the available list',
            ],
            'One of the categories should be designated as the primary category' => [
                'testPrimaryCategoryRequired' => 'primary_category field is required',
                'testPrimaryCategoryInArray' => 'primary_category must be one of your selected categories',
            ],
            'A skill can be offered onsite, remote, or both' => [
                'testLocationSelected' => 'skill must be onsite, remote, or both',
            ],
            'A skill must include both min and max rates' => [
                'testMinimumRateRequired' => 'minimum_rate field is required',
                'testMaximumRateRequired' => 'maximum_rate field is required',
                'testMaximumGreaterEqualMinimum' => 'maximum_rate can\'t be less than the minimum rate',
            ],

        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testTitleString' => 'title field is a string',
                'testCategoriesArray' => 'categories field is an array',
                'testEachCategoryIsString' => 'each category is a string',
                'testEachCategoryIsDistinct' => 'each category must be unique',
                'testPrimaryCategoryString' => 'primary_category field is a string',
                'testIsRemoteBoolean' => 'is_remote field is a boolean',
                'testIsOnsiteBoolean' => 'is_onsite field is a boolean',
                'testMinimumRateInteger' => 'minimum_rate is an integer',
                'testMaximumRateInteger' => 'maximum_rate is an integer',
            ],
            'Prevent database overflow' => [
                'testTitleLength' => 'title can\'t overflow the database',
                'testMinimumRateIntegerSize' => 'minimum_rate must fit in an unsigned smallint field',
                'testMaximumRateIntegerSize' => 'maximum_rate must fit in an unsigned smallint field',
            ],
        ],
    ];

    public function testTitleRequired(): void
    {
        $this->assertFieldIsRequired('title');
    }

    public function testCategoriesRequired(): void
    {
        $this->assertFieldIsRequired('categories');
    }

    public function testCategoriesAreValid(): void
    {
        $this->assertFieldRejectsValue('categories', 'bad-category');
    }

    public function testPrimaryCategoryRequired(): void
    {
        $this->assertFieldIsRequired('primary_category');
    }

    public function testPrimaryCategoryInArray(): void
    {
        $this->assertFieldRejectsValueOtherField('primary_category', 'categories');
    }

    public function testLocationSelected(): void
    {
        $this->assertFieldIsRequiredWithout('is_onsite', 'is_remote');
        $this->assertFieldIsRequiredWithout('is_remote', 'is_onsite');
    }

    public function testMinimumRateRequired(): void
    {
        $this->assertFieldIsRequired('minimum_rate');
    }

    public function testMaximumRateRequired(): void
    {
        $this->assertFieldIsRequired('maximum_rate');
    }

    public function testMaximumGreaterEqualMinimum(): void
    {
        $this->assertFieldIsGreaterEqualOtherField('maximum_rate', 'minimum_rate');
    }

    public function testTitleString(): void
    {
        $this->assertFieldIsString('title');
    }

    public function testCategoriesArray(): void
    {
        $this->assertFieldIsArray('categories');
    }

    public function testEachCategoryIsString(): void
    {
        $this->assertArrayValuesAreStrings('categories');
    }

    public function testEachCategoryIsDistinct(): void
    {
        $this->assertArrayStringsAreDistinct('categories', 'lawn');
    }

    public function testPrimaryCategoryString(): void
    {
        $this->assertFieldIsString('primary_category');
    }

    public function testIsRemoteBoolean(): void
    {
        $this->assertFieldIsBoolean('is_remote');
    }

    public function testIsOnsiteBoolean(): void
    {
        $this->assertFieldIsBoolean('is_onsite');
    }

    public function testMinimumRateInteger(): void
    {
        $this->assertFieldIsInteger('minimum_rate');
    }

    public function testMaximumRateInteger(): void
    {
        $this->assertFieldIsInteger('maximum_rate');
    }

    public function testTitleLength(): void
    {
        $this->assertFieldExpectedMaxLength('title', 255);
    }

    public function testMinimumRateIntegerSize(): void
    {
        $this->assertFieldIsBetweenIntegers('minimum_rate', 0, 65535);
    }

    public function testMaximumRateIntegerSize(): void
    {
        $this->assertFieldIsBetweenIntegers('maximum_rate', 0, 65535);
    }
}
