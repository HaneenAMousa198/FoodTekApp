<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|exists:users,id',
            'is_read' => 'nullable|boolean',
        ];
    }
}
