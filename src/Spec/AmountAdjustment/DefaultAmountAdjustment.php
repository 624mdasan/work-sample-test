<?php

namespace src\Spec\AmountAdjustment;

use src\Core\AmountAdjustment;
use src\Spec\App\Customer;

class DefaultAmountAdjustment extends AmountAdjustment
{
    public function __construct(protected Customer $customer) {}

    public function adjustmentValue(): int
    {
        return 0;
    }
}
