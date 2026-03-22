<x-layouts.admin :title="$labelPlural">
    <section class="space-y-6">

        {{-- Add form --}}
        <x-admin.table-card :title="'Adicionar ' . $label">
            <form action="{{ route('admin.catalog-settings.store', $type) }}" method="POST" class="space-y-4 p-5">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-stone-800">Nome <span class="text-red-500">*</span></label>
                        <input
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="Nome do registro"
                            class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20"
                            required
                        />
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-stone-800">Slug (opcional)</label>
                        <input
                            name="slug"
                            type="text"
                            value="{{ old('slug') }}"
                            placeholder="gerado-automaticamente"
                            class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20"
                        />
                        @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-stone-800">Descrição (opcional)</label>
                        <textarea
                            name="description"
                            rows="2"
                            class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20"
                        >{{ old('description') }}</textarea>
                    </div>

                    @if ($isCollection)
                        <div class="flex items-center gap-4 sm:col-span-2">
                            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="show_on_home" value="1" @checked(old('show_on_home')) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                                Exibir na página inicial
                            </label>
                        </div>
                    @endif

                    <div class="flex items-center gap-6">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-stone-800">Ordem</label>
                            <input
                                name="sort_order"
                                type="number"
                                value="{{ old('sort_order', 0) }}"
                                min="0"
                                class="w-24 rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20"
                            />
                        </div>
                        <div class="pt-6">
                            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                                Ativo
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end border-t border-stone-100 pt-4">
                    <button type="submit" class="rounded-sm bg-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-hover">
                        Adicionar {{ $label }}
                    </button>
                </div>
            </form>
        </x-admin.table-card>

        {{-- List --}}
        <x-admin.table-card :title="$labelPlural" :description="$items->total() . ' registros'">
            <x-slot:action>
                <a href="{{ route('admin.catalog-settings.index') }}" class="flex items-center gap-1.5 text-xs font-medium text-stone-500 transition hover:text-stone-800">
                    <x-lucide-arrow-left class="h-3.5 w-3.5" />
                    Voltar
                </a>
            </x-slot:action>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-200 text-left">
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-stone-500">Nome</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-stone-500">Slug</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-stone-500">Ordem</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-stone-500">Status</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-stone-500"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($items as $item)
                        <tr class="group hover:bg-stone-50">
                            <td class="px-4 py-3 font-medium text-stone-900">{{ $item->name }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-stone-500">{{ $item->slug }}</td>
                            <td class="px-4 py-3 text-stone-600">{{ $item->sort_order }}</td>
                            <td class="px-4 py-3">
                                @if ($item->is_active)
                                    <span class="rounded-full bg-green/10 px-2 py-0.5 text-xs font-medium text-green">Ativo</span>
                                @else
                                    <span class="rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-500">Inativo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 transition group-hover:opacity-100">
                                    <a href="{{ route('admin.catalog-settings.edit', [$type, $item->id]) }}" class="rounded-sm p-1.5 text-stone-400 transition hover:bg-stone-100 hover:text-stone-700">
                                        <x-lucide-pencil class="h-3.5 w-3.5" />
                                    </a>
                                    <form action="{{ route('admin.catalog-settings.destroy', [$type, $item->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-sm p-1.5 text-stone-400 transition hover:bg-red-50 hover:text-red-600">
                                            <x-lucide-trash-2 class="h-3.5 w-3.5" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-stone-400">
                                Nenhum registro cadastrado ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($items->hasPages())
                <x-slot:footer>
                    {{ $items->links() }}
                </x-slot:footer>
            @endif
        </x-admin.table-card>

    </section>
</x-layouts.admin>
