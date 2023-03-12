<?php

namespace src;

use src\Core\AmountAdjustmentInterface;
use src\Spec\AmountAdjustment\DefaultAmountAdjustment;
use src\Spec\AmountAdjustment\EveningAmountAdjustment;
use src\Spec\AmountAdjustment\HolidayAmountAdjustment;
use src\Spec\People\Customer;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;
use src\Spec\People\SeniorPeople;

class AmountAdjustmentFactory
{
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

        $dayOfWeek = $dateTime->format('w');
        $evening = $dateTime->setTime(17, 0, 0);
        $isEvening = ($dateTime >= $evening) && !($dayOfWeek == 0 || $dayOfWeek == 6);
        $isHoliday = $dayOfWeek == 0 || $dayOfWeek == 6;

        if ($isEvening) {
            return new EveningAmountAdjustment($customer);
        } elseif ($isHoliday) {
            return new HolidayAmountAdjustment($customer);
        } else {
            return new DefaultAmountAdjustment($customer);
        }
    }
}
