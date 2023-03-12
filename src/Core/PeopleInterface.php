<?php

namespace src\Core;

interface PeopleInterface
{
    const AMOUNT_TYPE_SPECIAL = 'special';

    public function __construct(int $count, string $amountType);

    public function count(): int;

    public function groupCount(): int;

    public function amount(): int;
}
