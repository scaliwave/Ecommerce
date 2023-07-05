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

	public function registerUser(CreateUserRequest $request)
	{
		$user = new User($request->all());
		$user->save();
		return back()->with('success', 'Usuario registrado');
	}
}
