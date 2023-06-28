<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shopping_Cart;

class Shopping_CartController extends Controller
{
	public function createShoppingCart(Request $request)
	{
		$shopping_cart = new Shopping_Cart($request->all());
		$shopping_cart->save();
		return response()->json(['shopping_cart' => $shopping_cart], 201);
	}
}
