<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'      => 'required|exists:users,id',
            'delivery_id'  => 'nullable|exists:deliveries,id',
            'status'       => 'required|string|max:50',
            'total_price'  => 'required|numeric|min:0',
            'order_date'   => 'required|date',
        ];
    }
}
