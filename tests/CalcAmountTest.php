<?php

use PHPUnit\Framework\TestCase;
use src\CalcAmount;

class CalcAmountTest extends TestCase
{
    public function test_calc_default()
    {
        $calc = new CalcAmount();

        // 通常
        $this->assertSame(1500, $calc->calc(1, 1, false, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(3000, $calc->calc(2, 2, false, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
    }

    public function test_calc_special()
    {
        $calc = new CalcAmount();

        // 特別
        $this->assertSame(1000, $calc->calc(1, 1, true, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(2000, $calc->calc(2, 2, true, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
    }

    public function test_calc_group()
    {
        $calc = new CalcAmount();

        // 団体割引適用テスト
        $this->assertSame(9000, $calc->calc(5, 10, false, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(9500, $calc->calc(5, 9, false, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(9450, $calc->calc(10, 1, false, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(9500, $calc->calc(9, 1, false, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(6300, $calc->calc(5, 10, true, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(6600, $calc->calc(5, 9, true, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(5760, $calc->calc(10, 1, true, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(5800, $calc->calc(9, 1, true, new DateTimeImmutable('2023-03-06 10:00:00', new DateTimeZone('Asia/Tokyo'))));
    }

    public function test_calc_weekday()
    {
        $calc = new CalcAmount();

        // 平日夕方割引
        $this->assertSame(2600, $calc->calc(2, 2, false, new DateTimeImmutable('2023-03-06 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(7650, $calc->calc(5, 10, false, new DateTimeImmutable('2023-03-06 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(8460, $calc->calc(10, 1, false, new DateTimeImmutable('2023-03-06 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(1600, $calc->calc(2, 2, true, new DateTimeImmutable('2023-03-06 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(4950, $calc->calc(5, 10, true, new DateTimeImmutable('2023-03-06 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(4770, $calc->calc(10, 1, true, new DateTimeImmutable('2023-03-06 18:00:00', new DateTimeZone('Asia/Tokyo'))));
    }

    public function test_calc_holiday()
    {
        $calc = new CalcAmount();

        // 土日割増
        $this->assertSame(3800, $calc->calc(2, 2, false, new DateTimeImmutable('2023-03-05 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(11700, $calc->calc(5, 10, false, new DateTimeImmutable('2023-03-05 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(11430, $calc->calc(10, 1, false, new DateTimeImmutable('2023-03-05 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(2800, $calc->calc(2, 2, true, new DateTimeImmutable('2023-03-05 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(9000, $calc->calc(5, 10, true, new DateTimeImmutable('2023-03-05 18:00:00', new DateTimeZone('Asia/Tokyo'))));
        $this->assertSame(7740, $calc->calc(10, 1, true, new DateTimeImmutable('2023-03-05 18:00:00', new DateTimeZone('Asia/Tokyo'))));
    }

}
