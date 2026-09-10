<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\FinanceDashboardController;
use App\Http\Controllers\InventoryDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionClassificationController;
use App\Http\Controllers\TransactionController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::orderBy('name')->get();
    $products = Product::with('category', 'images')
        ->active()
        ->inStock()
        ->orderBy('created_at', 'desc')
        ->get();

    $vendedorSlug = request('vendedor');
    $vendedores = config('vendedores');
    $vendedor = $vendedorSlug && isset($vendedores[$vendedorSlug])
        ? $vendedores[$vendedorSlug]
        : $vendedores['default'];

    return view('welcome', compact('categories', 'products', 'vendedor'));
})->name('home');

Route::get('/productos/{producto:slug}', function ($slug) {
    $producto = Product::with('category', 'images')
        ->active()
        ->inStock()
        ->where('slug', $slug)
        ->firstOrFail();

    $vendedorSlug = request('vendedor');
    $vendedores = config('vendedores');
    $vendedor = $vendedorSlug && isset($vendedores[$vendedorSlug])
        ? $vendedores[$vendedorSlug]
        : $vendedores['default'];

    return view('productos.show', compact('producto', 'vendedor'));
})->name('productos.show');

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
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('distribuidores', DistributorController::class)
            ->parameters(['distribuidores' => 'distributor']);
        Route::resource('proveedores', SupplierController::class)
            ->parameters(['proveedores' => 'supplier']);
    });

    Route::prefix('dashboard/finanzas')->name('finanzas.')->group(function () {
        Route::get('/', FinanceDashboardController::class)->name('dashboard');
        Route::get('/reportes/export', [TransactionController::class, 'export'])->name('transacciones.export');
        Route::resource('transacciones', TransactionController::class)
            ->parameters(['transacciones' => 'transaction']);
        Route::resource('categorias', TransactionCategoryController::class)
            ->parameters(['categorias' => 'category']);
        Route::resource('clasificaciones', TransactionClassificationController::class)
            ->parameters(['clasificaciones' => 'classification']);
    });
});

require __DIR__.'/auth.php';
