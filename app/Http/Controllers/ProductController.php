<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sellingPrice' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'nullable|string',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'productImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'galleryImages.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Create the product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->selling_price = $request->sellingPrice;
        $product->original_price = $request->originalPrice;
        $product->category_id = $request->category_id;
        $product->unit = $request->unit;
        $product->size = $request->size;
        $product->color = $request->color;
        
        // Save the product image if available
        if ($request->hasFile('productImage')) {
            $productImage = $request->file('productImage')->store('products', 'public');
            $product->product_image = $productImage;
        }

        $product->save();

        // Save gallery images if available
        // if ($request->hasFile('galleryImages')) {
        //     foreach ($request->file('galleryImages') as $file) {
        //         $filePath = $file->store('product_galleries', 'public');
        //         $product->galleries()->create(['image' => $filePath]);
        //     }
        // }

        return response()->json(['message' => 'Product added successfully.'], 201);
    }

    // Show all products with category name and image URL
    public function index()
    {
        // Fetch products along with related category
        $products = Product::with('category')->get();

        // Map the products to include category name and full image URL
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category ? $product->category->name : 'N/A',
                'selling_price' => $product->selling_price,
                'original_price' => $product->original_price,
                'product_image_url' => $product->product_image 
                    ? asset('storage/' . $product->product_image) 
                    : null, // Return full image URL or null
            ];
        });

        return response()->json($products, 200);
    }
}
