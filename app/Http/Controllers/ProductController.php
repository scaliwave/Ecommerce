<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

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


	// Admin Product Controllers -------------------------------------------
	public function getAllProducts()
	{
		$products = Product::get();
		return response()->json(['products' => $products], 200);
	}

	public function getAProduct(Product $product)
	{
		$product->load('Category');
		return response()->json(['product' => $product], 200);
	}

	public function saveProduct(CreateProductRequest $request)
	{
		$product = new Product($request->all());
		$this->uploadImages($request, $product);
		$product->save();
		return response()->json(['product' => $product->load('category')], 201);
	}
	public function updateProduct(Product $product, UpdateProductRequest $request)
	{
		$requestAll = $request->all();
		$this->uploadImages($request, $product);
		$requestAll['image'] = $product->image;
		$product->update($requestAll);
		return response()->json(['product' => $product->refresh()->load('Category')], 200);
	}
	public function deleteProduct(Product $product)
	{
		$product->delete();
		return response()->json([], 204);
	}
	private function uploadImages($request, &$product)
	{
		if(!isset($request->image)) return;
		$random = Str::random(20);
		$image_name = "{$random}.{$request->image->clientExtension()}";
		$request->image->move(storage_path('app/public/images'), $image_name);
		$product->image = $image_name;
	}
}
