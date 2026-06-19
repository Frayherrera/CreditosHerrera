@extends('layouts.admin')

@section('title', $product->name)
@section('subtitle', 'Detalle del producto')

@section('content')

<div class="flex items-center justify-between mb-6">
    <a href="{{ route('inventario.productos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Volver a productos
    </a>
    <a href="{{ route('inventario.productos.edit', $product) }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        Editar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Image --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($product->images->where('is_primary', true)->first())
                <img src="{{ Storage::disk('s3')->url($product->images->where('is_primary', true)->first()->path) }}" alt="" class="w-full aspect-square object-cover">
            @else
                <div class="w-full aspect-square bg-gray-50 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                </div>
            @endif
            @if($product->images->count() > 1)
                <div class="flex gap-2 p-3 border-t border-gray-100">
                    @foreach($product->images as $img)
                        <img src="{{ Storage::disk('s3')->url($img->path) }}" alt="" class="w-12 h-12 rounded-lg object-cover border-2 {{ $img->is_primary ? 'border-amber-400' : 'border-gray-200' }}">
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Info --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">SKU: {{ $product->sku }} · {{ $product->category->name }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'bg-emerald-50 text-emerald-700' : ($product->status === 'inactive' ? 'bg-gray-100 text-gray-600' : 'bg-red-50 text-red-700') }}">
                    {{ $product->status === 'active' ? 'Activo' : ($product->status === 'inactive' ? 'Inactivo' : 'Descontinuado') }}
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Precio contado</p>
                    <p class="text-xl font-bold text-gray-900">${{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Cuota mensual</p>
                    <p class="text-xl font-bold text-amber-600">${{ number_format($product->monthly_payment, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Stock</p>
                    <p class="text-xl font-bold {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-gray-900' }}">{{ $product->stock }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Stock mínimo</p>
                    <p class="text-xl font-bold text-gray-900">{{ $product->min_stock }}</p>
                </div>
            </div>

            @if($product->description)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Descripción</p>
                    <p class="text-sm text-gray-600">{{ $product->description }}</p>
                </div>
            @endif
        </div>

        {{-- Movements history --}}
        @if($product->stockMovements->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Historial de movimientos</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-50 bg-gray-50/50 text-left">
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Cantidad</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Stock anterior</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Stock nuevo</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->stockMovements as $mov)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $mov->type === 'entry' ? 'bg-emerald-50 text-emerald-700' : ($mov->type === 'exit' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                                            @if($mov->type === 'entry')
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            @elseif($mov->type === 'exit')
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            @endif
                                            {{ $mov->type === 'entry' ? 'Entrada' : ($mov->type === 'exit' ? 'Salida' : 'Ajuste') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 font-medium">{{ $mov->quantity }}</td>
                                    <td class="px-6 py-3 text-gray-500">{{ $mov->previous_stock }}</td>
                                    <td class="px-6 py-3 text-gray-500">{{ $mov->new_stock }}</td>
                                    <td class="px-6 py-3 text-gray-500">{{ $mov->user->name ?? '—' }}</td>
                                    <td class="px-6 py-3 text-gray-400 text-xs">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
