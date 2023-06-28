<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('number_id')->nullable();
            $table->string('name');
			$table->string('last_name');
            $table->string('email')->unique();
			$table->string('cellphone')->unique();
            $table->string('password');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
