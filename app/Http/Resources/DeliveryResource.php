<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'order_id'     => $this->order_id,
            'driver_id'    => $this->driver_id,
            'status'       => $this->status,
            'delivered_at' => $this->delivered_at,
            'created_at'   => $this->created_at,
        ];
    }
}
