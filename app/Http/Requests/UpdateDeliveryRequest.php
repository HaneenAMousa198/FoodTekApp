<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id'     => 'sometimes|required|exists:orders,id',
            'driver_id'    => 'sometimes|required|exists:staff,id',
            'status'       => 'sometimes|required|in:pending,on_the_way,delivered',
            'delivered_at' => 'nullable|date',
        ];
    }
}
