<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

/**
 * What a calculation returns: the values asked for and the intermediate values found on the way, in order.
 */
final readonly class Result
{
    /**
     * @param  non-empty-list<ResultValue>  $values  The answers.
     * @param  list<ResultValue>  $intermediates  The steps a person would write down: an area, a factor read from a table.
     */
    public function __construct(
        public array $values,
        public array $intermediates = [],
    ) {}
}
