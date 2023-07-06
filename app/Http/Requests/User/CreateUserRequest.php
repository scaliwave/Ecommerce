<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name' => ['required', 'string'],
			'last_name' => ['required', 'string'],
			'number_id' => ['required', 'numeric', 'unique:users,number_id'],
			'email' => ['required', 'email', 'unique:users,email'],
			'cellphone' => ['required', 'numeric', 'unique:users,cellphone'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
			// 'role' => ['required'],
		];
	}

	public function messages()
	{
		return [
			'name.required' => 'El nombre es requerido.',
			'name.string' => 'El nombre no es valido.',

			'last_name.required' => 'El apellido es requerido.',
			'last_name.string' => 'El apellido no es valido.',

			'number_id.required' => 'El documento es requerido.',
			'number_id.numeric' => 'El documento debe ser un número.',
			'number_id.unique' => 'El documento ya fue tomado.',


			'email.required' => 'El correo es requerido.',
			'email.email' => 'El correo debe ser valido.',
			'email.unique' => 'El correo ya fue tomado.',

			'cellphone.required' => 'El número de celular es requerido.',
			'cellphone.numeric' => 'El número de celular debe ser valido.',
			'cellphone.unique' => 'El número de celular ya fue tomado.',

			'password.required' => 'La contraseña es requerida.',
			'password.string' => 'La contraseña debe ser valida.',
			'password.min' => 'La contraseña es muy corta (min 8).',
			'password.confirmed' => 'La contraseña no coincide.',

		];
	}
}
