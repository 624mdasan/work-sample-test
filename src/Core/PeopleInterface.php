<?php

namespace src\Core;

interface PeopleInterface
{
    // 特別金額（今後別タイプが追加される想定）
    const AMOUNT_TYPE_SPECIAL = 'special';

    public function __construct(int $count, string $amountType);

    /**
     * 人数
     *
     * @return int
     */
    public function count(): int;


    /**
     * 団体計算するときの人数
     *
     * @return int
     */
    public function groupCount(): int;

    /**
     * 金額
     *
     * @return int
     */
    public function amount(): int;

    /**
     * 金額の種類
     *
     * @return string
     */
    public function amountType(): string;
}
