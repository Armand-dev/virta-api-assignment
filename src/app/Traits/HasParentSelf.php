<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasParentSelf
{
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }
}
