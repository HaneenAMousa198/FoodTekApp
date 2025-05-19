<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'staff_id' => $this->staff_id,
            'status' => $this->status,
            'scheduled_at' => $this->scheduled_at,
            'notes' => $this->notes,
        ];
    }
}
