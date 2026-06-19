@extends('layouts.admin')

@section('title', 'Proveedores')
@section('subtitle', 'Gestión de proveedores')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $suppliers->total() }} proveedores registrados</p>
    <a href="{{ route('inventario.proveedores.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nuevo proveedor
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50 text-left">
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden sm:table-cell">Contacto</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden md:table-cell">Teléfono</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden lg:table-cell">Email</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $s)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $s->name }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden sm:table-cell">{{ $s->contact_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ $s->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden lg:table-cell">{{ $s->email ?? '—' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('inventario.proveedores.edit', $s) }}"
                                class="text-sm text-amber-600 hover:text-amber-700 font-medium">Editar</a>
                            <form action="{{ route('inventario.proveedores.destroy', $s) }}"
                                method="POST" class="inline ml-3"
                                onsubmit="return confirm('¿Eliminar este proveedor?')">
                                @csrf @method('DELETE')
                                <button class="text-sm text-red-500 hover:text-red-600 font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($suppliers->isEmpty())
        <div class="flex flex-col items-center py-12 text-center">
            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H22m-19.5 0h1.125c.621 0 1.125-.504 1.125-1.125V5.25c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v14.75" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">No hay proveedores registrados</p>
            <p class="text-gray-400 text-sm mt-1">Crea tu primer proveedor para empezar a registrar entradas de inventario.</p>
        </div>
    @endif
</div>
<div class="mt-4">{{ $suppliers->links() }}</div>

@endsection
