<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
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
	Route::get('/GetProductsByCategory', 'getProductsByCategory');
	// Route::get('/GetAnUser/{user}', 'getAnUser');

	// Route::get('/GetAllShoppingsByUser/{user}', 'getAllShoppingsByUser');
	// Route::get('/GetAllUsersWithShoppings', 'getAllUsersWithShoppings');

	// Route::post('/CreateUser', 'createUser');
	// Route::put('/UpdateUser/{user}', 'updateUser');
	// Route::delete('/DeleteUser/{user}', 'deleteUser');

});


//shoppings
Route::group(['prefix' => 'ShoppingCart', 'controller' => Shopping_CartController::class], function () {
	Route::post('/CreateShoppingCart', 'createShoppingCart');
	Route::get('/MyCart/{user}', 'getMyShoppingCart');
	Route::post('/UpdateShoppingCart/{cart}', 'updateShoppingCart');
});
