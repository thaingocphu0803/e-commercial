<?php

namespace App\Http\Requests;

use App\Enums\PromotionEnum;
use App\Rules\CheckEndDatePromotion;
use App\Rules\CheckOrderTotalDiscount;
use App\Rules\CheckProductSpecificDiscount;
use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rule =  [
            'name' => 'required',
            'start_date' => 'required',
            'apply_source' => 'required',
            'apply_customer' => 'required'
        ];

        if(empty($this->input('not_end_time')) && !empty($this->input('start_date')) ){
            $rule['end_date'] = ['required', new CheckEndDatePromotion($this->only('start_date', 'end_date'))];
        }

         $method = $this->input('method');

         switch($method){
            case PromotionEnum::ORDER_TOTAL_DISCOUNT:
               $rule['method'] = new CheckOrderTotalDiscount($this->input('promotion'));
                break;
            case PromotionEnum::PRODUCT_SPECIFIC_DISCOUNT:
                 $rule['method'] = new CheckProductSpecificDiscount($this->only('product', 'product_checked'));
                break;
            default:
                $rule['method'] = 'required';
         }

        return $rule;
    }
}
