<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'staff_id' => 'required|exists:staff,id',
            'status' => 'required|string|max:50',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }
}
