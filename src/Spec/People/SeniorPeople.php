<?php

namespace src\Spec\People;

use src\Core\PeopleInterface;

class SeniorPeople implements PeopleInterface
{
    private const DEFAULT_AMOUNT = 800;
    private const SPECIAL_AMOUNT = 500;

    public function __construct(
        private readonly int $count,
        private readonly string $amountType,
    ) { }

    public function count(): int
    {
        return $this->count;
    }

    public function groupCount(): int
    {
        return $this->count;
    }

    public function amount(): int
    {
        if ($this->amountType == self::AMOUNT_TYPE_SPECIAL) {
            return self::SPECIAL_AMOUNT;
        } else {
            return self::DEFAULT_AMOUNT;
        }
    }

    public function amountType(): string
    {
        return $this->amountType;
    }
}
