<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
 return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'deliveries' => DeliveryResource::collection($this->whenLoaded('deliveries')),
            'chats' => ChatResource::collection($this->whenLoaded('chats')),
            'calls' => CallResource::collection($this->whenLoaded('calls')),
        ];    }
}
