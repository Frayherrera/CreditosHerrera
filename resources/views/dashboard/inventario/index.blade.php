@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Resumen del inventario')

@section('content')
{{-- Quick actions --}}
<div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between">
       
        <div class="flex items-center gap-3">
            <a href="{{ route('inventario.productos.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nuevo producto
            </a>
            <a href="{{ route('inventario.movimientos.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Registrar movimiento
            </a>
        </div>
    </div>
</div>
{{-- Stats row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('inventario.productos.index') }}"
        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-gray-200 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <span class="text-xs font-medium text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">Ver todos →</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalProducts }}</p>
        <p class="text-sm text-gray-500 mt-1">Total productos</p>
    </a>

    <a href="{{ route('inventario.productos.index') }}"
        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-gray-200 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-xs font-medium text-green-600 opacity-0 group-hover:opacity-100 transition-opacity">Ver activos →</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $activeProducts }}</p>
        <p class="text-sm text-gray-500 mt-1">Productos activos</p>
    </a>

    <!-- <a href="{{ route('inventario.productos.index') }}"
        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-amber-200 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <span class="text-xs font-medium text-amber-600 opacity-0 group-hover:opacity-100 transition-opacity">Revisar →</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $lowStockProducts }}</p>
        <p class="text-sm text-gray-500 mt-1">Stock bajo</p>
    </a> -->

    <a href="{{ route('inventario.categorias.index') }}"
        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-gray-200 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                </svg>
            </div>
            <span class="text-xs font-medium text-purple-600 opacity-0 group-hover:opacity-100 transition-opacity">Ver todas →</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalCategories }}</p>
        <p class="text-sm text-gray-500 mt-1">Categorías</p>
    </a>
</div>

{{-- Low stock & recent movements --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Últimos movimientos</h3>
            </div>
            <a href="{{ route('inventario.movimientos.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors">Ver todos</a>
        </div>
        <div class="p-6">
            @if($recentMovements->isEmpty())
            <div class="flex flex-col items-center py-6 text-center">
                <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">No hay movimientos recientes.</p>
            </div>
            @else
            <div class="space-y-1">
                @foreach($recentMovements as $movement)
                <div class="flex items-center justify-between py-2.5 px-3 -mx-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $movement->product->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400">
                            <span class="inline-flex items-center gap-1">
                                @if($movement->type === 'entry')
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                Entrada
                                @elseif($movement->type === 'exit')
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                Salida
                                @else
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                                Ajuste
                                @endif
                            </span>
                            · {{ $movement->quantity }} uds
                            @if($movement->user) · {{ $movement->user->name }} @endif
                        </p>
                    </div>
                    <p class="text-xs text-gray-400 shrink-0 ml-4">{{ $movement->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>



@endsection