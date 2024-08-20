<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Define the number of items per page
        $perPage = 5;

        // Fetch paginated books
        // Fetch all categories
        $categories = Category::paginate($perPage);

        // Calculate pagination variables
        $currentPage = $categories->currentPage();
        $totalPages = $categories->lastPage();
        $totalItems = $categories->total();
        $start = ($categories->currentPage() - 1) * $perPage + 1;
        $end = min($categories->currentPage() * $perPage, $categories->total());

        // Pass pagination and categories data to the view
        return view('admin.category.index', [
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'start' => $start,
            'end' => $end
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
            'description' => 'required|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return redirect()->route('categories')->with('success', 'Category updated successfully.');
    }
    public function destroy($id)
    {
        // Find the category by its ID
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        // Redirect with a success message
        return redirect()->route('categories')->with('success', 'Category deleted successfully.');
    }
}
