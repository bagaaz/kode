<section class="py-10 md:py-12">
    <div class="mx-auto w-full max-w-6xl px-4">
        <div class="mb-8 flex justify-end">
            <div class="flex w-full flex-col gap-3 md:w-auto md:flex-row md:items-center">
                <div class="relative min-w-[16rem]">
                    <x-lucide-search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400" />
                    <input
                        type="text"
                        value="{{ $search }}"
                        wire:input.debounce.300ms="updateSearch($event.target.value)"
                        placeholder="Buscar perfume..."
                        class="h-11 w-full rounded-sm border border-stone-300 pl-10 pr-3 text-sm text-stone-800 placeholder:text-stone-400 focus:border-stone-500 focus:outline-none focus:ring-2 focus:ring-stone-300/50"
                    />
                </div>

                <select
                    wire:change="updateSort($event.target.value)"
                    class="h-11 rounded-sm border border-stone-300 px-3 text-sm text-stone-800 focus:border-stone-500 focus:outline-none focus:ring-2 focus:ring-stone-300/50"
                >
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($currentSort === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
            <aside class="h-fit rounded-md border border-stone-200 p-5 shadow-sm lg:sticky lg:top-24">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-stone-900">Filtros</h2>
                    @if ($activeFiltersCount > 0)
                        <span class="text-xs font-medium uppercase tracking-wide text-amber-600">
                            {{ $activeFiltersCount }} ativo(s)
                        </span>
                    @endif
                </div>

                <details open class="border-t border-stone-200 py-4">
                    <summary class="cursor-pointer list-none text-sm font-semibold text-stone-900">
                        Familia olfativa
                    </summary>
                    <div class="mt-3 space-y-2">
                        @foreach ($familyOptions as $value => $label)
                            <label class="flex items-center gap-2 text-sm text-stone-700">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedFamilies"
                                    value="{{ $value }}"
                                    class="h-4 w-4 rounded border-stone-300 text-green focus:ring-green/30"
                                />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </details>

                <details open class="border-t border-stone-200 py-4">
                    <summary class="cursor-pointer list-none text-sm font-semibold text-stone-900">
                        Concentracao
                    </summary>
                    <div class="mt-3 space-y-2">
                        @foreach ($concentrationOptions as $value => $label)
                            <label class="flex items-center gap-2 text-sm text-stone-700">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedConcentrations"
                                    value="{{ $value }}"
                                    class="h-4 w-4 rounded border-stone-300 text-green focus:ring-green/30"
                                />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </details>

                <details open class="border-t border-stone-200 py-4">
                    <summary class="cursor-pointer list-none text-sm font-semibold text-stone-900">
                        Ocasiao
                    </summary>
                    <div class="mt-3 space-y-2">
                        @foreach ($occasionOptions as $value => $label)
                            <label class="flex items-center gap-2 text-sm text-stone-700">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedOccasions"
                                    value="{{ $value }}"
                                    class="h-4 w-4 rounded border-stone-300 text-green focus:ring-green/30"
                                />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </details>

                <details open class="border-y border-stone-200 py-4">
                    <summary class="cursor-pointer list-none text-sm font-semibold text-stone-900">
                        Intensidade
                    </summary>
                    <div class="mt-3 space-y-2">
                        @foreach ($intensityOptions as $value => $label)
                            <label class="flex items-center gap-2 text-sm text-stone-700">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedIntensities"
                                    value="{{ $value }}"
                                    class="h-4 w-4 rounded border-stone-300 text-green focus:ring-green/30"
                                />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </details>
            </aside>

            <div>
                @if (empty($products->items()))
                    <div class="rounded-2xl border border-dashed border-stone-300 px-6 py-16 text-center">
                        <h3 class="text-xl font-bold text-stone-900">Nenhum perfume encontrado</h3>
                        <p class="mt-3 text-stone-600">
                            Ajuste os filtros para encontrar uma nova combinacao.
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($products as $product)
                            <div wire:key="catalog-product-{{ $product['number'] }}">
                                <x-public.product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-8 border-t border-stone-200 pt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
