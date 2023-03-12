<?php

namespace src\Spec\People;

use src\Core\PeopleInterface;

class ChildPeople implements PeopleInterface
{
    private const DEFAULT_AMOUNT = 500;
    private const SPECIAL_AMOUNT = 400;

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
        // 小数点切り捨て（9人の場合、4人計算をしたい）
        return floor($this->count * 0.5);
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
