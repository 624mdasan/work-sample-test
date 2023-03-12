<?php

namespace src\Spec\AmountAdjustment;

use src\Core\AmountAdjustmentInterface;
use src\Spec\App\Customer;

class DefaultAmountAdjustment implements AmountAdjustmentInterface
{
    public function __construct(protected Customer $customer) {}

    public function adjustmentValue(): int
    {
        return 0;
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
