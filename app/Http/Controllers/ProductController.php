<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProductRequest;
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
        $user_id = $request->input('user_id');

        $data = Product::query()
            ->when($category_id, function ($query, $value) {
                $query->where('category_id', '=', $value);
            })
            ->when($user_id, function ($query, $value) {
                $query->where('user_id', '=', $value);
            })
            ->with('category','user')
            ->paginate(10);

        return ProductResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProductRequest $request)
    {
        $newCategory = Product::create([
            $request->validated(), 
            'user_id' => $request->user()->id,
        ]);

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
    public function update(StoreUpdateProductRequest $request, Product $product)
    {
        $update = $product->update($request->validated());
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
