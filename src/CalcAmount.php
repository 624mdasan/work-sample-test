<?php

class CalcAmount
{
    public function calc(int $adultCount, int $childCount, bool $isSpecial, DateTimeImmutable $dateTime): int
    {
        $adultAmount = 1000;
        $adultAmountSpecial = $adultAmount - 400;
        $adultAmountEvening = $adultAmount - 100;
        $adultAmountHoliday = $adultAmount + 200;

        $childAmount = 500;
        $childAmountSpecial = $childAmount - 100;
        $childAmountEvening = $childAmount - 100;
        $childAmountHoliday = $childAmount + 200;

        $dayOfWeek = $dateTime->format('w');

        $evening = $dateTime->setTime(17, 0, 0);
        $isEvening = ($dateTime >= $evening) && !($dayOfWeek == 0 || $dayOfWeek == 6);

        $isHoliday = $dayOfWeek == 0 || $dayOfWeek == 6;

        $subTotal =  ($adultCount * $adultAmount) + ($childCount * $childAmount);

        $totalAmount = $subTotal;

        if ($isSpecial) {
            $totalAmount =  ($adultCount * $adultAmountSpecial) + ($childCount * $childAmountSpecial);
        } elseif ($isEvening) {
            $totalAmount =  ($adultCount * $adultAmountEvening) + ($childCount * $childAmountEvening);
        } elseif ($isHoliday) {
            $totalAmount =  ($adultCount * $adultAmountHoliday) + ($childCount * $childAmountHoliday);
        }

        if (($adultCount + ($childCount * 0.5)) >= 10) {
            $totalAmount = $totalAmount - round($totalAmount * 0.1);
        }

        return $totalAmount;
    }
}
