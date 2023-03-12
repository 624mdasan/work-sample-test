<?php

use PHPUnit\Framework\TestCase;
use src\Spec\AdjustmentRule\EveningRule;
use src\Spec\AdjustmentRule\HolidayRule;
use src\Spec\AmountAdjustment\DefaultAmountAdjustment;
use src\Spec\AmountAdjustment\EveningAmountAdjustment;
use src\Spec\AmountAdjustment\HolidayAmountAdjustment;
use src\Spec\App\AdjustmentRule;
use src\Spec\App\Customer;
use src\Spec\People\AdultPeople;
use src\Spec\People\ChildPeople;
use src\Spec\People\SeniorPeople;

class AdjustmentRuleTest extends TestCase
{
    public Customer $customer;

    protected function setUp(): void {
        $this->customer = new Customer([
            new AdultPeople(2, ''),
            new ChildPeople(2, ''),
            new SeniorPeople(2, ''),
        ]);
    }

    public function dataProvider_apply(): array
    {
        return [
            '平日夕方の場合' => [
                'adjustmentRule' => new AdjustmentRule([
                    new EveningRule(),
                    new HolidayRule(),
                ]),
                'dateTime' => new \DateTimeImmutable('2023-03-01 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => EveningAmountAdjustment::class,
            ],
            '休日日中の場合' => [
                'adjustmentRule' => new AdjustmentRule([
                    new EveningRule(),
                    new HolidayRule(),
                ]),
                'dateTime' => new \DateTimeImmutable('2023-03-12 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => HolidayAmountAdjustment::class,
            ],
            '休日夕方の場合' => [
                'adjustmentRule' => new AdjustmentRule([
                    new EveningRule(),
                    new HolidayRule(),
                ]),
                'dateTime' => new \DateTimeImmutable('2023-03-12 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => HolidayAmountAdjustment::class,
            ],
            'ルールに当てはまらない場合' => [
                'adjustmentRule' => new AdjustmentRule([
                    new EveningRule(),
                    new HolidayRule(),
                ]),
                'dateTime' => new \DateTimeImmutable('2023-03-01 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => DefaultAmountAdjustment::class,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_apply
     */
    public function test_apply($adjustmentRule, $dateTime, $expected)
    {
        $this->assertInstanceOf($expected, $adjustmentRule->apply($this->customer, $dateTime));
    }
}
