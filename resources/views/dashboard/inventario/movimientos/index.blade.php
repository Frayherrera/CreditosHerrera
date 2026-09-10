@extends('layouts.admin')

@section('title', 'Movimientos de stock')
@section('subtitle', 'Historial de entradas, salidas y ajustes')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-sm text-gray-500">{{ $movements->total() }} movimientos registrados</p>
    </div>
    <a href="{{ route('inventario.movimientos.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nuevo movimiento
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50 text-left">
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Producto</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Cantidad</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden md:table-cell">Antes</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden md:table-cell">Después</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden lg:table-cell">Usuario</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Distribuidor</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Proveedor</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider hidden lg:table-cell">Notas</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 font-medium text-gray-500 text-xs uppercase tracking-wider text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movements as $movement)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $movement->product->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $movement->type === 'entry' ? 'bg-emerald-50 text-emerald-700' : ($movement->type === 'exit' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                                @if($movement->type === 'entry')
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                @elseif($movement->type === 'exit')
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                @endif
                                {{ $movement->type === 'entry' ? 'Entrada' : ($movement->type === 'exit' ? 'Salida' : 'Ajuste') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $movement->quantity }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ $movement->previous_stock }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ $movement->new_stock }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden lg:table-cell">{{ $movement->user->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $movement->distributor->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $movement->supplier->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-400 hidden lg:table-cell max-w-[160px] truncate">{{ $movement->notes ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-900 text-xs whitespace-nowrap">{{ $movement->date?->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('inventario.movimientos.edit', $movement) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487zM19.5 8.25l.5-2.5-2.5.5" />
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('inventario.movimientos.destroy', $movement) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este movimiento? El stock del producto se revertirá.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($movements->isEmpty())
        <div class="flex flex-col items-center py-12 text-center">
            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">No hay movimientos registrados</p>
            <p class="text-gray-400 text-sm mt-1">Registra tu primer movimiento de stock para empezar.</p>
        </div>
    @endif
</div>
<div class="mt-4">{{ $movements->links() }}</div>

@endsection
