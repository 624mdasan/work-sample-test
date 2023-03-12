<?php

namespace src\Spec\People;

use src\Core\PeopleInterface;

class AdultPeople implements PeopleInterface
{
    private const DEFAULT_AMOUNT = 1000;
    private const SPECIAL_AMOUNT = 600;

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
}
