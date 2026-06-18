<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product', 'user')
            ->latest()
            ->paginate(20);

        return view('dashboard.inventario.movimientos.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->orderBy('name')->get();
        return view('dashboard.inventario.movimientos.form', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entry,exit,adjustment',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $previousStock = $product->stock;

        if ($validated['type'] === 'exit' && $product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stock insuficiente para realizar esta salida.']);
        }

        $newStock = match ($validated['type']) {
            'entry' => $previousStock + $validated['quantity'],
            'exit' => $previousStock - $validated['quantity'],
            'adjustment' => $validated['quantity'],
        };

        StockMovement::create([
            'product_id' => $validated['product_id'],
            'type' => $validated['type'],
            'quantity' => $validated['type'] === 'adjustment' ? $validated['quantity'] : $validated['quantity'],
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'notes' => $validated['notes'],
            'user_id' => auth()->id(),
        ]);

        $product->update(['stock' => $newStock]);

        return to_route('inventario.movimientos.index')
            ->with('status', 'Movimiento registrado exitosamente.');
    }
}
