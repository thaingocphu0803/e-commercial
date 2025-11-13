<?php

namespace App\Traits;

use Carbon\Carbon;

trait QueryScope
{
    public function scopeKeyword($query, $keyword, $fieldSearch = [])
    {
        if (!empty($keyword)) {

            if(!empty($fieldSearch)){
                foreach($fieldSearch as $field){
                    $query->orWhere($field,'like', "%$keyword%");
                }
            }else{
                $query->where('name', 'like', "%$keyword%");
            }
        }

        return $query;
    }

    public function scopePublish($query, $publish)
    {
        if (!empty($publish)) {
            $query->where('publish', $publish);
        }

        return $query;
    }

    public function scopeCustomDropdownFilter($query, $conditions) {
        if(!empty($conditions)){
            foreach($conditions as $key => $val){
                if($val != 'nonce' && !empty($val)){
                    $query->Where($key, '=' ,$val);
                }
            }

            return $query;
        }
    }

    public function scopeDateRangeFilter($query, $dateRange){
        if(!empty($dateRange)){
            [$start, $end] = explode('-', $dateRange);
            $startDate =  Carbon::parse(trim($start))->startOfDay()->format('Y-m-d H:i:s');
            $endDate =  Carbon::parse(trim($end))->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query;
    }
}
