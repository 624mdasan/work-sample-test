<?php

namespace src\Core;

use src\Spec\App\Customer;

abstract class AmountAdjustment
{
    abstract public function __construct(Customer $peoples);
    abstract public function adjustmentValue(): int;

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

        // FIXME: 団体の場合ここで割引しているがいい方法ないか
        if ($this->customer->isGroup()) {
            $totalAmount = $totalAmount - round($totalAmount * 0.1);
        }

        return $totalAmount;
    }

    public function adjustmentDetail(): array
    {
        // TODO: ロジック作成
        $result = [];
        foreach ($this->customer->peoples as $people) {
            $result = [
                $people->type => [
                    'count' => $people->count(),
                    'adjustmentValue' => $this->adjustmentValue(),
                ]
            ];
        }

        return [
            'totalPeopleCount' => $totalPeopleCount,
            'adjustmentType' => $adjustmentType,
            'adjustmentAmount' => $adjustmentAmount,
        ];
    }
}
