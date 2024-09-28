<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index-categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $categoryData = $request->validate([
            'name' => 'required|string|min:2|max:100|unique:categories,name'
        ]);

        $user->categories()->create($categoryData);

        return redirect()->back()->with('status', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        Gate::authorize('edit-category', $category);

        return view('categories.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Gate::authorize('edit-category', $category);

        $categoryData = $request->validate([
            'name' => 'required|string|min:2|max:100|unique:categories,name'
        ]);

        $category->update($categoryData);

        return to_route('categories.index')->with('status', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('edit-category', $category);

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category deleted successfully.');
    }
}
