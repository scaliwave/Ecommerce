<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shopping_Cart extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'shopping_carts';

	protected $fillable = [
		'product_id',
		'user_id',
		'cant'
	];
	public function Product()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}

	public function User()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
