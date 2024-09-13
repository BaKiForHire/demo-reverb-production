<?php

namespace App\Http\Controllers;

use App\Models\AuctionCategory;
use Illuminate\Http\Request;

/**
 * Controller for managing auction categories.
 * Includes actions for listing, creating, updating, and deleting categories.
 */
class AuctionCategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        $categories = AuctionCategory::all();
        return response()->json($categories);
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $category = AuctionCategory::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Store a newly created category in storage.
     * Admin only.
     */
    public function store(Request $request)
    {
        $this->authorize('create', AuctionCategory::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:auction_categories,name',
            'description' => 'nullable|string',
        ]);

        $category = AuctionCategory::create($request->only(['name', 'description']));

        return response()->json(['message' => 'Category created successfully.', 'category' => $category]);
    }

    /**
     * Update the specified category in storage.
     * Admin only.
     */
    public function update(Request $request, $id)
    {
        $category = AuctionCategory::findOrFail($id);
        $this->authorize('update', $category);

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:auction_categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->only(['name', 'description']));

        return response()->json(['message' => 'Category updated successfully.', 'category' => $category]);
    }

    /**
     * Delete a category from the platform.
     * Admin only.
     */
    public function destroy($id)
    {
        $category = AuctionCategory::findOrFail($id);
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
