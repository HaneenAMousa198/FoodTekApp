<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'message'  => $this->message,
            'user_id'  => $this->user_id,
            'is_read'  => (bool)$this->is_read,
            'created_at' => $this->created_at,
            'user'     => $this->user ? $this->user->full_name : null,
        ];
    }
}
