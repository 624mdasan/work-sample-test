<?php

namespace src;

use src\Core\AmountAdjustmentInterface;
use src\Spec\AdjustmentRule\EveningRule;
use src\Spec\AdjustmentRule\HolidayRule;
use src\Spec\App\AdjustmentRule;
use src\Spec\App\Customer;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;
use src\Spec\People\SeniorPeople;

class AmountAdjustmentFactory
{
    /**
     * 条件によって対象のAmountAdjustmentクラスを適用する
     *
     * @param int $adultCount 大人の人数
     * @param int $childCount 子供の人数
     * @param int $seniorCount シニアの人数
     * @param string $type チケットタイプ
     * @param \DateTimeImmutable $dateTime 日時
     *
     * @return AmountAdjustmentInterface
     */
    public function create(
        int $adultCount,
        int $childCount,
        int $seniorCount,
        string $type,
        \DateTimeImmutable $dateTime
    ): AmountAdjustmentInterface
    {
        $customer = new Customer([
            new AdultPeople($adultCount, $type),
            new ChildPeople($childCount, $type),
            new SeniorPeople($seniorCount, $type),
        ]);

        $adjustmentRule = new AdjustmentRule([
            new EveningRule(),
            new HolidayRule(),
        ]);

        return $adjustmentRule->apply($customer, $dateTime);
    }
}
