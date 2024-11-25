<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search keyword from the request
        $keyword = $request->input('keyword');

        // Start the query for products
        $query = Category::query();

        // If a keyword is provided, apply the search conditions
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        // Paginate the results
        $categories = $query->orderBy('name', 'asc')->paginate(10);

        // Return the paginated products as JSON
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ], [
            'name.required' => 'Nama kategori harus diisi.',
        ]);

        Category::create($request->all());
        return response()->json(['message' => 'Kategori berhasil disimpan', 'data' => [
            'name' => $request->name
        ]], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ], [
            'name.required' => 'Nama kategori harus diisi.',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json(['message' => 'Kategori berhasil diupdate'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
    }
}
