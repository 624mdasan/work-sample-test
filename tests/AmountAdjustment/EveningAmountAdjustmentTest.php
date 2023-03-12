<?php

use PHPUnit\Framework\TestCase;
use src\Core\PeopleInterface;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;
use src\Spec\People\SeniorPeople;
use src\Spec\People\Customer;
use src\Spec\AmountAdjustment\EveningAmountAdjustment;

class EveningAmountAdjustmentTest extends TestCase
{
    /**
     * dataProvider
     */
    public function dataProvider_subTotalAmount()
    {
        return [
            [1, 0, 0, '', 1000],
            [0, 1, 0, '', 500],
            [0, 0, 1, '', 800],
            [1, 1, 1, '', 2300],
            [2, 2, 2, '', 4600],
            [4, 4, 4, '', 9200], // 団体
        ];
    }

    /**
     * @dataProvider dataProvider_subTotalAmount
     */
    public function test_subTotalAmount_default($adultCount, $childCount, $seniorCount, $amountType, $expected)
    {
        $customer = new Customer([
            new AdultPeople($adultCount, $amountType),
            new ChildPeople($childCount, $amountType),
            new SeniorPeople($seniorCount, $amountType),
        ]);

        $adjustment = new EveningAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->subTotalAmount());
    }
    /**
     * dataProvider
     */
    public function dataProvider_totalAmount()
    {
        return [
            [1, 0, 0, '', 900],
            [0, 1, 0, '', 400],
            [0, 0, 1, '', 700],
            [1, 1, 1, '', 2000],
            [2, 2, 2, '', 4000],
            [4, 4, 4, '', 7200], // 団体
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

        $adjustment = new EveningAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->totalAmount());
    }

    /**
     * dataProvider
     */
    public function dataProvider_totalAmount_special()
    {
        return [
            [1, 0, 0, PeopleInterface::AMOUNT_TYPE_SPECIAL, 500],
            [0, 1, 0, PeopleInterface::AMOUNT_TYPE_SPECIAL, 300],
            [0, 0, 1, PeopleInterface::AMOUNT_TYPE_SPECIAL, 400],
            [1, 1, 1, PeopleInterface::AMOUNT_TYPE_SPECIAL, 1200],
            [2, 2, 2, PeopleInterface::AMOUNT_TYPE_SPECIAL, 2400],
            [4, 4, 4, PeopleInterface::AMOUNT_TYPE_SPECIAL, 4320], // 団体
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

        $adjustment = new EveningAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->totalAmount());
    }
}
