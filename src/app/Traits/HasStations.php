<?php

namespace App\Traits;

use App\Models\Station;
use Illuminate\Http\JsonResponse;

trait HasStations
{
    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
