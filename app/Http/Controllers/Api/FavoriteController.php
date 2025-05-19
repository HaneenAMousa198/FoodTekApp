<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Http\Resources\FavoriteResource;

class FavoriteController extends Controller
{
    public function index()
    {
        return FavoriteResource::collection(Favorite::all());
    }

    public function store(StoreFavoriteRequest $request)
    {
        $favorite = Favorite::create($request->validated());
        return new FavoriteResource($favorite);
    }

    public function show(Favorite $favorite)
    {
        return new FavoriteResource($favorite);
    }

    public function update(UpdateFavoriteRequest $request, Favorite $favorite)
    {
        $favorite->update($request->validated());
        return new FavoriteResource($favorite);
    }

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
