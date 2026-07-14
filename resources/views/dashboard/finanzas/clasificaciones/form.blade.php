@extends('layouts.admin')

@section('title', $classification->exists ? 'Editar clasificación' : 'Nueva clasificación')
@section('subtitle', $classification->exists ? 'Actualiza los datos de la clasificación' : 'Registra una nueva clasificación para tus transacciones')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ $classification->exists ? route('finanzas.clasificaciones.update', $classification) : route('finanzas.clasificaciones.store') }}" method="POST">
            @csrf @if($classification->exists) @method('PUT') @endif

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $classification->name) }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipo *</label>
                <select name="type" id="type" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    <option value="ingreso" @selected(old('type', $classification->type) === 'ingreso')>Ingreso</option>
                    <option value="egreso" @selected(old('type', $classification->type) === 'egreso')>Egreso</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('finanzas.clasificaciones.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    {{ $classification->exists ? 'Actualizar' : 'Crear clasificación' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
