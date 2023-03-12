<?php

namespace src;

use src\Spec\People\Customer;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;

class CalcAmount
{
    public function calc(int $adultCount, int $childCount, bool $isSpecial, \DateTimeImmutable $dateTime): int
    {
        $amountType = '';
        if ($isSpecial) {
            $amountType = 'special';
        }

        $peoples = new Customer([
            new AdultPeople($adultCount, $amountType),
            new ChildPeople($childCount, $amountType),
        ]);

        $applyRule = new AmountAdjustmentFactory($peoples, $dateTime);

        $applyDetail = $applyRule->applyDetail();
        $subTotalAmount = $applyRule->subTotalAmount();
        $totalAmount = $applyRule->totalAmount();

        return $totalAmount;
    }
}
