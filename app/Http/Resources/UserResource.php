<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * تحويل بيانات المستخدم إلى JSON.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'full_name'    => $this->full_name,
            'email'        => $this->email,
            'phone_number' => $this->phone_number,
            'birth_date'   => $this->birth_date,
            'role'         => new RoleResource($this->whenLoaded('role')),
        ];
    }
}
