<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest
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
            'message' => 'required|string',
            'is_read' => 'sometimes|boolean',
        ];
    }
}
