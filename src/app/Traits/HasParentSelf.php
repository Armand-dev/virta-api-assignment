<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasParentSelf
{
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }

    public function pluckChildrenIds()
    {
        return $this->children()->pluck('id');
    }
}
