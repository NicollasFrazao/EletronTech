<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use DomainException;

/**
 * A value, unit or operation on physical quantities the domain cannot accept; the edges catch this to answer
 * the user instead of failing.
 */
abstract class QuantityError extends DomainException {}
