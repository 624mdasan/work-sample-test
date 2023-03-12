<?php

namespace src\Core;

use src\Spec\App\Customer;

interface AdjustmentRuleInterface
{
    public function match(\DateTimeImmutable $dateTime): bool;
    public function applyAmountAdjustment(Customer $customer): AmountAdjustmentInterface;
}
