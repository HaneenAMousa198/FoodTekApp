<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;

class AddressController extends Controller
{
    public function index()
    {
        return AddressResource::collection(Address::all());
    }

    public function store(StoreAddressRequest $request)
    {
        $address = Address::create($request->validated());
        return new AddressResource($address);
    }

    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());
        return new AddressResource($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
