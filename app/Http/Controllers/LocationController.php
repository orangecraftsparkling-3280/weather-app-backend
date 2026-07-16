<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        $validated = $request->validated();

        // 同じ 'city_name' があればそれを取得、なければ新規作成
        $location = Location::firstOrCreate(
            ['city_name' => $validated['city_name']], // 検索条件
            [
                'country_code' => $validated['country_code'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ] // 新規作成時のデータ
        );

        // 新規作成された場合は 201、すでにあって取得しただけの場合は 200 を返す
        return response()->json($location, $location->wasRecentlyCreated ? 201 : 200);
    }

    public function index()
    {
        return response()->json(Location::all(), 200);
    }
}
