<?php

namespace App\Rules;

use App\Models\PostCatalouge;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPostCatalougeChildrenRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     protected $id;

     public function __construct($id)
     {
        $this->id = $id;

     }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $flag = PostCatalouge::isNodeCheck($this->id);

        if($flag == false){
            $fail('Unable to delete: This section has child elements and cannot be removed.');
        }
    }
}
