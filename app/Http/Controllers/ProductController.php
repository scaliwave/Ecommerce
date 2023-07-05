<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	public function showProducts()
	{
		return view('components.AdminProducts.index');
	}
	public function showHomeWithProducts()
	{
		$is_logged = Auth::check();
		$id_user = Auth::id();
		return view('home', compact('is_logged', 'id_user'));
	}

	public function getProductsByCategories()
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
			if (count($productsByCategory[$categoryName]) < 5
				and $product->stock > 0) {
				$productsByCategory[$categoryName][] = $product;
			}
		}

		return response()->json(['productsByCategory' => $productsByCategory], 200);
	}

	public function getAllProductsOFCategory($category_name)
	{
		$is_logged = Auth::check();
		$id_user = Auth::id();

		$category = Category::where('name', $category_name)->first();
		$products = $category->Products;

		// return response()->json(['products' => $products], 200);
		return view('Products.ProductsOFCategory', compact('products', 'category_name','is_logged', 'id_user'));
	}

	public function getAnProduct(Product $product)
	{
		$product->load('Category');
		return response()->json(['product' => $product], 200);
	}
	// Admin Product Controllers
	public function getAllProducts()
	{
		$products = Product::get();
		return response()->json(['products' => $products], 200);
	}

	public function saveProduct(Request $request)
	{
		$product = new Product($request->all());
		$product->save();
		return response()->json(['product' => $product], 200);
	}
}
