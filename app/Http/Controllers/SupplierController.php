<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->paginate(15);
        return view('dashboard.inventario.proveedores.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboard.inventario.proveedores.form', [
            'supplier' => new Supplier,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return to_route('inventario.proveedores.index')
            ->with('status', 'Proveedor creado exitosamente.');
    }

    public function edit(Supplier $supplier)
    {
        return view('dashboard.inventario.proveedores.form', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return to_route('inventario.proveedores.index')
            ->with('status', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return to_route('inventario.proveedores.index')
            ->with('status', 'Proveedor eliminado exitosamente.');
    }
}
