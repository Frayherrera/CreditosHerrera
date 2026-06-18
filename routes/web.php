<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockMovementController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::orderBy('name')->get();
    $products = Product::with('category', 'images')
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('welcome', compact('categories', 'products'));
});

Route::get('/gestion', function () {
    return view('gestion');
})->name('gestion');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard/inventario')->name('inventario.')->group(function () {
        Route::get('/', InventoryDashboardController::class)->name('dashboard');
        Route::resource('categorias', CategoryController::class)->parameters(['categorias' => 'category']);
        Route::resource('productos', ProductController::class)->parameters(['productos' => 'product']);
        Route::resource('movimientos', StockMovementController::class)
            ->parameters(['movimientos' => 'stockMovement'])
            ->only(['index', 'create', 'store']);
    });
});

require __DIR__.'/auth.php';
