<?php

use PHPUnit\Framework\TestCase;
use src\Core\PeopleInterface;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;
use src\Spec\People\SeniorPeople;
use src\Spec\People\Customer;
use src\Spec\AmountAdjustment\HolidayAmountAdjustment;

class HolidayAmountAdjustmentTest extends TestCase
{
    /**
     * dataProvider
     */
    public function dataProvider_totalAmount()
    {
        return [
            [1, 0, 0, '', 1200],
            [0, 1, 0, '', 700],
            [0, 0, 1, '', 1000],
            [1, 1, 1, '', 2900],
            [2, 2, 2, '', 5800],
            [4, 4, 4, '', 10440], // 団体
        ];
    }

    /**
     * @dataProvider dataProvider_totalAmount
     */
    public function test_totalAmount_default($adultCount, $childCount, $seniorCount, $amountType, $expected)
    {
        $customer = new Customer([
            new AdultPeople($adultCount, $amountType),
            new ChildPeople($childCount, $amountType),
            new SeniorPeople($seniorCount, $amountType),
        ]);

        $adjustment = new HolidayAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->totalAmount());
    }

    /**
     * dataProvider
     */
    public function dataProvider_totalAmount_special()
    {
        return [
            [1, 0, 0, PeopleInterface::AMOUNT_TYPE_SPECIAL, 800],
            [0, 1, 0, PeopleInterface::AMOUNT_TYPE_SPECIAL, 600],
            [0, 0, 1, PeopleInterface::AMOUNT_TYPE_SPECIAL, 700],
            [1, 1, 1, PeopleInterface::AMOUNT_TYPE_SPECIAL, 2100],
            [2, 2, 2, PeopleInterface::AMOUNT_TYPE_SPECIAL, 4200],
            [4, 4, 4, PeopleInterface::AMOUNT_TYPE_SPECIAL, 7560], // 団体
        ];
    }

    /**
     * @dataProvider dataProvider_totalAmount_special
     */
    public function test_totalAmount_special($adultCount, $childCount, $seniorCount, $amountType, $expected)
    {
        $customer = new Customer([
            new AdultPeople($adultCount, $amountType),
            new ChildPeople($childCount, $amountType),
            new SeniorPeople($seniorCount, $amountType),
        ]);

        $adjustment = new HolidayAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->totalAmount());
    }
}
