<?php

namespace src;

use src\Core\AmountAdjustmentInterface;
use src\Spec\AmountAdjustment\DefaultAmountAdjustment;
use src\Spec\People\Customer;
use src\Spec\AmountAdjustment\EveningAmountAdjustment;
use src\Spec\AmountAdjustment\HolidayAmountAdjustment;


class AmountAdjustmentFactory
{
    public AmountAdjustmentInterface $applyRule;

    public function __construct(
        private readonly Customer $customer,
        private readonly \DateTimeImmutable $dateTime,
    )
    {
        $this->applyRule = $this->createApplyRule($dateTime);
    }

    private function createApplyRule(\DateTimeImmutable $dateTime): AmountAdjustmentInterface
    {
        $dayOfWeek = $dateTime->format('w');
        $evening = $dateTime->setTime(17, 0, 0);
        $isEvening = ($dateTime >= $evening) && !($dayOfWeek == 0 || $dayOfWeek == 6);
        $isHoliday = $dayOfWeek == 0 || $dayOfWeek == 6;

        if ($isEvening) {
            return new EveningAmountAdjustment($this->customer);
        } elseif ($isHoliday) {
            return new HolidayAmountAdjustment($this->customer);
        } else {
            return new DefaultAmountAdjustment($this->customer);
        }
    }

    public function subTotalAmount()
    {
        return $this->applyRule->subTotalAmount();
    }

    public function totalAmount()
    {
        return $this->applyRule->totalAmount();
    }

    // 明細
    public function applyDetail()
    {

    }
}
