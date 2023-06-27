<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeed extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
			'number_id' => '1004678652',
			'name' => 'Thomas',
			'last_name' => 'Olaya',
			'email' => 'thomasog10@gmail.com',
			'cellphone' => '3187897547',
			'password' => bcrypt(123456789),
		]);
    }
}
