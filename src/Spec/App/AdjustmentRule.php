<?php

namespace src\Spec\App;

use src\Core\AdjustmentRuleInterface;
use src\Core\AmountAdjustment;
use src\Spec\AmountAdjustment\DefaultAmountAdjustment;

class AdjustmentRule
{
    /**
     * @param AdjustmentRuleInterface[] $rules
     */
    public function __construct(
        protected array $rules
    ) { }

    public function apply(Customer $customer, \DateTimeImmutable $dateTime): AmountAdjustment
    {
        // 条件に一致しない場合デフォルト設定を適用
        $amountAdjustment = new DefaultAmountAdjustment($customer);
        foreach ($this->rules as $rule) {
            if ($rule->match($dateTime)) {
                $amountAdjustment = $rule->applyAmountAdjustment($customer);
            }
        }

        return $amountAdjustment;
    }
}
