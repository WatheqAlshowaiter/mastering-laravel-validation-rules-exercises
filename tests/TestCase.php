<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Validation\ValidationException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling([
            ValidationException::class,
        ]);
    }

    protected function assertArrayFieldExpectedMaxLength(string $arrayName, string $field, int $maxLength): void
    {
        $failingValue = str_repeat('x', $maxLength + 1);
        $expectedError = ["$arrayName.0.$field" => "max $maxLength"];
        $this->post(route($this::ROUTE), [$arrayName => [[$field => $failingValue]]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayFieldIsEmail(string $arrayName, string $field): void
    {
        $expectedError = ["$arrayName.0.$field" => 'email'];
        $this->post(route($this::ROUTE), [$arrayName => [[$field => 'not-an-email']]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayFieldIsInteger(string $arrayName, string $field): void
    {
        $expectedError = ["$arrayName.0.$field" => 'integer'];
        $this->post(route($this::ROUTE), [$arrayName => [[$field => 'x']]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayFieldIsRegex(string $arrayName, string $field): void
    {
        $expectedError = ["{$arrayName}.0.{$field}" => 'regex'];
        $this->post(route($this::ROUTE), [$arrayName => [[$field => 'what-are-the-odds']]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayFieldIsRequired(string $arrayName, string $field): void
    {
        $expectedError = ["{$arrayName}.0.{$field}" => 'required'];
        $this->post(route($this::ROUTE), [$arrayName => [[$field => '']]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayFieldIsString(string $arrayName, string $field): void
    {
        $expectedError = ["$arrayName.0.$field" => 'string'];
        $this->post(route($this::ROUTE), [$arrayName => [[$field => 999]]])->assertSessionHasErrors($expectedError);
    }

    // TODO: update this to also handle min+max rules
    public function assertArrayFieldIsBetweenIntegers(string $arrayName, string $field, int $min, int $max): void
    {
        $failingMin = $min - 1;
        $failingMax = $max + 1;

        $expectedError = [
            "$arrayName.0.$field" => "between $min $max",
            "$arrayName.1.$field" => "between $min $max",
        ];

        $this->post(route($this::ROUTE), [$arrayName => [[$field => $failingMin], [$field => $failingMax]]])->assertSessionHasErrors($expectedError);
    }

    // TODO: update this to also handle min+max rules
    public function assertArrayValuesAreBetweenIntegers(string $field, int $min, int $max): void
    {
        $failingMin = $min - 1;
        $failingMax = $max + 1;

        $expectedError = [
            "$field.0" => "between $min $max",
            "$field.1" => "between $min $max",
        ];

        $this->post(route($this::ROUTE), [$field => [$failingMin, $failingMax]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayIntegersAreDistinct(string $field): void
    {
        $expectedError = [
            "$field.0" => 'distinct',
            "$field.1" => 'distinct',
        ];
        $this->post(route($this::ROUTE), [$field => [1, 1]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayStringsAreDistinct(string $field, string $safeValue = 'xyz'): void
    {
        $expectedError = [
            "$field.0" => 'distinct',
            "$field.1" => 'distinct',
        ];
        $this->post(route($this::ROUTE), [$field => [$safeValue, $safeValue]])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayValuesAreFromList(string $field, array $list): void
    {
        $expectedError = ["{$field}.0" => 'integer'];
        $this->post(route($this::ROUTE), [$field => ['x']])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayValuesAreIntegers(string $field): void
    {
        $expectedError = ["{$field}.0" => 'integer'];
        $this->post(route($this::ROUTE), [$field => ['x']])->assertSessionHasErrors($expectedError);
    }

    protected function assertArrayValuesAreStrings(string $field): void
    {
        $expectedError = ["{$field}.0" => 'string'];
        $this->post(route($this::ROUTE), [$field => [1]])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldAccepted(string $field): void
    {
        $expectedError = [$field => "accepted"];
        $this->post(route($this::ROUTE), [$field => ''])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldAlpha(string $field, string $failingValue = '12**99'): void
    {
        $expectedError = [$field => "alpha"];
        $this->post(route($this::ROUTE), [$field => $failingValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldAuthenticatesPassword(string $field, User $user): void
    {
        $expectedError = [$field => 'current_password'];
        $this->actingAs($user)->post(route($this::ROUTE), [$field => 'wrong'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldConfirmed(string $field): void
    {
        $expectedError = [$field => 'confirmed'];
        $this->post(route($this::ROUTE), [$field => 'x', "{$field}_confirmation" => 'y'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldDigits(string $field, int $digits): void
    {
        $expectedError = [$field => "digits $digits"];
        $this->post(route($this::ROUTE), [$field => 'not-digits'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldWillFailExistsCheck(string $field, string $failingValue): void
    {
        $expectedError = [$field => 'exists'];
        $this->post(route($this::ROUTE), [$field => $failingValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldWillPassExistsCheck(string $field, string $passingValue): void
    {
        $expectedError = [$field => 'exists'];
        $this->post(route($this::ROUTE), [$field => $passingValue])->assertSessionDoesntHaveErrors($expectedError);
    }

    protected function assertFieldHasDateFormat(string $field, string $expectedFormat): void
    {
        $expectedError = [$field => "date_format $expectedFormat"];
        $this->post(route($this::ROUTE), [$field => '1/1/2000'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsAfterEqualDate(string $field, string $comparisonValue = 'today'): void
    {
        $failingValue = Carbon::parse($comparisonValue)->subDay();
        $expectedError = [$field => "after_or_equal $comparisonValue"];
        $this->post(route($this::ROUTE), [$field => $failingValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsAfterOtherDateField(string $field, string $otherField): void
    {
        $formattedOtherField = str_replace('_', ' ', $otherField);
        $otherValue = Carbon::parse('today');
        $expectedError = [$field => "after $formattedOtherField"];
        $this->post(route($this::ROUTE), [$field => $otherValue, $otherField => $otherValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsArray(string $field): void
    {
        $expectedError = [$field => 'array'];
        $this->post(route($this::ROUTE), [$field => 'not-array'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsBeforeEqualDate(string $field, string $comparisonValue = 'today'): void
    {
        $failingValue = Carbon::parse($comparisonValue)->addDay();
        $expectedError = [$field => "before_or_equal $comparisonValue"];
        $this->post(route($this::ROUTE), [$field => $failingValue])->assertSessionHasErrors($expectedError);
    }

    /**
     * @param string $field
     * @param int $min
     * @param int $max
     *
     * This test is a little more complicated since we handle both `between` and a combination of `min` and `max`
     */
    public function assertFieldIsBetweenIntegers(string $field, int $min, int $max): void
    {
        $failingMin = $min - 1;
        $failingMax = $max + 1;

        $expectedErrorForBetweenRule = "between $min $max";
        $expectedErrorForMinRule = "min $min";
        $expectedErrorForMaxRule = "max $max";

        $this->post(route($this::ROUTE), [$field => $failingMin]);
        if (session('errors') === null || empty(session('errors')->get($field))) {
            $this->assertFalse(true);
        }
        $error = session('errors')->get($field)[0];
        $this->assertTrue($error === $expectedErrorForBetweenRule || $error === $expectedErrorForMinRule);

        $this->post(route($this::ROUTE), [$field => $failingMax]);
        if (session('errors') === null) {
            $this->assertFalse(true);
        }
        $error = session('errors')->get($field)[0];
        $this->assertTrue($error === $expectedErrorForBetweenRule || $error === $expectedErrorForMaxRule);
    }

    protected function assertFieldIsBoolean(string $field): void
    {
        $expectedError = [$field => 'boolean'];
        $this->post(route($this::ROUTE), [$field => 'not-boolean'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsEmail(string $field): void
    {
        $expectedError = [$field => 'email'];
        $this->post(route($this::ROUTE), [$field => 'not-email'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsGreaterEqualOtherField(string $field, string $otherField): void
    {
        $expectedError = [$field => "gte_numeric 100"];
        $this->post(route($this::ROUTE), [$field => 99, $otherField => 100])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsInteger(string $field): void
    {
        $expectedError = [$field => 'integer'];
        $this->post(route($this::ROUTE), [$field => "xyz"])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsProhibitedUnless(string $field, string $otherField, string $otherValue): void
    {
        $formattedOtherField = str_replace('_', ' ', $otherField);
        $expectedError = [$field => "prohibited_unless $formattedOtherField $otherValue"];
        $this->post(route($this::ROUTE), [$field => 'something', $otherField => 'bad-value'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsRequired(string $field): void
    {
        $expectedError = [$field => 'required'];
        $this->post(route($this::ROUTE))->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsRequiredIf(string $field, string $otherField, string $otherValue): void
    {
        $formattedOtherField = str_replace('_', ' ', $otherField);
        $expectedError = [$field => "required_if $formattedOtherField $otherValue"];
        $this->post(route($this::ROUTE), [$otherField => $otherValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsRequiredWithout(string $field, string $otherField): void
    {
        $formattedOtherField = str_replace('_', ' ', $otherField);
        $expectedError = [$field => "required_without $formattedOtherField"];
        $this->post(route($this::ROUTE))->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsRequiredWithoutAll(string $field, array $otherFields): void
    {
        $otherFieldsFormatted = collect($otherFields)
            ->map(function ($i) {
                return str_replace('_', ' ', $i);
            })
            ->join(' / ');

        $expectedError = [$field => "required_without_all $otherFieldsFormatted"];
        $this->post(route($this::ROUTE))->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsString(string $field): void
    {
        $expectedError = [$field => 'string'];
        $this->post(route($this::ROUTE), [$field => 111])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldIsUnique(string $field, string $existingValue): void
    {
        $expectedError = [$field => 'unique'];
        $this->post(route($this::ROUTE), [$field => $existingValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldExpectedMaxLength(string $field, int $maxLength): void
    {
        $failingValue = str_repeat('x', $maxLength + 1);
        $expectedError = [$field => "max $maxLength"];
        $this->post(route($this::ROUTE), [$field => $failingValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldExpectedMinLength(string $field, int $minLength): void
    {
        $failingValue = str_repeat('x', $minLength - 1);
        $expectedError = [$field => "min $minLength"];
        $this->post(route($this::ROUTE), [$field => $failingValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldRejectsValue(string $field, string $badValue): void
    {
        $expectedError = [$field => 'in'];
        $this->post(route($this::ROUTE), [$field => $badValue])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldRejectsValueOtherField(string $field, string $otherField): void
    {
        $formattedOtherField = str_replace('_', ' ', $otherField);
        $expectedError = [$field => "in_array $formattedOtherField"];
        $this->post(route($this::ROUTE), [$field => 'not-valid-value', $otherField => ['valid-value']])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldSize(string $field, int $size): void
    {
        $failingValueTooLong = str_repeat('x', $size + 1);
        $failingValueTooShort = str_repeat('x', $size - 1);

        $expectedError = [$field => "size $size"];
        $this->post(route($this::ROUTE), [$field => $failingValueTooLong])->assertSessionHasErrors($expectedError);
        $this->post(route($this::ROUTE), [$field => $failingValueTooShort])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldSuffix(string $field, string $suffix): void
    {
        $expectedError = [$field => "ends_with $suffix"];
        $this->post(route($this::ROUTE), [$field => 'not-right-suffix'])->assertSessionHasErrors($expectedError);
    }

    protected function assertFieldHasRule(string $field, array $rules, string $expectedRule): void
    {
        $this->assertTrue(array_key_exists($field, $rules)
            && (
                (is_string($rules[$field]) && strpos($rules[$field], $expectedRule) !== false)
                ||
                (is_array($rules[$field]) && in_array($expectedRule, $rules[$field]))
            ));
    }
}
