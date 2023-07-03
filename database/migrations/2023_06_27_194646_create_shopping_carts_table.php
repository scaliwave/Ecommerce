<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('product_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->integer('cant')->unsigned();
			$table->bigInteger('price')->unsigned();
            $table->timestamps();
			$table->softDeletes();

			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }
};
