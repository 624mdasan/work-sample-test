<?php

use PHPUnit\Framework\TestCase;
use src\Core\PeopleInterface;
use src\Spec\AmountAdjustment\DefaultAmountAdjustment;
use src\Spec\App\Customer;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;
use src\Spec\People\SeniorPeople;

class DefaultAmountAdjustmentTest extends TestCase
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

        $adjustment = new DefaultAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->subTotalAmount());
    }

    /**
     * dataProvider
     */
    public function dataProvider_totalAmount()
    {
        return [
            [1, 0, 0, '', 1000],
            [0, 1, 0, '', 500],
            [0, 0, 1, '', 800],
            [1, 1, 1, '', 2300],
            [2, 2, 2, '', 4600],
            [4, 4, 4, '', 8280], // 団体
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

        $adjustment = new DefaultAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->totalAmount());
    }

    /**
     * dataProvider
     */
    public function dataProvider_totalAmount_special()
    {
        return [
            [1, 0, 0, PeopleInterface::AMOUNT_TYPE_SPECIAL, 600],
            [0, 1, 0, PeopleInterface::AMOUNT_TYPE_SPECIAL, 400],
            [0, 0, 1, PeopleInterface::AMOUNT_TYPE_SPECIAL, 500],
            [1, 1, 1, PeopleInterface::AMOUNT_TYPE_SPECIAL, 1500],
            [2, 2, 2, PeopleInterface::AMOUNT_TYPE_SPECIAL, 3000],
            [4, 4, 4, PeopleInterface::AMOUNT_TYPE_SPECIAL, 5400], // 団体
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

        $adjustment = new DefaultAmountAdjustment($customer);

        $this->assertSame($expected, $adjustment->totalAmount());
    }
}
