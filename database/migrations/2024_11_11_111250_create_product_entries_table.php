<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('selling_price', 8, 2); // Adjust precision as necessary
            $table->decimal('original_price', 8, 2); // Adjust precision as necessary
            $table->string('category_name'); // Storing the category name directly
            $table->string('unit');
            $table->string('size');
            $table->string('color');
            $table->string('product_image'); // To store the path of the uploaded image
            $table->json('gallery_images')->nullable(); // To store the gallery images as JSON (paths or URLs)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
