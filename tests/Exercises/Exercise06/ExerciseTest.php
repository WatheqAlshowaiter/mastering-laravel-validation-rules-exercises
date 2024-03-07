<?php

declare(strict_types=1);

namespace Tests\Exercises\Exercise06;

use App\Http\Requests\Exercise06FormRequest;
use Tests\TestCase;

/**
 * Class ExerciseTest
 * @package Tests\Exercises\Exercise06
 */
class ExerciseTest extends TestCase
{
    protected const ROUTE = 'exercise-06';

    public const REQUIREMENTS = [
        'description' => 'Shipping and receiving processing',
        'request_fields' => [
            'workflow_type (radio button with two values: shipping, receiving)',
            'processed_date (native date picker, like 2021-12-31)',
            'waybill_number (free form text, no specific format)',
            'is_damaged (checkbox, only visible if workflow_type is receiving)',
            'damage_description (textarea, only visible if is_damaged is checked)',
            'notes',
        ],
        'database_fields' => [
            ['workflow_type', 'VARCHAR(255)'],
            ['processed_date', 'DATE'],
            ['waybill_number', 'VARCHAR(255)'],
            ['is_damaged', 'BIT'],
            ['damage_description', 'VARCHAR(1500)'],
            ['notes', 'VARCHAR(1500)'],
        ],
        'functional' => [
            'Process record must indicate whether it is being shipped or received' => [
                'testWorkflowTypeRequired' => 'workflow_type is required',
                'testWorkflowTypeIsValid' => 'workflow_type must be shipping or receiving',
            ],
            'Process record must have a date that is on or before today' => [
                'testProcessedDateRequired' => 'processed_date is required',
                'testProcessedDateRange' => 'processed_date cannot be in the future',
            ],
            'Process record must have a waybill number' => [
                'testWaybillNumberRequired' => 'waybill_number is required',
            ],
            'Allow flagging received items as damaged with an explanation' => [
                'testIsDamagedOnlyWithReceivedItems' => 'is_damaged can only be set if workflow_type is received',
                'testDamageDescriptionRequiredIfDamaged' => 'damage_description must be provided if item is damaged',
            ],
            'Allow optional notes with process record' => [
                'testNotesNullable' => 'notes should be optional',
            ]
        ],
        'defensive' => [
            'Be explicit about field types' => [
                'testWorkflowTypeString' => 'workflow_type field is a string',
                'testProcessedDateString' => 'processed_date field is a string',
                'testProcessedDateIsValidFormat' => 'processed_date field must be in expected format',
                'testWaybillNumberString' => 'waybill_number field is a string',
                'testIsDamagedBoolean' => 'is_damaged field is a boolean',
                'testDamageDescriptionString' => 'damage_description field is a string',
                'testNotesString' => 'notes field is a string',
            ],
            'Prevent database overflow' => [
                'testWaybillNumberLength' => 'waybill_number shouldn\'t allow a value too big for the database field',
                'testDamageDescriptionLength' => 'damage_description shouldn\'t allow a value too big for the database field',
                'testNotesLength' => 'notes shouldn\'t allow a value too big for the database field',
            ],
        ],
    ];

    public function testWorkflowTypeRequired(): void
    {
        $this->assertFieldIsRequired('workflow_type');
    }

    public function testWorkflowTypeIsValid(): void
    {
        $this->assertFieldRejectsValue('workflow_type', 'bad-value');
    }

    public function testProcessedDateRequired(): void
    {
        $this->assertFieldIsRequired('processed_date');
    }

    public function testProcessedDateRange(): void
    {
        $this->assertFieldIsBeforeEqualDate('processed_date');
    }

    public function testWaybillNumberRequired(): void
    {
        $this->assertFieldIsRequired('waybill_number');
    }

    public function testIsDamagedOnlyWithReceivedItems(): void
    {
        $this->assertFieldIsProhibitedUnless('is_damaged', 'workflow_type', 'receiving');
    }

    public function testDamageDescriptionRequiredIfDamaged(): void
    {
        $this->assertFieldIsRequiredIf('damage_description', 'is_damaged', '1');
    }

    public function testNotesNullable(): void
    {
        $rules = (new Exercise06FormRequest())->rules();

        $this->assertFieldHasRule('notes', $rules, 'nullable');
    }

    public function testWorkflowTypeString(): void
    {
        $this->assertFieldIsString('workflow_type');
    }

    public function testProcessedDateString(): void
    {
        $this->assertFieldIsString('processed_date');
    }

    public function testProcessedDateIsValidFormat(): void
    {
        $this->assertFieldHasDateFormat('processed_date', 'Y-m-d');
    }

    public function testWaybillNumberString(): void
    {
        $this->assertFieldIsString('waybill_number');
    }

    public function testIsDamagedBoolean(): void
    {
        $this->assertFieldIsBoolean('is_damaged');
    }

    public function testDamageDescriptionString(): void
    {
        $this->assertFieldIsString('damage_description');
    }

    public function testNotesString(): void
    {
        $this->assertFieldIsString('notes');
    }

    public function testWaybillNumberLength(): void
    {
        $this->assertFieldExpectedMaxLength('waybill_number', 255);
    }

    public function testDamageDescriptionLength(): void
    {
        $this->assertFieldExpectedMaxLength('damage_description', 1500);
    }

    public function testNotesLength(): void
    {
        $this->assertFieldExpectedMaxLength('notes', 1500);
    }
}
