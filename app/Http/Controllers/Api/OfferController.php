<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\OfferResource;

class OfferController extends Controller
{
    public function index()
    {
        return OfferResource::collection(Offer::all());
    }

    public function store(StoreOfferRequest $request)
    {
        $offer = Offer::create($request->validated());
        return new OfferResource($offer);
    }

    public function show(Offer $offer)
    {
        return new OfferResource($offer);
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());
        return new OfferResource($offer);
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
