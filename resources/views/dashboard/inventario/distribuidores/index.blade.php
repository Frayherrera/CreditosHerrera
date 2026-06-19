@extends('layouts.admin')

@section('title', 'Distribuidores')
@section('subtitle', 'Gestión de distribuidores y proveedores')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $distributors->total() }} distribuidores registrados</p>
    <a href="{{ route('inventario.distribuidores.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nuevo distribuidor
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
                @foreach($distributors as $d)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $d->name }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden sm:table-cell">{{ $d->contact_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ $d->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden lg:table-cell">{{ $d->email ?? '—' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('inventario.distribuidores.edit', $d) }}"
                                class="text-sm text-amber-600 hover:text-amber-700 font-medium">Editar</a>
                            <form action="{{ route('inventario.distribuidores.destroy', $d) }}"
                                method="POST" class="inline ml-3"
                                onsubmit="return confirm('¿Eliminar este distribuidor? Los movimientos asociados conservarán el registro.')">
                                @csrf @method('DELETE')
                                <button class="text-sm text-red-500 hover:text-red-600 font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($distributors->isEmpty())
        <div class="flex flex-col items-center py-12 text-center">
            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">No hay distribuidores registrados</p>
            <p class="text-gray-400 text-sm mt-1">Crea tu primer distribuidor para empezar a registrar salidas de inventario.</p>
        </div>
    @endif
</div>
<div class="mt-4">{{ $distributors->links() }}</div>

@endsection
