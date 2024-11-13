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

    //delete product

    public function destroy($id)
{
    // Find the product by ID
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // Delete the product image if it exists
    if ($product->product_image) {
        Storage::disk('public')->delete($product->product_image);
    }

    // Delete the product
    $product->delete();

    return response()->json(['message' => 'Product deleted successfully.'], 200);
}
// Update product
// public function update(Request $request, $id)
// {
//     // Validate only if fields are present in the request
//     $request->validate([
//         'name' => 'string|max:255|nullable',
//         'description' => 'string|nullable',
//         'sellingPrice' => 'numeric|nullable',
//         'originalPrice' => 'numeric|nullable',
//         'category_id' => 'exists:categories,id|nullable',
//         'unit' => 'string|nullable',
//         'size' => 'string|nullable',
//         'color' => 'string|nullable',
//         'productImage' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
//     ]);

//     // Find the product by ID
//     $product = Product::find($id);

//     if (!$product) {
//         return response()->json(['message' => 'Product not found'], 404);
//     }

//     // Directly update fields if they are provided in the request
//     $product->fill($request->only([
//         'name', 
//         'description', 
//         'sellingPrice', 
//         'originalPrice', 
//         'category_id', 
//         'unit', 
//         'size', 
//         'color'
//     ]));

//     // If a new product image is uploaded, update it
//     if ($request->hasFile('productImage')) {
//         // Delete old image if it exists
//         if ($product->product_image) {
//             Storage::disk('public')->delete($product->product_image);
//         }
//         $productImage = $request->file('productImage')->store('products', 'public');
//         $product->product_image = $productImage;
//     }

//     // Save the updated product to the database
//     $product->save();

//     return response()->json(['message' => 'Product updated successfully.'], 200);
// }

// // Show a product by ID
// public function show($id)
// {
//     // Find the product by ID
//     $product = Product::find($id);

//     if (!$product) {
//         return response()->json(['message' => 'Product not found'], 404);
//     }

//     // Return the product data
//     return response()->json($product, 200);
// }

//update2
  // Show product details by ID
  public function show($id)
  {
      $product = Product::find($id);

      if (!$product) {
          return response()->json(['message' => 'Product not found'], 404);
      }

      return response()->json($product);
  }

  // Update the product details
  public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255', // Assuming category is a string here
        'selling_price' => 'required|numeric',
        'original_price' => 'required|numeric',
        'product_image_url' => 'nullable|string', // Or 'image' if handling file uploads
    ]);

    $product->update($validatedData);

    return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
}


}
