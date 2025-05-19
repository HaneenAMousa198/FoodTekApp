<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rated;
use App\Http\Requests\StoreRatedRequest;
use App\Http\Requests\UpdateRatedRequest;
use App\Http\Resources\RatedResource;

class RatedController extends Controller
{
    public function index()
    {
        return RatedResource::collection(Rated::with(['user', 'menu'])->get());
    }

    public function store(StoreRatedRequest $request)
    {
        $rated = Rated::create($request->validated());
        return new RatedResource($rated->load(['user', 'menu']));
    }

    public function show(Rated $rated)
    {
        return new RatedResource($rated->load(['user', 'menu']));
    }

    public function update(UpdateRatedRequest $request, Rated $rated)
    {
        $rated->update($request->validated());
        return new RatedResource($rated->load(['user', 'menu']));
    }

    public function destroy(Rated $rated)
    {
        $rated->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
