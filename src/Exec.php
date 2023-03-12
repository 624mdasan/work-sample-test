<?php

namespace src;

use src\Core\AmountAdjustment;

class Exec
{
    public function exec(): void
    {
        $input = $this->input();

        $factory = new AmountAdjustmentFactory();

        $amountAdjustment = $factory->create(
            2,
            2,
            2,
            '',
            new \DateTimeImmutable('2023-03-12 10:00:00', new \DateTimeZone('Asia/Tokyo'))
        );

        $this->output($amountAdjustment);
    }

    private function input()
    {
    }

    private function output(AmountAdjustment $amountAdjustment)
    {
        print_r($amountAdjustment->totalAmount() . "\n");
    }
}

require_once 'vendor/autoload.php';

$app = new Exec();
$app->exec();
