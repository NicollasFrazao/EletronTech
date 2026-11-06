<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Mathematics;

/**
 * How two quantities vary together in a rule of three: in the same direction (twice the hours, twice the
 * pay) or in opposite directions (twice the workers, half the days).
 */
enum Proportion: string
{
    case Direct = 'direct';
    case Inverse = 'inverse';

    /**
     * The two pairs of values whose products are equal, by the names of the rule of three's inputs: first and
     * second are one case, third and fourth the other. Direct: first × fourth = second × third. Inverse:
     * first × second = third × fourth.
     *
     * @return array{array{string, string}, array{string, string}}
     */
    public function equalProducts(): array
    {
        return match ($this) {
            self::Direct => [['first', 'fourth'], ['second', 'third']],
            self::Inverse => [['first', 'second'], ['third', 'fourth']],
        };
    }
}
