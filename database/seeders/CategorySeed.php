<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeed extends Seeder
{

    public function run(): void
    {
        DB::table('categories')->insert([
			'name' => 'Computacion',
		]);

		DB::table('categories')->insert([
			'name' => 'Moda',
		]);

		DB::table('categories')->insert([
			'name' => 'Ropa',
		]);

    }
}
