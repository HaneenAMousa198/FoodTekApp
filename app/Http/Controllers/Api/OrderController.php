<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::with(['user', 'delivery', 'orderItems'])->get());
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        $order->load(['user', 'delivery', 'orderItems']);
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
