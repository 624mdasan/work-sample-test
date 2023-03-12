<?php

namespace src\Spec\AdjustmentRule;

use src\Core\AdjustmentRuleInterface;
use src\Core\AmountAdjustment;
use src\Spec\AmountAdjustment\EveningAmountAdjustment;
use src\Spec\App\Customer;

class EveningRule implements AdjustmentRuleInterface
{
    public function match(\DateTimeImmutable $dateTime): bool
    {
        $dayOfWeek = $dateTime->format('w');
        $evening = $dateTime->setTime(17, 0, 0);

        return ($dateTime >= $evening) && !($dayOfWeek == 0 || $dayOfWeek == 6);
    }

    public function applyAmountAdjustment(Customer $customer): AmountAdjustment
    {
        return new EveningAmountAdjustment($customer);
    }
}
