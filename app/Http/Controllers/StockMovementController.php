<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product', 'user', 'distributor', 'supplier')
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('dashboard.inventario.movimientos.index', compact('movements'));
    }

    public function create()
    {
        $stockMovement = null;
        $products = Product::where('status', 'active')->orderBy('name')->get();
        $distributors = Distributor::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('dashboard.inventario.movimientos.form', compact('products', 'distributors', 'suppliers', 'stockMovement'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entry,exit,adjustment',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'distributor_id' => 'nullable|required_if:type,exit|exists:distributors,id',
            'supplier_id' => 'nullable|required_if:type,entry|exists:suppliers,id',
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
            'date' => $validated['date'],
            'quantity' => $validated['type'] === 'adjustment' ? $validated['quantity'] : $validated['quantity'],
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'notes' => $validated['notes'] ?? null,
            'user_id' => auth()->id(),
            'distributor_id' => $validated['distributor_id'] ?? null,
            'supplier_id' => $validated['supplier_id'] ?? null,
        ]);

        $product->update(['stock' => $newStock]);

        return to_route('inventario.movimientos.index')
            ->with('status', 'Movimiento registrado exitosamente.');
    }

    public function edit(StockMovement $stockMovement)
    {
        $products = Product::where('status', 'active')->orderBy('name')->get();
        $distributors = Distributor::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('dashboard.inventario.movimientos.form', compact('stockMovement', 'products', 'distributors', 'suppliers'));
    }

    public function update(Request $request, StockMovement $stockMovement)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entry,exit,adjustment',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'distributor_id' => 'nullable|required_if:type,exit|exists:distributors,id',
            'supplier_id' => 'nullable|required_if:type,entry|exists:suppliers,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Revertir efecto del movimiento anterior
        $revertedStock = match ($stockMovement->type) {
            'entry' => $product->stock - $stockMovement->quantity,
            'exit' => $product->stock + $stockMovement->quantity,
            'adjustment' => $product->stock,
        };

        if ($validated['type'] === 'exit' && $revertedStock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stock insuficiente para realizar esta salida.']);
        }

        $newStock = match ($validated['type']) {
            'entry' => $revertedStock + $validated['quantity'],
            'exit' => $revertedStock - $validated['quantity'],
            'adjustment' => $validated['quantity'],
        };

        $stockMovement->update([
            'product_id' => $validated['product_id'],
            'type' => $validated['type'],
            'date' => $validated['date'],
            'quantity' => $validated['quantity'],
            'previous_stock' => $revertedStock,
            'new_stock' => $newStock,
            'notes' => $validated['notes'] ?? null,
            'distributor_id' => $validated['distributor_id'] ?? null,
            'supplier_id' => $validated['supplier_id'] ?? null,
        ]);

        $product->update(['stock' => $newStock]);

        return to_route('inventario.movimientos.index')
            ->with('status', 'Movimiento actualizado exitosamente.');
    }

    public function destroy(StockMovement $stockMovement)
    {
        $product = $stockMovement->product;

        // Revertir efecto del movimiento
        $revertedStock = match ($stockMovement->type) {
            'entry' => $product->stock - $stockMovement->quantity,
            'exit' => $product->stock + $stockMovement->quantity,
            'adjustment' => $product->stock,
        };

        $product->update(['stock' => $revertedStock]);
        $stockMovement->delete();

        return to_route('inventario.movimientos.index')
            ->with('status', 'Movimiento eliminado exitosamente.');
    }
}
