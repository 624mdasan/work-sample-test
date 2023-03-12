<?php

namespace src\Core;

use src\Spec\People\Customer;


interface AmountAdjustmentInterface
{
    public function __construct(Customer $peoples);
    public function match(\DateTimeImmutable $dateTime, bool $isSpecial): bool;
    public function adjustmentValue(): int;
    public function subTotalAmount(): int;
    public function totalAmount(): int;
    public function adjustmentDetail(): array;
}
