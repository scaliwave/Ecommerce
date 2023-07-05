<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Shopping_CartController;

// Users
Route::group(['prefix' => 'Users', 'controller' => UserController::class], function () {
	Route::get('/GetAllUsers', 'getAllUsers');
	Route::get('/GetAnUser/{user}', 'getAnUser');

	Route::get('/GetAllUsersWithShoppings', 'getAllUsersWithShoppings');

	Route::post('/CreateUser', 'createUser');
	Route::put('/UpdateUser/{user}', 'updateUser');
	Route::delete('/DeleteUser/{user}', 'deleteUser');

});

// Products
Route::group(['prefix' => 'Products', 'controller' => ProductController::class], function () {
	Route::get('/GetProductsByCategories', 'getProductsByCategories');
	Route::get('/GetAllProductsOFCategory/{categoryName}', 'getAllProductsOFCategory');

	Route::get('/GetAllProducts', 'getAllProducts');

});


//shoppings
Route::group(['prefix' => 'ShoppingCart', 'controller' => Shopping_CartController::class], function () {
	Route::post('/CreateShoppingCart', 'createShoppingCart');
	Route::get('/MyCart/{user}', 'getMyShoppingCart');
	Route::put('/UpdateShoppingCart/{user}', 'updateShoppingCart');
	Route::delete('/DeleteShoppingCart/{cart}', 'deleteShoppingCart');

});

// categories
Route::group(['prefix' => 'Categories', 'controller' => CategoryController::class], function () {
	Route::get('/GetAllCategories', 'getAllCategories');

});
