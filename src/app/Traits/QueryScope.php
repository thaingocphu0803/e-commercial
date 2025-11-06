<?php

namespace App\Traits;

trait QueryScope
{
    public function scopeKeyword($query, $keyword)
    {
        if (!empty($keyword)) {
          return $query->where('name', 'like', "%$keyword%");
        }
    }

    public function scopePublish($query, $publish)
    {
        if (!empty($publish)) {
            return $query->where('publish', $publish);
        }
    }
}
