<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Store a new category
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([

            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

        ]);

        // Create a new category record in the database
        $category = Category::create($validatedData);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    // Fetch all categories
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all();

        // Return categories as a JSON response
        return response()->json($categories);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $category = Category::findOrFail($id);
    $category->name = $request->name;
    $category->description = $request->description;
    $category->save();

    return response()->json(['message' => 'Category updated successfully']);
}

}