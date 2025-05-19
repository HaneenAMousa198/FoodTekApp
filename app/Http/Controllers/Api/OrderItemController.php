<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;

class OrderItemController extends Controller
{
    public function index()
    {
        return OrderItemResource::collection(OrderItem::with('menu')->get());
    }

    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = OrderItem::create($request->validated());
        return new OrderItemResource($orderItem);
    }

    public function show(OrderItem $orderItem)
    {
        $orderItem->load('menu');
        return new OrderItemResource($orderItem);
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->validated());
        return new OrderItemResource($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
