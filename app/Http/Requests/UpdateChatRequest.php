<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChatRequest extends FormRequest
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
            'message' => 'sometimes|required|string',
            'is_read' => 'sometimes|boolean',
        ];
    }
}
