<?php

namespace App\Models;

use App\Models\Shopping_Cart;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'number_id',
		'name',
		'last_name',
		'email',
		'cellphone',
		'password',
	];

	protected $appends = ['full_name'];

	protected $hidden = [
		'password',
	];

	protected $casts = [
		'created_at' => 'datetime:Y-m-d',
		'updated_at' => 'datetime:Y-m-d',
	];

	// Accesor
	public function getFullNameAttribute()
	{
		return "{$this->name} {$this->last_name}";
	}

	// mutadores
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

	// relations-------------------------------
	public function Shopping_Carts()
	{
		return $this->hasMany(Shopping_Cart::class, 'user_id', 'id');
	}
}
