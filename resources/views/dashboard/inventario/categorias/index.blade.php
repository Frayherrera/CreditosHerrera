@extends('layouts.admin')

@section('title', 'Categorías')
@section('subtitle', 'Organiza tus productos por categorías')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-sm text-gray-500">{{ $categories->total() }} categorías registradas</p>
    </div>
    <a href="{{ route('inventario.categorias.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nueva categoría
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50/50 text-left">
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Productos</th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $category->name }}</p>
                        @if($category->description)
                            <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($category->description, 60) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $category->slug }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-xs font-medium text-gray-600">{{ $category->products_count }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('inventario.categorias.edit', $category) }}" class="text-gray-400 hover:text-gray-700 transition-colors mr-3">Editar</a>
                        <form action="{{ route('inventario.categorias.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 text-sm transition-colors">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($categories->isEmpty())
        <div class="flex flex-col items-center py-12 text-center">
            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">No hay categorías registradas</p>
            <p class="text-gray-400 text-sm mt-1">Crea tu primera categoría para organizar los productos.</p>
        </div>
    @endif
</div>
<div class="mt-4">{{ $categories->links() }}</div>

@endsection
