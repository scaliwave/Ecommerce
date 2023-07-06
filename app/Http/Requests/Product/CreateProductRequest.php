<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'category_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
			'description' => ['required', 'string', 'max:255'],
			'image' => ['required'],
			'price' => ['required', 'numeric'],
			'stock' => ['required', 'numeric'],
        ];
    }

	public function messages()
	{
		return [
			'category_id.required' => 'La categoria es requerida.',
			'category_id.numeric' => 'La categoria debe ser numerica.',

			'name.required' => 'El nombre es requerido.',
			'name.string' => 'El nombre no es valido.',

			'description.required' => 'La descripción es requerida.',
			'description.string' => 'La descripción no es valida',
			'description.max' => 'La descripción es muy larga (max 255 caracteres)',
			'image.required' => 'La imagen es requerida',

			'price.required' => 'El precio es requerido',
			'price.numeric' => 'El precio debe ser valido.',
			
			'stock.required' => 'El stock es requerido',
			'stock.numeric' => 'El stock debe ser valido'
		];
	}
}
