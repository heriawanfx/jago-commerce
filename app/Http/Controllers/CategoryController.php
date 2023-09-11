<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return CategoryResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCategoryRequest $request)
    {
        $newCategory = Category::create([...$request->validated()]);
        return response(content: $newCategory, status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->load('products');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateCategoryRequest $request, Category $category)
    {
        $update = $category->update($request->validated());
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(status: 204);
    }
}
