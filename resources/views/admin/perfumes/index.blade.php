<x-layouts.admin title="Cadastro de Perfumes">
    <section class="space-y-8">
        <x-admin.table-card
            title="Perfumes cadastrados"
            description="Controle de status, preço e atributos principais."
        >
            <x-slot:action>
                <x-ui.button href="{{ route('admin.perfumes.create') }}" size="sm" icon="lucide-plus" icon-position="left">
                    Cadastrar
                </x-ui.button>
            </x-slot:action>

            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Código</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Família</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Preço</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-stone-500">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($perfumes as $perfume)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3 font-mono text-xs text-stone-500">{{ $perfume->code }}</td>
                            <td class="px-4 py-3 font-medium text-stone-900">{{ $perfume->name }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $perfume->fragranceFamily?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-stone-600">R$ {{ number_format((float) $perfume->price, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $perfume->is_active ? 'bg-green/10 text-green' : 'bg-red-50 text-red-600' }}">
                                    {{ $perfume->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a
                                        href="{{ route('admin.perfumes.edit', $perfume) }}"
                                        title="Editar"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-sm border border-stone-200 text-stone-600 transition hover:border-stone-300 hover:bg-stone-50"
                                    >
                                        <x-lucide-pencil class="h-3.5 w-3.5" />
                                    </a>
                                    <form action="{{ route('admin.perfumes.toggle-status', $perfume) }}" method="POST" class="inline-flex">
                                        @csrf @method('PATCH')
                                        <button
                                            type="submit"
                                            title="{{ $perfume->is_active ? 'Desativar' : 'Ativar' }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-sm border border-stone-200 text-stone-600 transition hover:border-stone-300 hover:bg-stone-50"
                                        >
                                            @if ($perfume->is_active)
                                                <x-lucide-power-off class="h-3.5 w-3.5" />
                                            @else
                                                <x-lucide-power class="h-3.5 w-3.5" />
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.perfumes.destroy', $perfume) }}" method="POST" class="inline-flex" onsubmit="return confirm('Deseja excluir este perfume?');">
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            title="Excluir"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-sm border border-red-100 text-red-500 transition hover:border-red-200 hover:bg-red-50"
                                        >
                                            <x-lucide-trash-2 class="h-3.5 w-3.5" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-stone-400">Nenhum perfume encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <x-slot:footer>
                {{ $perfumes->links() }}
            </x-slot:footer>
        </x-admin.table-card>
    </section>
</x-layouts.admin>
