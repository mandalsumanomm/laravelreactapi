<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntry extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the default (optional)
    // protected $table = 'product_entries';

    protected $fillable = [
        'name',
        'description',
        'selling_price',
        'original_price',
        'category_name',
        'unit',
        'size',
        'color',
        'product_image',
        'gallery_images',
    ];

    // If you want gallery_images to be automatically cast to an array or JSON
    protected $casts = [
        'gallery_images' => 'array',
    ];
}
