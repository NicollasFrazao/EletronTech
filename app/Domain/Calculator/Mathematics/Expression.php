<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Mathematics;

use App\Domain\Calculator\InputProblem;
use App\Domain\Quantity\InvalidNumber;
use App\Domain\Quantity\NumberParser;
use Brick\Math\BigRational;

/**
 * Evaluates an arithmetic expression exactly, without eval: a recursive-descent parser over a fixed grammar of
 * numbers, the four operations and brackets, so a text can only ever be arithmetic.
 *
 * The grammar, from the loosest binding to the tightest:
 *
 *     sum     = product { ("+" | "-") product }
 *     product = signed { ("*" | "/") signed | bracketed-or-number-after-a-bracket }
 *     signed  = ("+" | "-") signed | primary
 *     primary = number | "(" sum ")" | "[" sum "]" | "{" sum "}"
 *
 * Numbers take a decimal point or a decimal comma and an exponent ("1,5", "4.7e-6"); "×", "÷" and "−" are
 * accepted for "*", "/" and "-". A bracket next to a number or another bracket multiplies, as written by hand:
 * 2(3 + 1) is 8 and (1 + 1)(2) is 4; two numbers side by side are refused. Every operation is on exact fractions,
 * so 0.1 + 0.2 is exactly 0.3.
 */
final class Expression
{
    /**
     * The longest text evaluated, which also bounds the nesting depth and the size of the numbers.
     */
    public const int MAX_LENGTH = 255;

    /**
     * One token, after any spaces: a number or a symbol.
     */
    private const string TOKEN = '/\G\s*(?:(?<number>(?:\d+(?:[.,]\d+)?|[.,]\d+)(?:[eE][+-]?\d+)?)|(?<symbol>[-+*\/×÷−()\[\]{}]))/u';

    /**
     * Each opening bracket and the one that closes it.
     */
    private const array CLOSING = ['(' => ')', '[' => ']', '{' => '}'];

    private const array PLUS = ['+'];

    private const array MINUS = ['-', '−'];

    private const array TIMES = ['*', '×'];

    private const array DIVIDED_BY = ['/', '÷'];

    private int $position = 0;

    /**
     * @param  list<string>  $tokens
     */
    private function __construct(
        private readonly array $tokens,
    ) {}

    /**
     * The exact value of the expression.
     *
     * @throws InvalidExpression When the text is not an expression of this grammar, divides by zero or is too long.
     */
    public static function evaluate(string $text): BigRational
    {
        if (mb_strlen($text) > self::MAX_LENGTH) {
            throw InvalidExpression::because(InputProblem::TooLong);
        }

        $parser = new self(self::tokenize($text));
        $value = $parser->sum();

        if ($parser->peek() !== null) {
            throw InvalidExpression::because(InputProblem::NotAnExpression);
        }

        return $value;
    }

    /**
     * The text split into numbers and symbols; anything else refuses the whole text.
     *
     * @return list<string>
     *
     * @throws InvalidExpression
     */
    private static function tokenize(string $text): array
    {
        $tokens = [];
        $offset = 0;
        $length = strlen(rtrim($text));

        while ($offset < $length) {
            if (preg_match(self::TOKEN, $text, $match, PREG_UNMATCHED_AS_NULL, $offset) !== 1) {
                throw InvalidExpression::because(InputProblem::NotAnExpression);
            }

            $tokens[] = (string) ($match['number'] ?? $match['symbol']);
            $offset += strlen($match[0]);
        }

        return $tokens;
    }

    /**
     * A sum or difference of products, left to right.
     *
     * @throws InvalidExpression
     */
    private function sum(): BigRational
    {
        $value = $this->product();

        while ($this->nextIsOneOf([...self::PLUS, ...self::MINUS])) {
            $isPlus = in_array($this->take(), self::PLUS, true);
            $operand = $this->product();
            $value = $isPlus ? $value->plus($operand) : $value->minus($operand);
        }

        return $value;
    }

    /**
     * A product or quotient of signed factors, left to right, including the products written without a sign.
     *
     * @throws InvalidExpression
     */
    private function product(): BigRational
    {
        $value = $this->signed();

        while (true) {
            if ($this->nextIsOneOf(self::TIMES)) {
                $this->take();
                $value = $value->multipliedBy($this->signed());
            } elseif ($this->nextIsOneOf(self::DIVIDED_BY)) {
                $this->take();
                $value = $this->divide($value, $this->signed());
            } elseif ($this->nextIsImpliedProduct()) {
                $value = $value->multipliedBy($this->primary());
            } else {
                return $value;
            }
        }
    }

    /**
     * A factor with any number of signs before it.
     *
     * @throws InvalidExpression
     */
    private function signed(): BigRational
    {
        if ($this->nextIsOneOf(self::PLUS)) {
            $this->take();

            return $this->signed();
        }

        if ($this->nextIsOneOf(self::MINUS)) {
            $this->take();

            return $this->signed()->negated();
        }

        return $this->primary();
    }

    /**
     * A number, or a sum between matching brackets.
     *
     * @throws InvalidExpression
     */
    private function primary(): BigRational
    {
        $token = $this->take();

        if (isset(self::CLOSING[$token])) {
            $value = $this->sum();

            if ($this->take() !== self::CLOSING[$token]) {
                throw InvalidExpression::because(InputProblem::NotAnExpression);
            }

            return $value;
        }

        return $this->number($token);
    }

    /**
     * Whether the next token starts a factor multiplied without a sign: an opening bracket after anything, or a
     * number right after a closing bracket.
     */
    private function nextIsImpliedProduct(): bool
    {
        $next = $this->peek();

        if ($next === null) {
            return false;
        }

        if (isset(self::CLOSING[$next])) {
            return true;
        }

        return $this->isNumber($next) && in_array($this->tokens[$this->position - 1] ?? null, self::CLOSING, true);
    }

    /**
     * Whether the next token is one of these symbols.
     *
     * @param  list<string>  $symbols
     */
    private function nextIsOneOf(array $symbols): bool
    {
        return in_array($this->peek(), $symbols, true);
    }

    /**
     * The next token, without moving past it; null at the end.
     */
    private function peek(): ?string
    {
        return $this->tokens[$this->position] ?? null;
    }

    /**
     * The next token, moving past it; the end of the text where a token is needed refuses the expression.
     *
     * @throws InvalidExpression
     */
    private function take(): string
    {
        $token = $this->peek() ?? throw InvalidExpression::because(InputProblem::NotAnExpression);
        $this->position++;

        return $token;
    }

    /**
     * Whether a token is a number rather than a symbol.
     */
    private function isNumber(string $token): bool
    {
        return preg_match('/^[\d.,]/', $token) === 1;
    }

    /**
     * The exact value of a number token.
     *
     * @throws InvalidExpression
     */
    private function number(string $token): BigRational
    {
        if (! $this->isNumber($token)) {
            throw InvalidExpression::because(InputProblem::NotAnExpression);
        }

        try {
            return NumberParser::parse(str_replace(',', '.', $token));
        } catch (InvalidNumber) {
            throw InvalidExpression::because(InputProblem::NotAnExpression);
        }
    }

    /**
     * The exact quotient.
     *
     * @throws InvalidExpression
     */
    private function divide(BigRational $dividend, BigRational $divisor): BigRational
    {
        if ($divisor->isZero()) {
            throw InvalidExpression::because(InputProblem::DivisionByZero);
        }

        return $dividend->dividedBy($divisor);
    }
}
