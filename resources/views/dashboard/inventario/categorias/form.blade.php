@extends('layouts.admin')

@section('title', $category->exists ? 'Editar categoría' : 'Nueva categoría')
@section('subtitle', $category->exists ? 'Actualiza los datos de la categoría' : 'Registra una nueva categoría para tus productos')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ $category->exists ? route('inventario.categorias.update', $category) : route('inventario.categorias.store') }}" method="POST">
            @csrf @if($category->exists) @method('PUT') @endif

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">Slug <span class="text-gray-400">(opcional)</span></label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                <p class="text-xs text-gray-400 mt-1">Si se deja vacío, se genera automáticamente.</p>
                @error('slug') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1.5">Categoría padre <span class="text-gray-400">(opcional)</span></label>
                <select name="parent_id" id="parent_id"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    <option value="">— Sin padre —</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
                    @endforeach
                </select>
                @error('parent_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Descripción <span class="text-gray-400">(opcional)</span></label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">{{ old('description', $category->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('inventario.categorias.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    {{ $category->exists ? 'Actualizar' : 'Crear categoría' }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
