<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

use App\Domain\Quantity\IncompatibleUnit;
use App\Domain\Quantity\InvalidNumber;
use App\Domain\Quantity\NumberParser;
use App\Domain\Quantity\Precision;
use App\Domain\Quantity\Quantities;
use App\Domain\Quantity\UnitCatalogue;
use App\Domain\Quantity\UnknownUnit;

/**
 * The unit converter: expresses a value given in one unit in another unit of the same dimension.
 *
 * The conversion is exact; only the displayed result is rounded, to the significant digits below.
 */
final readonly class ConvertQuantity
{
    /**
     * Enough digits for any reading an electrician takes, few enough that a repeating decimal stays readable.
     */
    private const int SIGNIFICANT_DIGITS = 12;

    public function __construct(
        private UnitCatalogue $catalogue,
    ) {}

    /**
     * Converts the value and rounds the result for display.
     *
     * @throws InvalidNumber
     * @throws UnknownUnit
     * @throws IncompatibleUnit When the two units measure different dimensions.
     */
    public function handle(ConversionInput $input): ConversionResult
    {
        $value = NumberParser::parse($input->value);
        $from = $this->catalogue->find($input->fromUnit);
        $to = $this->catalogue->find($input->toUnit);

        $exact = Quantities::of($value, $from)->in($to);
        $shown = Precision::significantDigits(self::SIGNIFICANT_DIGITS)->apply($exact);

        return new ConversionResult(
            new ValueInUnit($value->toBigDecimal()->toString(), UnitOption::of($from)),
            new ValueInUnit($shown->toString(), UnitOption::of($to)),
            $shown->isEqualTo($exact),
        );
    }
}
