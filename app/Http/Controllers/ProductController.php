<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function showHomeWithProducts()
	{
		$productsByCategory = $this->getProductsByCategory();
		return view('home', compact('productsByCategory'));
	}

	public function getProductsByCategory()
	{
		$products = Product::with('category')->get();
		$productsByCategory = [];

		foreach ($products as $product) {
			$categoryName = $product->category->name;

			if (!isset($productsByCategory[$categoryName])) {
				$productsByCategory[$categoryName] = [];
			}

			if (count($productsByCategory[$categoryName]) < 5) {
				$productsByCategory[$categoryName][] = $product;
			}
		}

		return $productsByCategory;
	}
}
