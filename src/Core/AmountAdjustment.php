<?php

namespace src\Core;

use src\Spec\App\Customer;

abstract class AmountAdjustment
{
    abstract public function __construct(Customer $customer);

    /**
     * 調整金額
     *
     * @return int
     */
    abstract public function adjustmentValue(): int;

    /**
     * 調整タイプ
     *
     * @return string
     */
    abstract public function type(): string;

    /**
     * 小計金額の計算
     *
     * @return int
     */
    public function subTotalAmount(): int
    {
        $totalAmount = 0;
        foreach ($this->customer->peoples as $people) {
            $totalAmount += ($people->amount()) * $people->count();
        }

        return $totalAmount;
    }

    /**
     * 合計金額の計算
     *
     * @return int
     */
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

    /**
     * 明細内容の抽出
     *
     * @return array
     */
    public function adjustmentDetail(): array
    {
        $totalPeopleCount = 0;
        $peopleCount = [];
        $amountType = '';
        foreach ($this->customer->peoples as $people) {
            $totalPeopleCount += $people->count();
            $amountType = $people->amountType();

            $peopleCount[$people::class] =  $people->count();
        }

        $adjustmentType = $this->type();
        $adjustmentAmount = $this->adjustmentValue();
        $adjustmentForGroup = $this->customer->isGroup();

        return [
            'totalPeopleCount' => $totalPeopleCount,
            'peopleCount' => $peopleCount,
            'adjustmentType' => $adjustmentType,
            'adjustmentAmount' => $adjustmentAmount,
            'adjustmentForGroup' => $adjustmentForGroup,
            'amountType' => $amountType,
        ];
    }
}
