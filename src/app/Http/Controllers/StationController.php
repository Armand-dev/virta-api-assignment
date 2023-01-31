<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Traits\StationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StationController extends Controller
{
    use StationTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $models = Station::query()
                        ->with('company')
                        ->get();

        return response()->json($models, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        Station::validate();
        $model = Station::store();

        return response()->json($model, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $station): JsonResponse
    {
        $model = Station::query()
                        ->where('id', $station)
                        ->with('company')
                        ->first();

        return response()->json($model, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Station $station): JsonResponse
    {
        Station::validate();

        $station->update(request()->only('name', 'company_id', 'latitude', 'longitude', 'address'));

        return response()->json($station, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Station $station): JsonResponse
    {
        $station->delete();
        return response()->json([], 200);
    }
}
