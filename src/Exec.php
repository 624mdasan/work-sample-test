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
            $input['adultCount'],
            $input['childCount'],
            $input['seniorCount'],
            $input['type'],
            $input['dateTime'],
        );

        $this->output($amountAdjustment);
    }

    private function input(): array
    {
        echo '日時を入力してください。何も入力しないと現在の日時が入力されます。（例：2022-06-20 11:45）' . "\n";
        for (; ;) {
            $stdin = trim(fgets(STDIN));

            if (empty($stdin)) {
                $dateTime = new \DateTimeImmutable('', new \DateTimeZone('Asia/Tokyo'));
            }

            $dateTime =  new \DateTimeImmutable($stdin, new \DateTimeZone('Asia/Tokyo'));

            break;
        }

        echo '特別価格ですか？（yes/no）' . "\n";
        for (; ;) {
            $stdin = trim(fgets(STDIN));

            if ($stdin !== 'yes' && $stdin !== 'no') {
                echo '「yes」もしくは「no」で入力してください' . "\n";
                continue;
            }

            if ($stdin === 'yes') {
                $type = 'special';
            } else {
                $type = '';
            }
            break;
        }

        echo '大人の人数を入力してください' . "\n";
        for (; ;) {
            $stdin = trim(fgets(STDIN));

            if (!preg_match('/\A[+-]?[0-9]+\z/', $stdin)) {
                echo '数値を入力してください' . "\n";
                continue;
            }

            $adultCount =  (int)$stdin;
            break;

        }

        echo '子供の人数を入力してください' . "\n";
        for (; ;) {
            $stdin = trim(fgets(STDIN));

            if (!preg_match('/\A[+-]?[0-9]+\z/', $stdin)) {
                echo '数値を入力してください' . "\n";
                continue;
            }

            $childCount =  (int)$stdin;
            break;
        }

        echo 'シニアの人数を入力してください' . "\n";
        for (; ;) {
            $stdin = trim(fgets(STDIN));

            if (!preg_match('/\A[+-]?[0-9]+\z/', $stdin)) {
                echo '数値を入力してください' . "\n";
                continue;
            }

            $seniorCount =  (int)$stdin;
            break;
        }

        return [
            'dateTime' => $dateTime,
            'type' => $type,
            'adultCount' => $adultCount,
            'childCount' => $childCount,
            'seniorCount' => $seniorCount,
        ];
    }

    private function output(AmountAdjustment $amountAdjustment)
    {
        print_r(
            '==== 小計 ===' . "\n" .
            $amountAdjustment->subTotalAmount() . "円\n"
        );

        $detail = $amountAdjustment->adjustmentDetail();

        print_r(
            '=== 明細 ===' . "\n" .
             '・合計人数: ' . $detail['totalPeopleCount'] . " 人\n" .
             '・調整種類: ' . $detail['adjustmentType'] . "\n" .
             '・調整金額: ' . $detail['adjustmentAmount'] . " 円\n"
        );

        print_r(
            '=== 合計金額 ===' . "\n".
            $amountAdjustment->totalAmount() . " 円\n"
        );
    }
}

require_once 'vendor/autoload.php';

$app = new Exec();
$app->exec();
