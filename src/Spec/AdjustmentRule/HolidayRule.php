<?php

namespace src\Spec\AdjustmentRule;

use src\Core\AdjustmentRuleInterface;
use src\Core\AmountAdjustment;
use src\Spec\AmountAdjustment\HolidayAmountAdjustment;
use src\Spec\App\Customer;

class HolidayRule implements AdjustmentRuleInterface
{
    public function match(\DateTimeImmutable $dateTime): bool
    {
        $dayOfWeek = $dateTime->format('w');
        return $dayOfWeek == 0 || $dayOfWeek == 6;
    }

    public function applyAmountAdjustment(Customer $customer): AmountAdjustment
    {
        return new HolidayAmountAdjustment($customer);
    }
}
