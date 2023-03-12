<?php

namespace src\Spec\AmountAdjustment;

use src\Core\AmountAdjustment;
use src\Spec\App\Customer;

class HolidayAmountAdjustment extends AmountAdjustment
{
    public function __construct(protected Customer $customer) {}

    public function type(): string
    {
        return 'holiday';
    }

    public function adjustmentValue(): int
    {
        return 200;
    }
}
