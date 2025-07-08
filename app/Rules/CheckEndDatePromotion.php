<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckEndDatePromotion implements ValidationRule
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
        $start = Carbon::parse($this->data['start_date'])->format('Y-m-d H:i:s');
        $end = Carbon::parse($this->data['end_date'])->format('Y-m-d H:i:s');

        if ($start >= $end) {
            $fail(__('custom.alertDatetime'));
        }
    }
}
