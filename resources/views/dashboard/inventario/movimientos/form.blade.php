@extends('layouts.admin')

@section('title', 'Nuevo movimiento de stock')
@section('subtitle', 'Registra entrada, salida o ajuste de inventario')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('inventario.movimientos.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de movimiento</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50/50 transition-all cursor-pointer">
                        <input type="radio" name="type" value="entry" checked @checked(old('type')==='entry' )
                            class="text-emerald-500 focus:ring-emerald-400"
                            onchange="toggleDistributorField()">
                        <span class="text-sm text-gray-700">Entrada</span>
                    </label>
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 has-[:checked]:border-red-400 has-[:checked]:bg-red-50/50 transition-all cursor-pointer">
                        <input type="radio" name="type" value="exit" @checked(old('type')==='exit' )
                            class="text-red-500 focus:ring-red-400"
                            onchange="toggleDistributorField()">
                        <span class="text-sm text-gray-700">Salida</span>
                    </label>
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50/50 transition-all cursor-pointer">
                        <input type="radio" name="type" value="adjustment" @checked(old('type')==='adjustment' )
                            class="text-amber-500 focus:ring-amber-400"
                            onchange="toggleDistributorField()">
                        <span class="text-sm text-gray-700">Ajuste</span>
                    </label>
                </div>
                @error('type') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>
            <div class="mb-5">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">Fecha del movimiento</label>
                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                @error('date') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5 relative" id="product-search-wrapper">
                <label for="product_search" class="block text-sm font-medium text-gray-700 mb-1.5">Producto</label>
                <input type="text" id="product_search" autocomplete="off" required
                    placeholder="Escribe para buscar producto…"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all"
                    value="{{ old('product_id') ? $products->firstWhere('id', old('product_id'))?->name : '' }}">
                <input type="hidden" name="product_id" id="product_id" value="{{ old('product_id') }}">
                <div id="product-results"
                    class="hidden mt-1 absolute z-50 left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden divide-y divide-gray-100">
                </div>
                <p id="product-error" class="text-red-500 text-xs mt-1.5 hidden">Selecciona un producto de la lista.</p>
                @error('product_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            @php
            $productsJson = $products->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'sku' => $p->sku,
            'stock' => $p->stock,
            ]);
            @endphp

            <script>
                const products = @json($productsJson);

                const searchInput = document.getElementById('product_search');
                const hiddenInput = document.getElementById('product_id');
                const resultsContainer = document.getElementById('product-results');
                const errorMsg = document.getElementById('product-error');

                let selectedProduct = null;

                if (hiddenInput.value) {
                    const match = products.find(p => p.id == hiddenInput.value);
                    if (match) {
                        selectedProduct = match;
                        searchInput.value = match.name;
                    }
                }

                searchInput.addEventListener('input', function() {
                    const q = this.value.toLowerCase().trim();

                    if (selectedProduct && selectedProduct.name.toLowerCase() !== q) {
                        selectedProduct = null;
                        hiddenInput.value = '';
                    }

                    if (q.length === 0) {
                        resultsContainer.classList.add('hidden');
                        resultsContainer.innerHTML = '';
                        return;
                    }

                    const matches = products.filter(p =>
                        p.name.toLowerCase().includes(q) ||
                        p.sku.toLowerCase().includes(q)
                    ).slice(0, 15);

                    if (matches.length === 0) {
                        resultsContainer.classList.add('hidden');
                        resultsContainer.innerHTML = '';
                        return;
                    }

                    resultsContainer.innerHTML = matches.map(p => `
                        <button type="button"
                            class="w-full text-left px-4 py-3 text-sm hover:bg-amber-50 transition-colors flex items-center justify-between gap-2"
                            data-id="${p.id}" data-name="${p.name}">
                            <span class="font-medium text-gray-900">${highlightMatch(p.name, q)}</span>
                            <span class="text-xs text-gray-400 shrink-0">SKU: ${highlightMatch(p.sku, q)} &middot; Stock: ${p.stock}</span>
                        </button>
                    `).join('');

                    resultsContainer.classList.remove('hidden');

                    resultsContainer.querySelectorAll('button').forEach(btn => {
                        btn.addEventListener('click', function() {
                            selectProduct(
                                parseInt(this.dataset.id),
                                this.dataset.name
                            );
                        });
                    });
                });

                function selectProduct(id, name) {
                    selectedProduct = products.find(p => p.id === id);
                    searchInput.value = name;
                    hiddenInput.value = id;
                    resultsContainer.classList.add('hidden');
                    errorMsg.classList.add('hidden');
                }

                function highlightMatch(text, query) {
                    if (!query) return text;
                    const idx = text.toLowerCase().indexOf(query);
                    if (idx === -1) return text;
                    return text.slice(0, idx) +
                        '<span class="bg-amber-200 font-semibold">' +
                        text.slice(idx, idx + query.length) +
                        '</span>' +
                        text.slice(idx + query.length);
                }

                document.addEventListener('click', function(e) {
                    const wrapper = document.getElementById('product-search-wrapper');
                    if (!wrapper.contains(e.target)) {
                        resultsContainer.classList.add('hidden');
                    }
                });

                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        resultsContainer.classList.add('hidden');
                    }
                    if (e.key === 'Enter') {
                        const firstBtn = resultsContainer.querySelector('button');
                        if (firstBtn && !resultsContainer.classList.contains('hidden')) {
                            e.preventDefault();
                            firstBtn.click();
                        }
                    }
                });
            </script>



            <div class="mb-5">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1.5">Cantidad</label>
                <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity') }}" required
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                <p class="text-xs text-gray-400 mt-1">Para ajustes, ingresa el stock final deseado.</p>
                @error('quantity') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div id="supplier-field" class="mb-5 {{ old('type') === 'entry' ? '' : 'hidden' }}">
                <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1.5">Proveedor</label>
                <select name="supplier_id" id="supplier_id"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    <option value="">Seleccionar proveedor...</option>
                    @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" @selected(old('supplier_id')==$s->id)>
                        {{ $s->name }}
                    </option>
                    @endforeach
                </select>
                @error('supplier_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div id="distributor-field" class="mb-5 {{ old('type') === 'exit' ? '' : 'hidden' }}">
                <label for="distributor_id" class="block text-sm font-medium text-gray-700 mb-1.5">Distribuidor</label>
                <select name="distributor_id" id="distributor_id"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">
                    <option value="">Seleccionar distribuidor...</option>
                    @foreach($distributors as $d)
                    <option value="{{ $d->id }}" @selected(old('distributor_id')==$d->id)>
                        {{ $d->name }}
                    </option>
                    @endforeach
                </select>
                @error('distributor_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">Notas <span class="text-gray-400">(opcional)</span></label>
                <textarea name="notes" id="notes" rows="2"
                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400/20 focus:ring-4 focus:bg-white transition-all">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('inventario.movimientos.index') }}" class="px-5 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    Registrar movimiento
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDistributorField() {
        const type = document.querySelector('input[name="type"]:checked')?.value;
        document.getElementById('distributor-field').classList.toggle('hidden', type !== 'exit');
        document.getElementById('supplier-field').classList.toggle('hidden', type !== 'entry');
    }
    toggleDistributorField();
</script>

@endsection