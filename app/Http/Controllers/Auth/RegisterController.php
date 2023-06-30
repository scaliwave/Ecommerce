<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
	use RegistersUsers;
	protected $redirectTo = RouteServiceProvider::HOME;
	public function __construct()
	{
		$this->middleware('guest');
	}
	// protected function validator(array $data)
	// {
	// 	return Validator::make($data, [
	// 		'name' => ['required', 'string', 'max:255'],
	// 		'last_name' => ['required', 'string', 'max:255'],
	// 		'number_id' => ['required', 'numeric', 'unique:users,number_id'],
	// 		'Cellphone' => ['required', 'numeric', 'unique:users,cellphone'],
	// 		'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
	// 		'password' => ['required', 'string', 'min:8', 'confirmed'],
	// 	]);
	// }
	// protected function create(CreateUserRequest $data)
	// {
	// 	return User::create([
	// 		'name' => $data['name'],
	// 		'last_name' => $data['last_name'],
	// 		'number_id' => $data['number_id'],
	// 		'cellphone' => $data['cellphone'],
	// 		'email' => $data['email'],
	// 		'password' => Hash::make($data['password']),
	// 	]);
	// }

	public function registerUser(CreateUserRequest $request)
	{
		$user = new User($request->all());
		$user->save();
		return back();
	}
}
