<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
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

	// Actualizar el producto si se encuentra en el carrito o crear uno nuevo
	public function addOrUpdateToShoppingCart(Request $request)
	{
		$user = auth()->user();
		$product_id = $request->product_id;

		// Obtener el producto y su stock
		$product = Product::find($product_id);
		$stock = $product->stock;

		// Verificar si el producto ya está en el carrito del usuario
		$cart = $user->Shopping_Carts()->where('product_id', $product_id)->first();

		if ($cart) {
			// Calcular la nueva cantidad y verificar si supera el stock
			$new_cant = $cart->cant + $request->cant;
			if ($new_cant > $stock) {
				return response()->json(['error' => 'La cantidad supera el stock del producto'], 400);
			}

			// Actualizar la cantidad y el precio del carrito
			$new_price = $cart->price + $request->price;

			$cart->update([
				'cant' => $new_cant,
				'price' => $new_price
			]);

			return response()->json(['cart' => $cart], 200);
		} else {
			// Verificar si la cantidad supera el stock
			if ($request->cant > $stock) {
				return response()->json(['error' => 'La cantidad supera el stock del producto'], 400);
			}

			// Crear un nuevo registro en el carrito
			$data = [
				'product_id' => $product_id,
				'user_id' => $user->id,
				'cant' => $request->cant,
				'price' => $request->price,
			];

			$shopping_cart = new Shopping_Cart($data);
			$shopping_cart->save();

			return response()->json(['cart' => $shopping_cart], 201);
		}
	}


	public function deleteShoppingCart(User $user, $product)
	{
		$shoppingCart = $user->Shopping_Carts()
			->where('product_id', $product)
			->first();

		if ($shoppingCart) {
			$shoppingCart->delete();
			return response()->json([], 204);
		} else {
			return response()->json(['error' => 'No se encontró el carrito de compras'], 404);
		}
	}
}
