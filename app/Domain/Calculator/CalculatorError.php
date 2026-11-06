<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use DomainException;

/**
 * A calculator cannot be found or cannot work with what it was given; the edges catch this to answer the person.
 */
abstract class CalculatorError extends DomainException {}
