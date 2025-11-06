<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use function PHPUnit\Framework\isEmpty;

class CheckProductSpecificDiscount implements ValidationRule
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
        $message = [
            1 => __('custom.alertProductGreaterThan0'),
            2 => __('custom.alertAtLestOneProduct'),
        ];

        $productMin = $this->data['product']['min'];
        $productMax = $this->data['product']['max'];
        $productDiscount = $this->data['product']['discount'];

        if(
            ($productMin == 0) ||
            ($productDiscount == 0)
        ){
            $isConflict = 1;
        }

        if(!isset($this->data['product_checked'])){
            $isConflict = 2;
        }

        if($isConflict > 0){
            $fail($message[$isConflict]);
        }
    }
}
