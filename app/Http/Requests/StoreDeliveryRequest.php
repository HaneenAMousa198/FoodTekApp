<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id'    => 'required|exists:orders,id',
            'driver_id'   => 'required|exists:staff,id',
            'status'      => 'required|in:pending,on_the_way,delivered',
            'delivered_at'=> 'nullable|date',
        ];
    }
}
