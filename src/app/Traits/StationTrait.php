<?php

namespace App\Traits;

use App\Models\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait StationTrait
{
    public function getStationsInArea(int $latitude= 10, int $longitude = 10, int $distance = 1000, string $unit = 'km'): JsonResponse
    {

        // foreach station
        // if distance < $distance
        //      get
        $stations = [
            [
                // station 1 close
            ],
            [
                // station 1 far
                [
                    //station
                ],
                [
                    //station
                ]
            ],
            [
                // station 2 further
            ],
            [
                // station 3 furthest
            ],
        ];


        $unit == 'km' ? $unitMultiplicator = 1.609344 : $unitMultiplicator = 1;

        $stations = Station::query()
                            ->select([
                                'id',
                                'name',
                                'created_at',
                                DB::raw("
                                (
                                    (
                                        (
                                            ACOS(
                                                SIN($latitude * PI() / 180)
                                                *
                                                SIN(latitude * PI() / 180) + COS($latitude * PI() / 180)
                                                *
                                                COS(latitude * PI() / 180) * COS(($longitude - longitude) * PI() / 180)
                                            )
                                        ) * 180 / PI()
                                    ) * 60 * 1.1515 * $unitMultiplicator
                                ) AS distance
                                ")
                            ])
                            ->having('distance', '<=', $distance)
                            ->orderBy('distance', 'ASC')
                            ->get();


        $insideCounter = 0;
        $lastKey = 0;
        $formattedArray = [];
        $lastDistance = -1;
        foreach ($stations as $key => $station) {
            if ($station->distance == $lastDistance)
            {
                if ($insideCounter == 0)
                {
                    $auxValue = $formattedArray[$lastKey];
                    $formattedArray[$lastKey] = [];
                    $formattedArray[$lastKey][$insideCounter] = $auxValue;
                    dd($formattedArray[$lastKey]);
                }
                $formattedArray[$lastKey][$insideCounter++] = $station;
            }
            else
            {
                $formattedArray[$key] = $station;
                $lastKey = $key;
                $lastDistance = $station->distance;
            }
        }
        $stations = array_values($stations->toArray());
        return response()->json($stations, 200);
    }
}
