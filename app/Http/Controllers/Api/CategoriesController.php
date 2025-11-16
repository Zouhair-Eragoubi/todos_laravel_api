<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    private function getUserCategories()
    {
        // Categories are available for all users
        return Category::query();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->getUserCategories()->get();
        return response()->json(['status' => true,'categories' => CategoryResource::collection($categories)], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'desc' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $validation['name'],
            'description' => $validation['desc'] ?? null,
        ]);

        if($category){
            return response()->json(['status' => true,'message' => 'Category created successfully','category' => new CategoryResource($category)], 201);
        }else{
            return response()->json(['status' => false,'message' => 'Category creation failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->getUserCategories()->find($id);
        if(!$category){
            return response()->json(['status' => false,'message' => 'Category not found'], 404);
        }
        return response()->json(['status' => true,'category' => new CategoryResource($category)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->getUserCategories()->find($id);

        if(!$category){
            return response()->json(['status' => false,'message' => 'Category not found'], 404);
        }

        $validation = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'desc' => 'nullable|string',
        ]);

        $updated = $category->update([
            'name' => $validation['name'],
            'description' => $validation['desc'] ?? null,
        ]);

        if($updated){
            $category->refresh();
            return response()->json(['status' => true,'message' => 'Category updated successfully','category' => new CategoryResource($category)], 200);
        }else{
            return response()->json(['status' => false,'message' => 'Category update failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->getUserCategories()->find($id);

        if (!$category) {
            return response()->json(['status' => false,'message' => 'Category not found'], 404);
        }

        try {
            $category->delete();
            return response()->json(['status' => true,'message' => 'Category deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => 'Category deletion failed'], 500);
        }
    }
}
