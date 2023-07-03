<?php

namespace App\Http\Requests\ShoppingCart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopping_CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'product_id' => ['nullable', 'numeric'],
			'user_id' => ['nullable', 'numeric'],
			'cant' => ['required', 'numeric'],
			'price' => ['required', 'numeric'],
        ];
    }
}
