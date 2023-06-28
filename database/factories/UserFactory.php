<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
	protected $model = User::class;

	public function definition(): array
	{
		return [
			'number_id' => $this->faker->randomNumber(9, true),
			'name' => $this->faker->name(),
			'last_name' => $this->faker->lastName(),
			'email' => $this->faker->unique()->safeEmail(),
			'cellphone' => $this->faker->unique()->randomNumber(9, true),
			'password' => bcrypt(123456789)
		];
	}
}
