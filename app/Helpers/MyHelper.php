<?php

// helper write url from canonical
if(!function_exists("write_url")){
    function write_url(string $canonical = '', bool $fullDomain = true, bool $suffix = false){
        if(strpos($canonical, 'http') === 0){
            return $canonical;
        }

        $fullUrl = (($fullDomain === true) ? config('app.url') : '') . "/". $canonical . (($suffix == true) ? config('app.general.suffix') : '');

        return $fullUrl;
    }
}

// helper fomart price number
if(!function_exists("price_format")){
    function price_format($number){
        $map = [
            'vi' => ['symbol' => '₫',  'decimals' => 0],
            'en' => ['symbol' => '$',  'decimals' => 2],
            'zh' => ['symbol' => '¥',  'decimals' => 0],
            'ja' => ['symbol' => '€','decimals' => 2],
        ];

        $locale = app()->getLocale();
        $symbol   = $map[$locale]['symbol'];
        $decimals = $map[$locale]['decimals'];



        $price = number_format(intval($number), $decimals, '.', ',');

        return $price.$symbol;
    }
}

// helper create Seo array
if(!function_exists('seo')){
    function seo($object){
    // dd($object);
        return [
            'meta_title' => $object->meta_title ?? $object->name,
            'meta_keyword' => $object->meta_keyword ?? $object->canonical,
            'meta_description' => Illuminate\Support\Str::limit(strip_tags($object->meta_description), 150),
            'meta_image' => base64_decode($object->image),
            'canonical' => write_url($object->canonical, true ,true)
        ];
    }
}
