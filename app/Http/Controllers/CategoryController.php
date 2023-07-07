<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Category\CreateCategoryRequest;

class CategoryController extends Controller
{
	public function showCategories()
	{
		return view('components.AdminCategories.index');
	}
    public function getAllCategories()
	{
		$categories = Category::get();
		return response()->json(['categories' => $categories], 200);
	}
	public function createCategory(CreateCategoryRequest $request)
	{
		$category = new Category($request->all());
		$category->save();

		return response()->json(['category' => $category], 201);
	}

	public function updateCategory(Category $category, UpdateCategoryRequest $request)
	{
		$requestAll = $request->all();
		$category->update($requestAll);
		return response()->json(['category' => $category], 201);
	}

	public function deleteCategory(Category $category)
	{
		$category->products()->delete(); // eliminar primero los productos de esa categoria 
		$category->delete();
		return response()->json([], 204);
	}
}
