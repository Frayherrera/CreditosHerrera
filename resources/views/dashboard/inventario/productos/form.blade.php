@extends('layouts.admin')

@section('title', $product->exists ? 'Editar producto' : 'Nuevo producto')
@section('subtitle', $product->exists ? 'Actualiza los datos del producto' : 'Registra un nuevo producto en el catálogo')

@section('content')

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ $product->exists ? route('inventario.productos.update', $product) : route('inventario.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf @if($product->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1.5">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('sku') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">Categoría</label>
                    <select name="category_id" id="category_id" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                        <option value="">Seleccionar...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Estado</label>
                    <select name="status" id="status" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                        <option value="active" @selected(old('status', $product->status) === 'active')>Activo</option>
                        <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactivo</option>
                        <option value="discontinued" @selected(old('status', $product->status) === 'discontinued')>Descontinuado</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1.5">Precio de contado ($)</label>
                    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $product->price) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('price') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="monthly_payment" class="block text-sm font-medium text-gray-700 mb-1.5">Cuota mensual ($)</label>
                    <input type="number" step="0.01" min="0" name="monthly_payment" id="monthly_payment" value="{{ old('monthly_payment', $product->monthly_payment) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('monthly_payment') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1.5">Stock actual</label>
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('stock') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-1.5">Stock mínimo</label>
                    <input type="number" min="0" name="min_stock" id="min_stock" value="{{ old('min_stock', $product->min_stock) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    @error('min_stock') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">Slug <span class="text-gray-400">(opcional)</span></label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('slug') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mt-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Descripción <span class="text-gray-400">(opcional)</span></label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Imágenes <span class="text-gray-400">(opcional, máx 2MB c/u)</span></label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-amber-300 transition-colors">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    <p class="text-sm text-gray-500">Arrastra imágenes aquí o <span class="text-amber-600 font-medium">selecciona archivos</span></p>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="hidden">
                    <button type="button" onclick="this.previousElementSibling.click()" class="mt-2 text-xs text-gray-400 hover:text-gray-600">Seleccionar archivos</button>
                </div>
                @error('images.*') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror

                @if($product->exists && $product->images->isNotEmpty())
                    <div class="flex gap-2 mt-3">
                        @foreach($product->images as $img)
                            <div class="relative">
                                <img src="{{ Storage::disk('s3')->url($img->path) }}" alt="" class="w-14 h-14 rounded-lg object-cover border-2 {{ $img->is_primary ? 'border-amber-400' : 'border-gray-200' }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-2">
                <a href="{{ route('inventario.productos.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    {{ $product->exists ? 'Actualizar producto' : 'Crear producto' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
