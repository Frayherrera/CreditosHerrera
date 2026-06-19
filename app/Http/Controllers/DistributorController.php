<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::orderBy('name')->paginate(15);
        return view('dashboard.inventario.distribuidores.index', compact('distributors'));
    }

    public function create()
    {
        return view('dashboard.inventario.distribuidores.form', [
            'distributor' => new Distributor,
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

        Distributor::create($validated);

        return to_route('inventario.distribuidores.index')
            ->with('status', 'Distribuidor creado exitosamente.');
    }

    public function edit(Distributor $distributor)
    {
        return view('dashboard.inventario.distribuidores.form', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $distributor->update($validated);

        return to_route('inventario.distribuidores.index')
            ->with('status', 'Distribuidor actualizado exitosamente.');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return to_route('inventario.distribuidores.index')
            ->with('status', 'Distribuidor eliminado exitosamente.');
    }
}
