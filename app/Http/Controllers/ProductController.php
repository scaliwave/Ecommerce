<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	public function showHomeWithProducts()
	{
		$is_logged = Auth::check();
		$id_user = Auth::id();
		return view('home', compact('is_logged', 'id_user'));
	}

	public function getProductsByCategory()
	{
		$products = Product::with('category')->get();
		$productsByCategory = [];

		// se recorren las categorias
		foreach ($products as $product) {
			$categoryName = $product->category->name;

			// si existe la categoria se crea arreglo para guardar productos
			if (!isset($productsByCategory[$categoryName])) {
				$productsByCategory[$categoryName] = [];
			}
			// se condiciona que sean solo 5 productos y que haya stock de ese producto
			if (
				count($productsByCategory[$categoryName]) < 5
				and $product->stock > 0
			) {
				$productsByCategory[$categoryName][] = $product;
			}
		}

		return $productsByCategory;
	}

	public function getAnProduct(Product $product)
	{
		$product->load('Category');
		return response()->json(['product' => $product], 200, );
	}
}
