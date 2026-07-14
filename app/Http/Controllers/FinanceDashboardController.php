<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = Auth::id();
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $totalIngresos = Transaction::where('user_id', $userId)
            ->ingresos()
            ->delAnio($year)
            ->sum('amount');

        $totalEgresos = Transaction::where('user_id', $userId)
            ->egresos()
            ->delAnio($year)
            ->sum('amount');

        $balance = $totalIngresos - $totalEgresos;

        $classifications = TransactionClassification::where('user_id', $userId)->get();

        $ingresosPorClasificacion = $classifications->mapWithKeys(function ($cls) use ($userId, $year) {
            $key = 'ingresos_'.str_replace(' ', '_', strtolower($cls->name));

            return [$key => Transaction::where('user_id', $userId)
                ->ingresos()
                ->where('transaction_classification_id', $cls->id)
                ->delAnio($year)
                ->sum('amount')];
        });

        $egresosPorClasificacion = $classifications->mapWithKeys(function ($cls) use ($userId, $year) {
            $key = 'egresos_'.str_replace(' ', '_', strtolower($cls->name));

            return [$key => Transaction::where('user_id', $userId)
                ->egresos()
                ->where('transaction_classification_id', $cls->id)
                ->delAnio($year)
                ->sum('amount')];
        });

        $meses = collect(range(1, 12))->map(function ($m) use ($userId, $year) {
            $ingresos = Transaction::where('user_id', $userId)
                ->ingresos()
                ->whereYear('date', $year)
                ->whereMonth('date', $m)
                ->sum('amount');

            $egresos = Transaction::where('user_id', $userId)
                ->egresos()
                ->whereYear('date', $year)
                ->whereMonth('date', $m)
                ->sum('amount');

            return [
                'mes' => $m,
                'nombre' => now()->month($m)->translatedFormat('M'),
                'ingresos' => $ingresos,
                'egresos' => $egresos,
            ];
        });

        $porCategoria = Transaction::where('user_id', $userId)
            ->with('category')
            ->delAnio($year)
            ->get()
            ->groupBy('type')
            ->map(function ($group) {
                return $group->groupBy('transaction_category_id')->map(function ($items) {
                    return [
                        'nombre' => $items->first()->category->name ?? 'Sin categoría',
                        'total' => $items->sum('amount'),
                    ];
                })->values();
            });

        $transaccionesHoy = Transaction::where('user_id', $userId)
            ->whereDate('date', now())
            ->with(['category', 'classification'])
            ->orderBy('date', 'desc')
            ->get();

        $transaccionesMes = Transaction::where('user_id', $userId)
            ->delMes($month, $year)
            ->with(['category', 'classification'])
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        $clsChartData = $classifications->map(function ($cls) use ($userId, $year) {
            return [
                'name' => $cls->name,
                'type' => $cls->type,
                'total' => Transaction::where('user_id', $userId)
                    ->where('transaction_classification_id', $cls->id)
                    ->delAnio($year)
                    ->sum('amount'),
            ];
        });

        return view('dashboard.finanzas.index', array_merge(
            compact(
                'totalIngresos', 'totalEgresos', 'balance',
                'classifications', 'meses', 'porCategoria',
                'transaccionesHoy', 'transaccionesMes',
                'year', 'month', 'clsChartData'
            ),
            $ingresosPorClasificacion->toArray(),
            $egresosPorClasificacion->toArray()
        ));
    }
}
