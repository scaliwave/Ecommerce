<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('category_id')->unsigned();
			$table->string('image')->nullable();
			$table->string('name');
			$table->text('description');
			$table->bigInteger('price')->unsigned();
			$table->integer('stock')->unsigned();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('products');
	}
};
