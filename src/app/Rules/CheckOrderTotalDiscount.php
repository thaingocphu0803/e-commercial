<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckOrderTotalDiscount implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
public function validate(string $attribute, mixed $value, Closure $fail): void
{
    $isConflict = 0;
    $duplicate = 0;

    $message = [
        1 => __('custom.alertPriceGreaterThan0'),
        2 => __('custom.alertLessThanTo'),
        3 => __('custom.alertConflictOtherRange'),
        4 => __('custom.alertExistedRange')
    ];

    $price_from = $this->data['price_from'];
    $price_to = $this->data['price_to'];
    $discount = $this->data['discount'];

    $count = count($price_from);

    for ($i = 0; $i < $count; $i++) {
        $currentPriceFrom = floatval($price_from[$i]);
        $currentPriceTo = floatval($price_to[$i]);
        $currentDiscount = floatval($discount[$i]);

        if ($currentPriceFrom == 0 || $currentPriceTo == 0 || $currentDiscount == 0) {
            $isConflict = 1;
            break;
        }

        if ($currentPriceFrom >= $currentPriceTo) {
            $isConflict = 2;
            break;
        }

        for ($j = 0; $j < $count; $j++) {
            if ($i == $j) continue;

            $compareFrom = floatval($price_from[$j]);
            $compareTo = floatval($price_to[$j]);


            if ($currentPriceFrom == $compareFrom && $currentPriceTo == $compareTo) {
                $duplicate++;
            }

            elseif (
                ($currentPriceFrom >= $compareFrom && $currentPriceFrom <= $compareTo) ||
                ($currentPriceTo >= $compareFrom && $currentPriceTo <= $compareTo) ||
                ($currentPriceFrom <= $compareFrom && $currentPriceTo >= $compareTo)
            ) {
                $isConflict = 3;
                break 2;
            }
        }
    }

    if ($duplicate > 0) {
        $isConflict = 4;
    }

    if ($isConflict > 0) {
        $fail($message[$isConflict]);
    }
}

}
