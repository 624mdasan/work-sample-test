<?php

namespace src\Spec\AmountAdjustment;

use src\Core\AmountAdjustmentInterface;
use src\Spec\People\Customer;

class HolidayAmountAdjustment implements AmountAdjustmentInterface
{
    public function __construct(protected Customer $customer) {}

    public function match($dateTime, $isSpecial): bool
    {
        // 特別な場合は対象にしない
        if ($isSpecial) {
            return false;
        }

        $dayOfWeek = $dateTime->format('w');
        $evening = $dateTime->setTime(17, 0, 0);

        return ($dateTime >= $evening) && !($dayOfWeek == 0 || $dayOfWeek == 6);
    }

    public function adjustmentValue(): int
    {
        return 200;
    }

    public function subTotalAmount(): int
    {
        $totalAmount = 0;
        foreach ($this->customer->peoples as $people) {
            $totalAmount += ($people->amount()) * $people->count();
        }

        return $totalAmount;
    }

    public function totalAmount(): int
    {
        $totalAmount = 0;
        foreach ($this->customer->peoples as $people) {
            $totalAmount += ($people->amount() + $this->adjustmentValue()) * $people->count();
        }

        if ($this->customer->isGroup()) {
            $totalAmount = $totalAmount - round($totalAmount * 0.1);
        }

        return $totalAmount;
    }

    public function adjustmentDetail(): array
    {
        $result = [];
        foreach ($this->customer->peoples as $people) {
            $result = [
                $people->type => [
                    'count' => $people->count(),
                    'adjustmentValue' => $this->adjustmentValue(),
                ]
            ];
        }

        return $result;
    }
}
