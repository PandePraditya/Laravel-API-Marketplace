<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search keyword from the request
        $keyword = $request->input('keyword');

        // Start the query for products
        $query = Product::with(['brand', 'category']);

        // If a keyword is provided, apply the search conditions
        if ($keyword) {
            // return $keyword;
            $query->where('name', 'like', "%{$keyword}%")
            ->orWhere('price', 'like', "%{$keyword}%")
            ->orWhere('stock', 'like', "%{$keyword}%")
            ->orWhereHas('category', function (Builder $q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            })
            ->orWhereHas('brand', function (Builder $q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        // Paginate the results
        $products = $query->orderBy('name', 'asc')->paginate(10);

        // Format the results
        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'brand' => $product->brand ? $product->brand->name : null, // Display brand name, null if not found
                'category' => $product->category ? $product->category->name : null // Display category name, null if not found
            ];
        });

        // Return the paginated products as JSON
        return response()->json([
            'data' => $formattedProducts,
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ]);
    }
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga produk harus diisi.',
            'stock.required' => 'Stok produk harus diisi.',
            'category_id.required' => 'Kategori produk harus dipilih.',
            'brand_id.required' => 'Merek produk harus dipilih.',
        ]);

        Product::create($request->all());
        return response()->json(['message' => 'Produk berhasil disimpan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Use with() to eager load brand and category
        $product = Product::with(['brand', 'category'])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'brand' => $product->brand ? $product->brand->name : null, // Display brand name, null if not found
            'category' => $product->category ? $product->category->name : null // Display category name, null if not found
        ]);
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga produk harus diisi.',
            'stock.required' => 'Stok produk harus diisi.',
            'category_id.required' => 'Kategori produk harus dipilih.',
            'brand_id.required' => 'Merek produk harus dipilih.',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json(['message' => 'Produk berhasil diupdate'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }
}
