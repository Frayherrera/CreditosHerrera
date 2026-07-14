<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\TransactionClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id())->with(['category', 'classification']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('classification_id')) {
            $query->where('transaction_classification_id', $request->classification_id);
        }

        if ($request->filled('category_id')) {
            $query->where('transaction_category_id', $request->category_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%'.$request->search.'%');
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        $categories = TransactionCategory::where('user_id', Auth::id())->orderBy('name')->get();
        $classifications = TransactionClassification::where('user_id', Auth::id())->orderBy('name')->get();

        return view('dashboard.finanzas.transacciones.index', compact('transactions', 'categories', 'classifications'));
    }

    public function create()
    {
        $categories = TransactionCategory::where('user_id', Auth::id())->orderBy('name')->get();
        $classifications = TransactionClassification::where('user_id', Auth::id())->orderBy('name')->get();

        return view('dashboard.finanzas.transacciones.form', [
            'transaction' => new Transaction,
            'categories' => $categories,
            'classifications' => $classifications,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:ingreso,egreso',
            'transaction_classification_id' => 'nullable|exists:transaction_classifications,id',
            'transaction_category_id' => 'nullable|exists:transaction_categories,id',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'description' => 'nullable|string|max:500',
            'date' => 'required|date',
            'attachment' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png,pdf',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('finanzas', 'local');
        }

        Transaction::create($validated);

        return to_route('finanzas.transacciones.index')
            ->with('status', 'Transacción registrada exitosamente.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $transaction->load(['category', 'classification']);

        return view('dashboard.finanzas.transacciones.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $categories = TransactionCategory::where('user_id', Auth::id())->orderBy('name')->get();
        $classifications = TransactionClassification::where('user_id', Auth::id())->orderBy('name')->get();

        return view('dashboard.finanzas.transacciones.form', compact('transaction', 'categories', 'classifications'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $validated = $request->validate([
            'type' => 'required|in:ingreso,egreso',
            'transaction_classification_id' => 'nullable|exists:transaction_classifications,id',
            'transaction_category_id' => 'nullable|exists:transaction_categories,id',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'description' => 'nullable|string|max:500',
            'date' => 'required|date',
            'attachment' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png,pdf',
        ]);

        if ($request->hasFile('attachment')) {
            if ($transaction->attachment_path) {
                Storage::disk('local')->delete($transaction->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('finanzas', 'local');
        }

        $transaction->update($validated);

        return to_route('finanzas.transacciones.index')
            ->with('status', 'Transacción actualizada exitosamente.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        if ($transaction->attachment_path) {
            Storage::disk('local')->delete($transaction->attachment_path);
        }

        $transaction->delete();

        return to_route('finanzas.transacciones.index')
            ->with('status', 'Transacción eliminada exitosamente.');
    }

    public function export(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id())->with(['category', 'classification']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('date', 'desc')->get();

        $filename = 'transacciones_'.now()->format('Y-m-d').'.csv';
        $headers = ['Content-Type' => 'text/csv'];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Fecha', 'Tipo', 'Clasificación', 'Categoría', 'Monto', 'Descripción']);

            foreach ($transactions as $t) {
                fputcsv($file, [
                    $t->date->format('d/m/Y'),
                    ucfirst($t->type),
                    $t->classification->name ?? 'Sin clasificación',
                    $t->category->name ?? 'Sin categoría',
                    number_format($t->amount, 2, '.', ''),
                    $t->description ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers)->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    protected function authorizeAccess(Transaction $transaction): void
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
