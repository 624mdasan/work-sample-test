<?php

class App
{
    public function do(): int
    {
        $calcClass = new Calc([
            new AdultNumberPeople(2, false),
            new ChildNumberPeople(2, false)
        ]);

        return $calcClass->calc();
    }
}

class Calc
{
    /**
     * @param NumberPeopleInterface[] $peoples
     */
    public function __construct(
        protected array $peoples
    ) { }

    public function calc(): int
    {
        $amount = 0;

        foreach ($this->peoples as $people) {
            $amount += $people->number() * $people->amount(false);
        }

        return $amount;
    }
}

interface NumberPeopleInterface
{
    public function __construct(int $number, bool $isSpecial);

    public function number(): int;
    public function amount($isSpecial): int;
}

class AdultNumberPeople implements NumberPeopleInterface
{
    public function __construct(
        private readonly int $number,
        private readonly bool $isSpecial
    ) { }

    public function number(): int
    {
        return $this->number;
    }

    public function amount($isSpecial): int
    {
        if ($this->isSpecial) {
            return 600;
        } else {
            return 1000;
        }
    }
}

class ChildNumberPeople implements NumberPeopleInterface
{
    public function __construct(
        private readonly int $number,
        private readonly bool $isSpecial
    ) { }

    public function number(): int
    {
        return $this->number;
    }

    public function amount($isSpecial): int
    {
        if ($this->isSpecial) {
            return 400;
        } else {
            return 500;
        }
    }
}
