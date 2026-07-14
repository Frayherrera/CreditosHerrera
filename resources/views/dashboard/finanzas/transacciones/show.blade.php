@extends('layouts.admin')

@section('title', 'Detalle de transacción')
@section('subtitle', $transaction->description ?? 'Transacción del ' . $transaction->date->format('d/m/Y'))

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="grid grid-cols-2 gap-5 mb-6">
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Tipo</p>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $transaction->type === 'ingreso' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $transaction->type === 'ingreso' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                    {{ ucfirst($transaction->type) }}
                </span>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Clasificación</p>
                <p class="text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $transaction->classification) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Monto</p>
                <p class="text-2xl font-bold {{ $transaction->type === 'ingreso' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $transaction->type === 'ingreso' ? '+' : '-' }}${{ number_format($transaction->amount, 2, ',', '.') }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Fecha</p>
                <p class="text-sm text-gray-900">{{ $transaction->date->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Categoría</p>
                <p class="text-sm text-gray-900">{{ $transaction->category->name ?? 'Sin categoría' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Descripción</p>
                <p class="text-sm text-gray-900">{{ $transaction->description ?? '—' }}</p>
            </div>
        </div>

        @if($transaction->attachment_path)
            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                <p class="text-xs font-medium text-gray-500 mb-2">Comprobante adjunto</p>
                <a href="{{ Storage::url($transaction->attachment_path) }}" target="_blank"
                    class="inline-flex items-center gap-2 text-sm text-amber-600 hover:text-amber-700 font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.939A4 4 0 1118.83 8.84l-10.94 10.939a2.5 2.5 0 01-3.535-3.535l7.693-7.693a.75.75 0 011.06 1.061l-7.693 7.693a1 1 0 001.414 1.414l7.693-7.693" />
                    </svg>
                    Ver comprobante
                </a>
            </div>
        @endif

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('finanzas.transacciones.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Volver</a>
            <a href="{{ route('finanzas.transacciones.edit', $transaction) }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all">Editar</a>
            <form action="{{ route('finanzas.transacciones.destroy', $transaction) }}" method="POST" onsubmit="return confirm('¿Eliminar esta transacción?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-xl hover:bg-red-700 transition-all">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
