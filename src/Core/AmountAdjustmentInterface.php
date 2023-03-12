<?php

namespace src\Core;

use src\Spec\App\Customer;


interface AmountAdjustmentInterface
{
    public function __construct(Customer $peoples);
    public function adjustmentValue(): int;
    public function subTotalAmount(): int;
    public function totalAmount(): int;
    public function adjustmentDetail(): array;
}
