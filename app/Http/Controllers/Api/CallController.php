<?php

namespace App\Http\Controllers\Api;

use App\Models\Call;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCallRequest;
use App\Http\Requests\UpdateCallRequest;
use App\Http\Resources\CallResource;

class CallController extends Controller
{
    public function index()
    {
        return CallResource::collection(Call::all());
    }

    public function store(StoreCallRequest $request)
    {
        $call = Call::create($request->validated());
        return new CallResource($call);
    }

    public function show(Call $call)
    {
        return new CallResource($call);
    }

    public function update(UpdateCallRequest $request, Call $call)
    {
        $call->update($request->validated());
        return new CallResource($call);
    }

    public function destroy(Call $call)
    {
        $call->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
