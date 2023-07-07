<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;


class UserController extends Controller
{
	public function showUsers()
	{
		return view('components.AdminUsers.index');
	}
	public function getAllUsers()
	{
		$users = User::with('roles')->get();
		return response()->json(['users' => $users], 200);
	}

	public function getAllRoles()
	{
		$roles = Role::all()->pluck('name');
		return response()->json(['roles' => $roles], 200);
	}

	public function getAllUsersWithShoppings()
	{
		$users = User::with('Shopping_Carts.Product')->has('Shopping_Carts.Product')->get();
		return response()->json(['users' => $users], 200);
	}
	public function getAnUser(User $user)
	{
		$user->load('roles');
		$roles = $this->getAllRoles()->original['roles'];
		return response()->json(['user' => $user], 200);
	}
	public function createUser(CreateUserRequest $request)
	{
		try {
			DB::beginTransaction();
			$user = new User($request->all());
			$user->save();
			$user->assignRole($request->role);
			DB::commit();

			if ($request->ajax())
				return response()->json(['user' => $user], 201);
			return back()->with('success', 'Usuario Creado');
		} catch (\Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}
	public function updateUser(User $user, UpdateUserRequest $request)
	{
		try {
			DB::beginTransaction();
			$allRequest = $request->all();
			if (isset($allRequest['password'])) {
				if (!$allRequest['password'])
					unset($allRequest['password']);
			}
			$user->update($request->all());
			$user->syncRoles([$request->role]);

			DB::commit();

			if ($request->ajax())
				return response()->json(['user' => $user->refresh()], 201);
			return back()->with('success', 'Usuario Editado');

		} catch (\Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}
	public function deleteUser(User $user, Request $request)
	{
		if ($user->shopping_carts()->exists()) {
			$user->shopping_carts()->delete(); // Eliminar los carritos de compras asociados al usuario
		}
		$user->delete();
		return response()->json([], 204);
	}
}
