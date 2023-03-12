<?php

use PHPUnit\Framework\TestCase;
use src\Spec\AdjustmentRule\EveningRule;
use src\Spec\AdjustmentRule\HolidayRule;
use src\Spec\AdjustmentRule\MonWedRule;
use src\Spec\AmountAdjustment\DefaultAmountAdjustment;
use src\Spec\AmountAdjustment\EveningAmountAdjustment;
use src\Spec\AmountAdjustment\HolidayAmountAdjustment;
use src\Spec\AmountAdjustment\MonWedAmountAdjustment;
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
            '月曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-13 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => MonWedAmountAdjustment::class,
            ],
            '月曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-13 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => MonWedAmountAdjustment::class,
            ],
            '火曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-14 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => DefaultAmountAdjustment::class,
            ],
            '火曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-14 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => EveningAmountAdjustment::class,
            ],
            '水曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-15 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => MonWedAmountAdjustment::class,
            ],
            '水曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-15 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => MonWedAmountAdjustment::class,
            ],
            '木曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-16 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => DefaultAmountAdjustment::class,
            ],
            '木曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-16 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => EveningAmountAdjustment::class,
            ],
            '金曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-17 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => DefaultAmountAdjustment::class,
            ],
            '金曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-17 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => EveningAmountAdjustment::class,
            ],
            '土曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-18 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => HolidayAmountAdjustment::class,
            ],
            '土曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-18 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => HolidayAmountAdjustment::class,
            ],
            '日曜11:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-19 11:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => HolidayAmountAdjustment::class,
            ],
            '日曜18:00の場合' => [
                'dateTime' => new \DateTimeImmutable('2023-03-19 18:00', new \DateTimeZone('Asia/Tokyo')),
                'expected' => HolidayAmountAdjustment::class,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_apply
     */
    public function test_apply($dateTime, $expected)
    {
        $adjustmentRule = new AdjustmentRule([
            new EveningRule(),
            new HolidayRule(),
            new MonWedRule()
        ]);

        $this->assertInstanceOf($expected, $adjustmentRule->apply($this->customer, $dateTime));
    }
}
