<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'delivery_id' => $this->delivery_id,
            'status'      => $this->status,
            'total_price' => $this->total_price,
            'order_date'  => $this->order_date,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'user'        => $this->user ? $this->user->full_name : null,
            'delivery'    => $this->delivery,
            'order_items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
