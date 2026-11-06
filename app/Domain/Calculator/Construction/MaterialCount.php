<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Construction;

use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\DivisionByZero;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;

/**
 * How many pieces of a material (tiles, blocks) cover a surface, with the waste allowance: the exact number, then
 * the whole number to buy, rounded up so the last piece is never short.
 */
final readonly class MaterialCount
{
    public const string WASTE = 'waste';

    private function __construct(
        private WasteAllowance $waste,
    ) {}

    /**
     * The count with the allowance typed in the "waste" input, or the usual 10% when it is left empty.
     *
     * @throws InvalidInput When the allowance is below 0% or above 100%.
     */
    public static function withWasteFrom(Inputs $inputs): self
    {
        if (! $inputs->has(self::WASTE)) {
            return new self(WasteAllowance::usual());
        }

        $waste = WasteAllowance::tryOf($inputs->number(self::WASTE))
            ?? throw InvalidInput::of(self::WASTE, InputProblem::OutOfRange);

        return new self($waste);
    }

    /**
     * The whole number of pieces of a given area each that cover a surface, waste included.
     *
     * @throws DivisionByZero
     */
    public function piecesFor(Area $surface, Area $piece): BigInteger
    {
        return $this->waste->addedTo($surface->ratioTo($piece))->toScale(0, RoundingMode::Ceiling)->toBigInteger();
    }

    /**
     * The exact number of pieces with the allowance, before rounding up, and the allowance used.
     *
     * @return list<ResultValue>
     *
     * @throws DivisionByZero
     */
    public function intermediates(Area $surface, Area $piece): array
    {
        return [
            ResultValue::number('pieces_without_rounding', $this->waste->addedTo($surface->ratioTo($piece))),
            ResultValue::number('waste_percent', $this->waste->percent()),
        ];
    }
}
