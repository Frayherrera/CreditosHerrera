@extends('layouts.admin')

@section('title', $transaction->exists ? 'Editar transacción' : 'Nueva transacción')
@section('subtitle', $transaction->exists ? 'Actualiza los datos de la transacción' : 'Registra un nuevo ingreso o egreso')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ $transaction->exists ? route('finanzas.transacciones.update', $transaction) : route('finanzas.transacciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf @if($transaction->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipo *</label>
                    <select name="type" id="type" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                        <option value="ingreso" @selected(old('type', $transaction->type) === 'ingreso')>Ingreso</option>
                        <option value="egreso" @selected(old('type', $transaction->type) === 'egreso')>Egreso</option>
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="transaction_classification_id" class="block text-sm font-medium text-gray-700 mb-1.5">Clasificación</label>
                    <select name="transaction_classification_id" id="transaction_classification_id"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                        <option value="">— Sin clasificación —</option>
                        @foreach($classifications as $cls)
                            <option value="{{ $cls->id }}" @selected(old('transaction_classification_id', $transaction->transaction_classification_id) == $cls->id)>{{ $cls->name }} ({{ ucfirst($cls->type) }})</option>
                        @endforeach
                    </select>
                    @error('transaction_classification_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="transaction_category_id" class="block text-sm font-medium text-gray-700 mb-1.5">Categoría</label>
                    <select name="transaction_category_id" id="transaction_category_id"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                        <option value="">— Sin categoría —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('transaction_category_id', $transaction->transaction_category_id) == $cat->id)>{{ $cat->name }} ({{ ucfirst($cat->type) }})</option>
                        @endforeach
                    </select>
                    @error('transaction_category_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">Fecha *</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $transaction->date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('date') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1.5">Monto *</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">$</span>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $transaction->amount) }}" step="0.01" min="0.01" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 pl-8 pr-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                </div>
                @error('amount') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Descripción <span class="text-gray-400">(opcional)</span></label>
                <input type="text" name="description" id="description" value="{{ old('description', $transaction->description) }}" maxlength="500"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('description') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1.5">Comprobante <span class="text-gray-400">(opcional — imagen o PDF, máx 10MB)</span></label>
                <input type="file" name="attachment" id="attachment" accept="image/*,.pdf"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                @if($transaction->attachment_path)
                    <p class="text-xs text-gray-500 mt-1.5">Archivo actual: <a href="{{ Storage::url($transaction->attachment_path) }}" target="_blank" class="text-amber-600 hover:underline">Ver comprobante</a></p>
                @endif
                @error('attachment') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('finanzas.transacciones.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    {{ $transaction->exists ? 'Actualizar' : 'Registrar transacción' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
