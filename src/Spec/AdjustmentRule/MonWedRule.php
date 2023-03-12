<?php

namespace src\Spec\AdjustmentRule;

use src\Core\AdjustmentRuleInterface;
use src\Core\AmountAdjustment;
use src\Spec\AmountAdjustment\MonWedAmountAdjustment;
use src\Spec\App\Customer;

class MonWedRule implements AdjustmentRuleInterface
{
    public function match(\DateTimeImmutable $dateTime): bool
    {
        $dayOfWeek = $dateTime->format('w');
        return $dayOfWeek == 1 || $dayOfWeek == 3;
    }

    public function applyAmountAdjustment(Customer $customer): AmountAdjustment
    {
        return new MonWedAmountAdjustment($customer);
    }
}
