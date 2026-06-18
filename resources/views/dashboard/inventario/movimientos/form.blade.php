@extends('layouts.admin')

@section('title', 'Nuevo movimiento de stock')
@section('subtitle', 'Registra entrada, salida o ajuste de inventario')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('inventario.movimientos.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1.5">Producto</label>
                <select name="product_id" id="product_id" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    <option value="">Seleccionar producto...</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>
                            {{ $p->name }} (SKU: {{ $p->sku }}) — Stock: {{ $p->stock }}
                        </option>
                    @endforeach
                </select>
                @error('product_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de movimiento</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50/50 transition-all cursor-pointer">
                        <input type="radio" name="type" value="entry" checked @checked(old('type') === 'entry')
                            class="text-emerald-500 focus:ring-emerald-400">
                        <span class="text-sm text-gray-700">Entrada</span>
                    </label>
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 has-[:checked]:border-red-400 has-[:checked]:bg-red-50/50 transition-all cursor-pointer">
                        <input type="radio" name="type" value="exit" @checked(old('type') === 'exit')
                            class="text-red-500 focus:ring-red-400">
                        <span class="text-sm text-gray-700">Salida</span>
                    </label>
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50/50 transition-all cursor-pointer">
                        <input type="radio" name="type" value="adjustment" @checked(old('type') === 'adjustment')
                            class="text-amber-500 focus:ring-amber-400">
                        <span class="text-sm text-gray-700">Ajuste</span>
                    </label>
                </div>
                @error('type') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1.5">Cantidad</label>
                <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity') }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                <p class="text-xs text-gray-400 mt-1">Para ajustes, ingresa el stock final deseado.</p>
                @error('quantity') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">Notas <span class="text-gray-400">(opcional)</span></label>
                <textarea name="notes" id="notes" rows="2"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('inventario.movimientos.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    Registrar movimiento
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
