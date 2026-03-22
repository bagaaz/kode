<x-layouts.admin title="Configurações do Catálogo">
    <section class="space-y-6">
        <div>
            <p class="text-sm text-stone-500">Gerencie as opções que alimentam filtros e formulários de perfumes.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @php
                $types = [
                    ['type' => 'families',       'label' => 'Famílias olfativas',  'icon' => 'lucide-leaf',        'description' => 'Famílias como floral, amadeirado, cítrico...'],
                    ['type' => 'concentrations', 'label' => 'Concentrações',        'icon' => 'lucide-droplets',    'description' => 'EDP, EDT, parfum e variações...'],
                    ['type' => 'occasions',      'label' => 'Ocasiões',             'icon' => 'lucide-calendar',    'description' => 'Dia a dia, noite, trabalho...'],
                    ['type' => 'intensities',    'label' => 'Intensidades',         'icon' => 'lucide-flame',       'description' => 'Leve, moderado, intenso...'],
                    ['type' => 'tags',           'label' => 'Tags',                 'icon' => 'lucide-tag',         'description' => 'Palavras-chave para filtros...'],
                    ['type' => 'collections',    'label' => 'Coleções',             'icon' => 'lucide-package',     'description' => 'Coleções especiais de perfumes...'],
                    ['type' => 'notes',          'label' => 'Notas olfativas',      'icon' => 'lucide-flower-2',    'description' => 'Ingredientes: bergamota, sândalo...'],
                ];
            @endphp

            @foreach ($types as $t)
                <a
                    href="{{ route('admin.catalog-settings.type', $t['type']) }}"
                    class="group flex items-start gap-4 rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:border-green/40 hover:shadow-md"
                >
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-stone-100 text-stone-500 transition group-hover:bg-green/10 group-hover:text-green">
                        <x-dynamic-component :component="$t['icon']" class="h-5 w-5" />
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-stone-900">{{ $t['label'] }}</p>
                            <span class="rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-600">
                                {{ $counts[$t['type']] ?? 0 }}
                            </span>
                        </div>
                        <p class="mt-0.5 text-xs text-stone-500">{{ $t['description'] }}</p>
                    </div>
                    <x-lucide-chevron-right class="ml-auto h-4 w-4 shrink-0 text-stone-300 transition group-hover:text-green" />
                </a>
            @endforeach
        </div>
    </section>
</x-layouts.admin>
