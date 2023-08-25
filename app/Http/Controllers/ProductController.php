<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::paginate(10);
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
        $product = $product;
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
