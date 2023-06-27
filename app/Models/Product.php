<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Shopping_Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
	use HasFactory;

	protected $fillable = [
		'category_id',
		'image',
		'name',
		'description',
		'price',
		'stock'
	];

	public function Category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	public function Shopping_Carts()
	{
		return $this->hasMany(Shopping_Cart::class, 'product_id', 'id');
	}
}
