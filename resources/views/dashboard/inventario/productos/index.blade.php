@extends('layouts.admin')

@section('title', 'Productos')
@section('subtitle', 'Gestiona tu catálogo de productos')

@section('content')

<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <p class="text-sm text-gray-500">{{ $products->total() }} productos registrados</p>
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <form action="{{ route('inventario.productos.index') }}" method="GET" class="relative flex-1 sm:flex-initial">
            <input type="text" name="search" value="{{ $search ?? '' }}" autocomplete="off"
                placeholder="Buscar producto o SKU…"
                class="w-full sm:w-64 rounded-xl border-gray-200 bg-gray-50 pl-10 pr-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            @if($search)
                <a href="{{ route('inventario.productos.index') }}"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
        </form>
        <a href="{{ route('inventario.productos.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nuevo
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50/50 text-left">
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Producto</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden md:table-cell">SKU</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden lg:table-cell">Categoría</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Precio</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden sm:table-cell">Cuota</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden sm:table-cell">Estado</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->images->where('is_primary', true)->first())
                                <img src="{{ Storage::disk('s3')->url($product->images->where('is_primary', true)->first()->path) }}" alt="" class="w-9 h-9 rounded-lg object-cover">
                            @else
                                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                                    </svg>
                                </div>
                            @endif
                            <a href="{{ route('inventario.productos.show', $product) }}" class="font-medium text-gray-900 hover:text-amber-600 transition-colors">{{ $product->name }}</a>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-400 hidden md:table-cell">{{ $product->sku }}</td>
                    <td class="px-6 py-4 text-gray-400 hidden lg:table-cell">{{ $product->category->name }}</td>
                    <td class="px-6 py-4 font-medium">${{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-500 hidden sm:table-cell">${{ number_format($product->monthly_payment, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $product->stock <= $product->min_stock ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'bg-emerald-50 text-emerald-700' : ($product->status === 'inactive' ? 'bg-gray-100 text-gray-600' : 'bg-red-50 text-red-700') }}">
                            {{ $product->status === 'active' ? 'Activo' : ($product->status === 'inactive' ? 'Inactivo' : 'Descontinuado') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('inventario.productos.edit', $product) }}" class="text-gray-400 hover:text-gray-700 transition-colors mr-3">Editar</a>
                        <form action="{{ route('inventario.productos.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 text-sm transition-colors">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($products->isEmpty())
        <div class="flex flex-col items-center py-12 text-center">
            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">No hay productos registrados</p>
            <p class="text-gray-400 text-sm mt-1">Crea tu primer producto para empezar a vender.</p>
        </div>
    @endif
</div>
<div class="mt-4">{{ $products->links() }}</div>

@endsection
