<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price'    => 'required|numeric|min:0',
        ];
    }
}
