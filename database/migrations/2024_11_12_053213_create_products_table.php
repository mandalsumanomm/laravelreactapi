<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_products_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('selling_price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('unit')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('product_image')->nullable();
            $table->timestamps();

            // Foreign key constraint for category
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}

