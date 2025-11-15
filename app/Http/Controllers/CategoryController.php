<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }
}
