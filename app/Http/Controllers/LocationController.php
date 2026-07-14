<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        $location = Location::create($request->validated());

        return response()->json($location, 201);
    }

    public function index()
    {
        return response()->json(Location::all(), 200);
    }
}
