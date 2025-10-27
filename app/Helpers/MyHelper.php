<?php

// helper write url from canonical

if (!function_exists("write_url")) {
    function write_url(string $canonical = '', bool $fullDomain = true, bool $suffix = false)
    {
        if (strpos($canonical, 'http') === 0) {
            return $canonical;
        }

        $fullUrl = (($fullDomain === true) ? config('app.url') : '') . "/" . $canonical . (($suffix == true) ? config('app.general.suffix') : '');

        return $fullUrl;
    }
}

// helper fomart price number
if (!function_exists("price_format")) {
    function price_format($number, $onlyNumber = false)
    {
        $map = [
            'vi' => ['symbol' => '₫',  'decimals' => 0],
            'en' => ['symbol' => '$',  'decimals' => 2],
            'zh' => ['symbol' => '¥',  'decimals' => 0],
            'ja' => ['symbol' => '€', 'decimals' => 2],
        ];

        $locale = app()->getLocale();
        $symbol   = $map[$locale]['symbol'];
        $decimals = $map[$locale]['decimals'];



        $price = number_format(intval($number), $decimals, '.', ',');
        if($onlyNumber){
            return $price;
        }
        return $price . $symbol;
    }
}


// helper caculate discount
if (!function_exists('caculate_discount_price')) {
    function caculate_discount_price($originalPrice, $discountType, $maxDiscountValue, $discountValue)
    {
        $discount = 0;
        if ($maxDiscountValue > 0) {
            $discount = $maxDiscountValue;
        } else {
            if ($discountType === 'amount') {
                $discount = $discountValue;
            } else if ($discountType === 'percent') {
                $discount =  $originalPrice *  ($discountValue / 100);
            }
        }

        return $originalPrice - $discount;
    }
}

// helper create Seo array
if (!function_exists('seo')) {
    function seo($object)
    {
        return [
            'meta_title' => $object->meta_title ?? $object->name,
            'meta_keyword' => $object->meta_keyword ?? $object->canonical,
            'meta_description' => Illuminate\Support\Str::limit(strip_tags($object->meta_description), 150),
            'meta_image' => base64_decode($object->image),
            'canonical' => write_url($object->canonical, true, true)
        ];
    }
}

// helper caculate cart total by label
if (!function_exists('caculate_cart_total')) {
    function caculate_cart_total($cart, $lable, $isNUmber = false)
    {
        switch ($lable) {
            case 'grand':
                $grandTotal = 0;
                $qty_price = $cart->pluck('qty', 'price');
                foreach ($qty_price as $qty => $price) {
                    $grandTotal += (intval($qty) * $price);
                }

                if ($isNUmber) {
                    $grandTotal =  floatval($grandTotal);
                } else {
                    $grandTotal =  price_format($grandTotal);
                }
                return  $grandTotal;

            case 'qty':
                return  $cart->sum('qty');

            case 'discount':
                $discount_array = $cart->pluck('options.discount');
                $qty_array = $cart->pluck('qty');
                $totalDiscount = 0;
                foreach ($discount_array as $key => $val) {
                    $totalDiscount += (intval($val) * intval($qty_array[$key]));
                }


                if ($isNUmber) {
                    $totalDiscount =  floatval($totalDiscount);
                } else {
                    $totalDiscount =  price_format($totalDiscount);
                }
                return  $totalDiscount;
            default:
                break;
        }
    }
}
