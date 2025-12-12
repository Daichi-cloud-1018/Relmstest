<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Bind productId placeholder to Product model
Route::model('productId', Product::class);

Route::redirect('/', '/products');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'index'])->name('products.search');

Route::get('/products/detail/{productId}', [ProductController::class, 'detail'])->name('products.detail');
Route::patch('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');
