<?php

declare(strict_types=1);

namespace App\Application\Calculation;

/**
 * One input of a calculator as a form needs it.
 */
final readonly class InputDescription
{
    /**
     * @param  string  $kind  "quantity", "number" or "choice".
     */
    public function __construct(
        public string $name,
        public string $kind,
        public bool $isRequired,
        public AcceptedValues $accepts,
    ) {}
}
