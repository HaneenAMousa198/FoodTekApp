<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'      => 'sometimes|required|exists:users,id',
            'delivery_id'  => 'sometimes|nullable|exists:deliveries,id',
            'status'       => 'sometimes|required|string|max:50',
            'total_price'  => 'sometimes|required|numeric|min:0',
            'order_date'   => 'sometimes|required|date',
        ];
    }
}
