<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'staff_id' => 'sometimes|required|exists:staff,id',
            'status' => 'sometimes|required|string|max:50',
            'scheduled_at' => 'sometimes|required|date',
            'notes' => 'nullable|string',
        ];
    }
}
