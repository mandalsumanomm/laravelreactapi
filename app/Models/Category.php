<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', // Add description here
        'image', // Make sure this attribute is defined
    ];

    // Relationship with Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
