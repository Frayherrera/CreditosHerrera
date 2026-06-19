@extends('layouts.admin')

@section('title', $supplier->exists ? 'Editar proveedor' : 'Nuevo proveedor')
@section('subtitle', $supplier->exists ? 'Actualiza los datos del proveedor' : 'Registra un nuevo proveedor')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ $supplier->exists ? route('inventario.proveedores.update', $supplier) : route('inventario.proveedores.store') }}"
            method="POST">
            @csrf
            @if($supplier->exists) @method('PUT') @endif

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre de contacto <span class="text-gray-400">(opcional)</span></label>
                <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Teléfono <span class="text-gray-400">(opcional)</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-gray-400">(opcional)</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                </div>
            </div>

            <div class="mb-5">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Dirección <span class="text-gray-400">(opcional)</span></label>
                <textarea name="address" id="address" rows="2"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">Notas <span class="text-gray-400">(opcional)</span></label>
                <textarea name="notes" id="notes" rows="2"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">{{ old('notes', $supplier->notes) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('inventario.proveedores.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    {{ $supplier->exists ? 'Actualizar proveedor' : 'Guardar proveedor' }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
