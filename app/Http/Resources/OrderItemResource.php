<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'order_id' => $this->order_id,
            'menu_id'  => $this->menu_id,
            'quantity' => $this->quantity,
            'price'    => $this->price,
            'menu'     => $this->menu,
        ];
    }
}
