<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$data = Product::paginate(10);

        $category_id = $request->input('category_id');

        $data = Product::query()
            ->when($category_id, function ($query, $value) {
                $query->where('category_id', '=', $value);
            })
            ->with('category')
            ->paginate(10);

        return ProductResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequests = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'image_url' => 'required',
            'category_id' => 'required',
        ]);

        $newCategory = Product::create([...$validatedRequests, 'user_id' => 1]);

        return response(content: $newCategory, status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = $product->load('category', 'user');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedRequests = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'image_url' => 'required',
            'category_id' => 'required',
        ]);

        $update = $product->update($validatedRequests);
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(status: 204);
    }
}
