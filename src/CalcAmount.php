<?php

namespace src;

use src\AmountAdjustmentFactory;
use src\Spec\People\Customer;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;

//require 'src/Core/PeopleInterface.php';

class CalcAmount
{
    public function calc(int $adultCount, int $childCount, bool $isSpecial, \DateTimeImmutable $dateTime): int
    {
        if ($isSpecial) {
            $adultAmount = 600;
        } else {
            $adultAmount = 1000;
        }
        $adultAmountEvening = $adultAmount - 100;
        $adultAmountHoliday = $adultAmount + 200;

        if ($isSpecial) {
            $childAmount = 400;
        } else {
            $childAmount = 500;
        }
        $childAmountEvening = $childAmount - 100;
        $childAmountHoliday = $childAmount + 200;

        $dayOfWeek = $dateTime->format('w');

        $evening = $dateTime->setTime(17, 0, 0);
        $isEvening = ($dateTime >= $evening) && !($dayOfWeek == 0 || $dayOfWeek == 6);

        $isHoliday = $dayOfWeek == 0 || $dayOfWeek == 6;

        $subTotal =  ($adultCount * $adultAmount) + ($childCount * $childAmount);

        $totalAmount = $subTotal;

        if ($isEvening) {
            $totalAmount =  ($adultCount * $adultAmountEvening) + ($childCount * $childAmountEvening);
        } elseif ($isHoliday) {
            $totalAmount =  ($adultCount * $adultAmountHoliday) + ($childCount * $childAmountHoliday);
        }

        if (($adultCount + ($childCount * 0.5)) >= 10) {
            $totalAmount = $totalAmount - round($totalAmount * 0.1);
        }

        return $totalAmount;
    }

    public function provisionalCalc(int $adultCount, int $childCount, bool $isSpecial, \DateTimeImmutable $dateTime): int
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
