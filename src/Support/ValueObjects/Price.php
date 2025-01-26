<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

final class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽',
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100,
        private readonly int $discount = 15
    )
    {
        if($value < 0) {
            throw new InvalidArgumentException(
                'Price must be greater than 0'
            );
        }

        if(!isset($this->currencies[$currency])) {
            throw new InvalidArgumentException(
                'Currency not allowed'
            );
        }
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function discount(): int
    {
        return $this->discount;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function old(): string
    {
        $old = $this->value / $this->precision + ($this->value / $this->precision  * ($this->discount / 100));
        return number_format($old, 0, ',', ' ') . ' ' . $this->symbol();
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->value(), 0, ',', ' ') . ' ' . $this->symbol();
    }
}
