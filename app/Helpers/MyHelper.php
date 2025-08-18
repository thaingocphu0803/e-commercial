<?php

if(!function_exists("write_url")){
    function write_url(string $canonical = '', bool $fullDomain = true, bool $suffix = false){
        if(strpos($canonical, 'http') === 0){
            return $canonical;
        }

        $fullUrl = (($fullDomain === true) ? config('app.url') : '') . "/". $canonical . (($suffix == true) ? config('app.general.suffix') : '');

        return $fullUrl;
    }
}
