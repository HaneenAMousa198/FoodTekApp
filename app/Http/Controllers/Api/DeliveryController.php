<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Http\Resources\DeliveryResource;

class DeliveryController extends Controller
{
    public function index()
    {
        return DeliveryResource::collection(Delivery::all());
    }

    public function store(StoreDeliveryRequest $request)
    {
        $delivery = Delivery::create($request->validated());
        return new DeliveryResource($delivery);
    }

    public function show(Delivery $delivery)
    {
        return new DeliveryResource($delivery);
    }

    public function update(UpdateDeliveryRequest $request, Delivery $delivery)
    {
        $delivery->update($request->validated());
        return new DeliveryResource($delivery);
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
