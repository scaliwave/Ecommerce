<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
	protected $model = Product::class;
	public function definition(): array
	{
		return [
			'category_id' => $this->faker->randomElement([1, 2, 3]),
			'name' => $this->faker->sentence(),
			'description' => $this->faker->paragraph(),
			'price' => $this->faker->numberBetween(3000, 10000000),
			'stock' => $this->faker->randomDigit(),
		];
	}
}
