<?php

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDebugResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories/{id}', function ($id) {
    $category = Category::findOrFail($id);
    return new CategoryResource($category);
});

Route::get('/categories', function () {
    $categories = Category::all();
    return CategoryResource::collection($categories);
});
Route::get('/categories-cust', function () {
    $categories = Category::all();
    return new CategoryCollection($categories);
});
Route::get('/products/{id}', function ($id) {
    $product = Product::find($id);
    $product->load("category");
    return new ProductResource($product);
});
Route::get('/products', function () {
    $products = Product::with('category')->get();
    return new ProductCollection($products);
});

Route::get('/products-paging', function (Request $request) {
    $page = $request->get('page', 1);
    $products = Product::paginate(perPage: 2, page: $page);
    return new ProductCollection($products);
});
Route::get('/products-debug/{id}', function ($id) {
    $product = Product::find($id);
    return new ProductDebugResource($product);
});
