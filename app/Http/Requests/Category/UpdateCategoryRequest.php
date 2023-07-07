<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', "unique:categories,name,{$this->category->id}"],
        ];
    }
	public function messages()
	{
		return [
			'name.required' => 'El nombre es requerido.',
			'name.unique' => 'El nombre ya fue tomado',
		];
	}
}
