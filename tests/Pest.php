<?php

declare(strict_types=1);

use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\InvalidInput;
use Tests\TestCase;

pest()->extend(TestCase::class)->in('Feature');

/**
 * Asserts that a calculation or a read of its inputs fails on one field for one reason.
 */
function expectInvalid(Closure $calculation, string $field, InputProblem $problem): void
{
    expect($calculation)->toThrow(function (InvalidInput $error) use ($field, $problem): void {
        expect([$error->field, $error->problem])->toBe([$field, $problem]);
    });
}
