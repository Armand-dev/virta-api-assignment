<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait StationTrait
{
    /**
     * @return JsonResponse
     */
    public function getStationsInArea(): JsonResponse
    {
        $stations = self::queryStationsInArea(
            request()->input('latitude'),
            request()->input('longitude'),
            request()->input('distance'),
            request()->input('unit'),
            request()->input('company_id'),
        )->toArray();

        self::prepareResponseArray($stations);

        return response()->json($stations, 200);
    }

    /**
     * @param int $latitude
     * @param int $longitude
     * @param int $distance
     * @param string $unit
     * @param int $companyId
     * @return Collection | JsonResponse
     */
    private static function queryStationsInArea(int $latitude, int $longitude, int $distance, string $unit, int $companyId): Collection | JsonResponse
    {
        $unit == 'km' ? $unitMultiplicator = 1.609344 : $unitMultiplicator = 1;

        // Get companies of interest, give company and its children
        $companyTree = [
            ...[$companyId],
            ...Company::findOrFail($companyId)->pluckChildrenIds()
        ];

        return Station::query()
                        ->whereIn('company_id', $companyTree)
                        ->select([
                            'id',
                            'name',
                            'company_id',
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
    }

    /**
     * @param array $array
     * @return void
     */
    private static function prepareResponseArray(array &$array): void
    {
        foreach ($array as $key => $item)
        {
            // make element group (even if it only contains one item)
            $array[$key] = [];
            $array[$key][] = $item;
        }

        $lastDistance = -1;
        $lastKey = 0;
        foreach ($array as $key => $item)
        {
            if ($item[0]['distance'] == $lastDistance)
            {
                $array[$lastKey][] = $item[0];
                unset($array[$key]);
                continue;
            }

            $lastDistance = $item[0]['distance'];
            $lastKey = $key;
        }

        $array = array_values($array);
    }
}
