<?php

declare(strict_types=1);

namespace Tests\Support;

use Closure;
use Eris\Facade;
use Eris\Generator;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Property-based checks with Eris: an assertion run over generated inputs, shrunk to a small counterexample
 * when it fails. The seed changes on every run; a failure prints the one that reproduces it.
 */
final class Property extends Facade
{
    /**
     * Runs the assertion on inputs drawn from the generators, one argument per generator.
     *
     * @param  list<Generator>  $generators
     */
    public static function check(int $runs, array $generators, Closure $assertion): void
    {
        $property = new self;
        $property->limitTo($runs);

        try {
            $property->forAll(...$generators)->then($assertion);
        } catch (AssertionFailedError $failure) {
            $message = $failure->getMessage()."\nReproduce with ERIS_SEED={$property->seed}.";

            throw new AssertionFailedError($message, $failure->getCode(), $failure);
        }
    }
}
