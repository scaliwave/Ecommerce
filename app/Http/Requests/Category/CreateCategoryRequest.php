<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:categories,name'],
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'El nombre es requerido.',
			'name.unique' => 'El nombre ya fue tomado.'
		];
	}
}
