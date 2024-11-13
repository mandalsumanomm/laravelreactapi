<?php

// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'selling_price',
        'original_price',
        'category_id',
        'unit',
        'size',
        'color',
        'product_image',
        'gallery_images',
    ];

        // Relationship with Category
        public function category()
        {
            return $this->belongsTo(Category::class);
        }
    
        
   
}
