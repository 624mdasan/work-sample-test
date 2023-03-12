<?php

namespace src;

use src\Core\AmountAdjustmentInterface;

class App
{
    public function exec(): void
    {
        $input = $this->input();

        $hoge = new AmountAdjustmentFactory();

        $amountAdjustment = $hoge->create(
            2,
            2,
            2,
            '',
            new \DateTimeImmutable('2023-03-06 10:00:00', new \DateTimeZone('Asia/Tokyo'))
        );

        $this->output($amountAdjustment);
    }

    private function input()
    {
    }

    private function output(AmountAdjustmentInterface $amountAdjustment)
    {
        print_r($amountAdjustment->totalAmount() . "\n");
    }
}

require_once 'vendor/autoload.php';

$app = new App();
$app->exec();
