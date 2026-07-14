<?php

namespace App\Http\Controllers;

use App\Models\TransactionClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionClassificationController extends Controller
{
    public function index()
    {
        $classifications = TransactionClassification::where('user_id', Auth::id())
            ->orderBy('type')
            ->orderBy('name')
            ->paginate(15);

        return view('dashboard.finanzas.clasificaciones.index', compact('classifications'));
    }

    public function create()
    {
        return view('dashboard.finanzas.clasificaciones.form', [
            'classification' => new TransactionClassification,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ingreso,egreso',
        ]);

        $validated['user_id'] = Auth::id();

        TransactionClassification::create($validated);

        return to_route('finanzas.clasificaciones.index')
            ->with('status', 'Clasificación creada exitosamente.');
    }

    public function edit(TransactionClassification $classification)
    {
        $this->authorizeAccess($classification);

        return view('dashboard.finanzas.clasificaciones.form', compact('classification'));
    }

    public function update(Request $request, TransactionClassification $classification)
    {
        $this->authorizeAccess($classification);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ingreso,egreso',
        ]);

        $classification->update($validated);

        return to_route('finanzas.clasificaciones.index')
            ->with('status', 'Clasificación actualizada exitosamente.');
    }

    public function destroy(TransactionClassification $classification)
    {
        $this->authorizeAccess($classification);

        if ($classification->transactions()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar una clasificación con transacciones asociadas.']);
        }

        $classification->delete();

        return to_route('finanzas.clasificaciones.index')
            ->with('status', 'Clasificación eliminada exitosamente.');
    }

    protected function authorizeAccess(TransactionClassification $classification): void
    {
        if ($classification->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
