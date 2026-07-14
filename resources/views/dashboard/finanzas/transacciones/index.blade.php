@extends('layouts.admin')

@section('title', 'Transacciones')
@section('subtitle', 'Listado de ingresos y egresos')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <a href="{{ route('finanzas.transacciones.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nueva transacción
    </a>
    <a href="{{ route('finanzas.transacciones.export', request()->query()) }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Exportar CSV
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form action="{{ route('finanzas.transacciones.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Descripción..."
                class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Tipo</label>
            <select name="type" class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                <option value="">Todos</option>
                <option value="ingreso" @selected(request('type') === 'ingreso')>Ingresos</option>
                <option value="egreso" @selected(request('type') === 'egreso')>Egresos</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Clasificación</label>
            <select name="classification_id" class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                <option value="">Todas</option>
                @foreach($classifications as $cls)
                    <option value="{{ $cls->id }}" @selected(request('classification_id') == $cls->id)>{{ $cls->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Categoría</label>
            <select name="category_id" class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                <option value="">Todas</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Desde</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Hasta</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
        </div>
        <div class="sm:col-span-2 lg:col-span-6 flex items-center gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all">Filtrar</button>
            <a href="{{ route('finanzas.transacciones.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition-colors">Limpiar</a>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($transactions->isEmpty())
        <div class="p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-gray-500">No hay transacciones registradas.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Fecha</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Tipo</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Clasificación</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Categoría</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Descripción</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Monto</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-gray-900">{{ $t->date->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $t->type === 'ingreso' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $t->type === 'ingreso' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($t->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-600">{{ $t->classification->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $t->category->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-900 max-w-[200px] truncate">{{ $t->description ?? '—' }}</td>
                            <td class="px-6 py-3 text-right font-semibold {{ $t->type === 'ingreso' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->type === 'ingreso' ? '+' : '-' }}${{ number_format($t->amount, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if($t->attachment_path)
                                        <a href="{{ Storage::url($t->attachment_path) }}" target="_blank" class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors" title="Ver comprobante">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.939A4 4 0 1118.83 8.84l-10.94 10.939a2.5 2.5 0 01-3.535-3.535l7.693-7.693a.75.75 0 011.06 1.061l-7.693 7.693a1 1 0 001.414 1.414l7.693-7.693" />
                                            </svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('finanzas.transacciones.edit', $t) }}" class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors" title="Editar">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('finanzas.transacciones.destroy', $t) }}" method="POST" onsubmit="return confirm('¿Eliminar esta transacción?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Eliminar">
                                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
