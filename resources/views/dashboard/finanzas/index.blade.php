@extends('layouts.admin')

@section('title', 'Finanzas')
@section('subtitle', 'Resumen financiero del año {{ $year }}')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('finanzas.transacciones.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nueva transacción
        </a>
        <a href="{{ route('finanzas.transacciones.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            Ver listado
        </a>
    </div>
    <div class="flex items-center gap-2">
        <a href="?year={{ $year - 1 }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>
        <span class="text-sm font-semibold text-gray-900">{{ $year }}</span>
        <a href="?year={{ $year + 1 }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>
    </div>
</div>

{{-- Stats cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-green-600">${{ number_format($totalIngresos, 2, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-1">Total ingresos</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-red-600">${{ number_format($totalEgresos, 2, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-1">Total egresos</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl {{ $balance >= 0 ? 'bg-blue-50' : 'bg-amber-50' }} flex items-center justify-center">
                <svg class="w-5 h-5 {{ $balance >= 0 ? 'text-blue-600' : 'text-amber-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-amber-600' }}">${{ number_format($balance, 2, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-1">Balance anual</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-purple-600">{{ $transaccionesMes->count() }}</p>
        <p class="text-sm text-gray-500 mt-1">Transacciones del mes</p>
    </div>
</div>

{{-- Classification breakdown --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Ingresos por clasificación</h3>
        <div class="space-y-3">
            @foreach($clsChartData->where('type', 'ingreso') as $cls)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $cls['name'] }}</span>
                    <span class="text-sm font-semibold text-green-600">${{ number_format($cls['total'], 2, ',', '.') }}</span>
                </div>
            @endforeach
            @if($clsChartData->where('type', 'ingreso')->isEmpty())
                <p class="text-sm text-gray-400">No hay clasificaciones de ingresos.</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Egresos por clasificación</h3>
        <div class="space-y-3">
            @foreach($clsChartData->where('type', 'egreso') as $cls)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $cls['name'] }}</span>
                    <span class="text-sm font-semibold text-red-600">${{ number_format($cls['total'], 2, ',', '.') }}</span>
                </div>
            @endforeach
            @if($clsChartData->where('type', 'egreso')->isEmpty())
                <p class="text-sm text-gray-400">No hay clasificaciones de egresos.</p>
            @endif
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Ingresos vs Egresos mensuales</h3>
        <canvas id="chartMensual" height="200"></canvas>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Distribución por clasificación</h3>
        <canvas id="chartTipo" height="200"></canvas>
    </div>
</div>

{{-- Recent transactions --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Últimas transacciones del mes</h3>
            <a href="{{ route('finanzas.transacciones.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700">Ver todas</a>
        </div>
        <div class="p-6">
            @if($transaccionesMes->isEmpty())
                <p class="text-sm text-gray-500 text-center py-4">No hay transacciones este mes.</p>
            @else
                <div class="space-y-1">
                    @foreach($transaccionesMes as $t)
                        <div class="flex items-center justify-between py-2.5 px-3 -mx-3 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $t->description ?? $t->category->name ?? 'Sin descripción' }}</p>
                                <p class="text-xs text-gray-400">
                                    <span class="inline-flex items-center gap-1">
                                        @if($t->type === 'ingreso')
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                            Ingreso
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                            Egreso
                                        @endif
                                    </span>
                                    · {{ $t->date->format('d/m/Y') }}
                                </p>
                            </div>
                            <p class="text-sm font-semibold {{ $t->type === 'ingreso' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->type === 'ingreso' ? '+' : '-' }}${{ number_format($t->amount, 2, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Transacciones de hoy</h3>
        </div>
        <div class="p-6">
            @if($transaccionesHoy->isEmpty())
                <p class="text-sm text-gray-500 text-center py-4">No hay transacciones hoy.</p>
            @else
                <div class="space-y-1">
                    @foreach($transaccionesHoy as $t)
                        <div class="flex items-center justify-between py-2.5 px-3 -mx-3 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $t->description ?? $t->category->name ?? 'Sin descripción' }}</p>
                                <p class="text-xs text-gray-400">
                                    <span class="inline-flex items-center gap-1">
                                        @if($t->type === 'ingreso')
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                            Ingreso
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                            Egreso
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <p class="text-sm font-semibold {{ $t->type === 'ingreso' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->type === 'ingreso' ? '+' : '-' }}${{ number_format($t->amount, 2, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const mesesLabels = @json($meses->pluck('nombre'));
    const ingresosData = @json($meses->pluck('ingresos'));
    const egresosData = @json($meses->pluck('egresos'));

    new Chart(document.getElementById('chartMensual'), {
        type: 'bar',
        data: {
            labels: mesesLabels,
            datasets: [
                {
                    label: 'Ingresos',
                    data: ingresosData,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1,
                    borderRadius: 6,
                },
                {
                    label: 'Egresos',
                    data: egresosData,
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => '$' + v.toLocaleString() } }
            }
        }
    });

    const clsLabels = @json($clsChartData->pluck('name'));
    const clsTotals = @json($clsChartData->pluck('total'));
    const clsColors = @json($clsChartData->map(fn($c) => $c['type'] === 'ingreso' ? '#22c55e' : '#ef4444'));

    new Chart(document.getElementById('chartTipo'), {
        type: 'doughnut',
        data: {
            labels: clsLabels,
            datasets: [{
                data: clsTotals,
                backgroundColor: clsColors,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } }
        }
    });
</script>
@endsection
