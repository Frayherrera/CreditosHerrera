<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionCategoryController extends Controller
{
    public function index()
    {
        $categories = TransactionCategory::where('user_id', Auth::id())
            ->orderBy('type')
            ->orderBy('name')
            ->paginate(15);

        return view('dashboard.finanzas.categorias.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.finanzas.categorias.form', [
            'category' => new TransactionCategory,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ingreso,egreso',
        ]);

        $validated['user_id'] = Auth::id();

        TransactionCategory::create($validated);

        return to_route('finanzas.categorias.index')
            ->with('status', 'Categoría creada exitosamente.');
    }

    public function edit(TransactionCategory $category)
    {
        $this->authorize('update', $category);

        return view('dashboard.finanzas.categorias.form', compact('category'));
    }

    public function update(Request $request, TransactionCategory $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ingreso,egreso',
        ]);

        $category->update($validated);

        return to_route('finanzas.categorias.index')
            ->with('status', 'Categoría actualizada exitosamente.');
    }

    public function destroy(TransactionCategory $category)
    {
        $this->authorize('delete', $category);

        if ($category->transactions()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar una categoría con transacciones asociadas.']);
        }

        $category->delete();

        return to_route('finanzas.categorias.index')
            ->with('status', 'Categoría eliminada exitosamente.');
    }

    protected function authorize(string $action, TransactionCategory $category): void
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
