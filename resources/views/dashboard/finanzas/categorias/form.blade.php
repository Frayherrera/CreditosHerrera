@extends('layouts.admin')

@section('title', $category->exists ? 'Editar categoría' : 'Nueva categoría financiera')
@section('subtitle', $category->exists ? 'Actualiza los datos de la categoría' : 'Registra una nueva categoría para tus transacciones')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ $category->exists ? route('finanzas.categorias.update', $category) : route('finanzas.categorias.store') }}" method="POST">
            @csrf @if($category->exists) @method('PUT') @endif

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipo *</label>
                <select name="type" id="type" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    <option value="ingreso" @selected(old('type', $category->type) === 'ingreso')>Ingreso</option>
                    <option value="egreso" @selected(old('type', $category->type) === 'egreso')>Egreso</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('finanzas.categorias.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    {{ $category->exists ? 'Actualizar' : 'Crear categoría' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
