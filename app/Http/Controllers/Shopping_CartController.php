<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Shopping_Cart;
use Illuminate\Support\Facades\Auth;

class Shopping_CartController extends Controller
{
	public function createShoppingCart(Request $request)
	{
		$shopping_cart = new Shopping_Cart($request->all());
		$shopping_cart->save();
		response()->json(['shopping_cart' => $shopping_cart], 201);
	}
	public function getMyShoppingCart(User $user)
	{
		$id_user = Auth::user()->id;
		$products = $user->Shopping_Carts()->with('Product')->get();
		return view('ShoppingCarts.shoppingCart', compact('products', 'id_user'));
	}

	public function updateShoppingCart(User $user, Request $request)
	{
		$requestAll = $request->all();

		// Obtener el carrito de compras específico del usuario y producto
		$cart = $user->Shopping_Carts()->where('product_id', $request->product_id)->first();

		// Verificar si se encontró el carrito y pertenece al usuario actual
		if ($cart) {
			$cart->update($requestAll);
			return response()->json(['cart' => $cart], 201);
		} else {
			return response()->json(['error' => 'No se encontró el carrito de compras'], 404);
		}
	}
	public function deleteShoppingCart(User $user, $product)
	{
		$shoppingCart = $user->Shopping_Carts()
			->where('product_id', $product)
			->first();
			
		if ($shoppingCart) {
			$shoppingCart->delete();
		} else {
			return response()->json(['error' => 'No se encontró el carrito de compras'], 404);
		}
	}
}
