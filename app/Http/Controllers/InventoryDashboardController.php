<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class InventoryDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $lowStockProducts = Product::lowStock()->count();
        $totalCategories = Category::count();
        $recentMovements = StockMovement::with('product', 'user')
            ->latest()
            ->take(10)
            ->get();
        $lowStockItems = Product::with('category')
            ->lowStock()
            ->where('status', 'active')
            ->get();

        $inventoryValue = Product::where('status', 'active')
            ->selectRaw('COALESCE(SUM(price * stock), 0) as total')
            ->value('total');

        return view('dashboard.inventario.index', compact(
            'totalProducts', 'activeProducts', 'lowStockProducts',
            'totalCategories', 'recentMovements', 'lowStockItems',
            'inventoryValue'
        ));
    }
}
