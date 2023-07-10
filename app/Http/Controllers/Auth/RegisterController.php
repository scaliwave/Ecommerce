<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\User\RegisterUserRequest;

class RegisterController extends Controller
{
	use RegistersUsers;
	protected $redirectTo = RouteServiceProvider::HOME;
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function registerUser(RegisterUserRequest $request)
	{
		$user = new User($request->all());
		$user->assignRole('user');
		$user->save();
		return back()->with('success', 'Usuario registrado');
	}
}
