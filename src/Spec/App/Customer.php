<?php

namespace src\Spec\App;

use src\Core\PeopleInterface;

class Customer
{
    /**
     * @param PeopleInterface[] $peoples
     */
    public function __construct(
        public array $peoples
    ) { }

    /**
     * 団体判定
     *
     * @return bool
     */
    public function isGroup(): bool
    {
        $groupCount = 0;
        foreach ($this->peoples as $people) {
            $groupCount += $people->groupCount();
        }

        return $groupCount >= 10;
    }
}
