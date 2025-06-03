<?php

namespace App\Repositories;

use App\Models\System;
use App\Repositories\Interfaces\SystemRepositoryInterface;

class SystemRepository implements SystemRepositoryInterface {

    public function updateOrInsert($payload, $condition){
        return System::updateOrInsert($condition, $payload);
    }

    public function getAll(){
        $result = System::all();

        if(count($result) === 0 ) return false;

        foreach($result as $config){
            $systemConfig[$config->keyword] = $config->content;
        }

        return $systemConfig;
    }
}
