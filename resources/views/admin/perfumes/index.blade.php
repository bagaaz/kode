<x-layouts.admin title="Cadastro de Perfumes">
    <section class="space-y-8">
        <div class="overflow-hidden rounded-md border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-200 px-5 py-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-stone-900">Perfumes cadastrados</h2>
                        <p class="mt-1 text-sm text-stone-600">Controle de status, preco e atributos principais.</p>
                    </div>
                    <a href="{{ route('admin.perfumes.create') }}" class="inline-flex items-center gap-2 rounded-sm bg-green px-3 py-2 text-sm font-semibold text-stone-50 transition hover:bg-green-hover">
                        <x-lucide-plus class="h-4 w-4" />
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-stone-900">Codigo</th>
                            <th class="px-4 py-3 text-left font-semibold text-stone-900">Nome</th>
                            <th class="px-4 py-3 text-left font-semibold text-stone-900">Familia</th>
                            <th class="px-4 py-3 text-left font-semibold text-stone-900">Preco</th>
                            <th class="px-4 py-3 text-left font-semibold text-stone-900">Status</th>
                            <th class="px-4 py-3 text-right font-semibold text-stone-900">Acoes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($perfumes as $perfume)
                            <tr>
                                <td class="px-4 py-3 text-stone-600">{{ $perfume->code }}</td>
                                <td class="px-4 py-3 font-medium text-stone-900">{{ $perfume->name }}</td>
                                <td class="px-4 py-3 text-stone-600">{{ $perfume->fragranceFamily?->name }}</td>
                                <td class="px-4 py-3 text-stone-600">R$ {{ number_format((float) $perfume->price, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $perfume->is_active ? 'bg-green/10 text-green' : 'bg-red-50 text-red-700' }}">
                                        {{ $perfume->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.perfumes.edit', $perfume) }}" class="inline-flex items-center rounded-sm border border-stone-300 p-2 text-stone-700 transition hover:bg-stone-100" title="Editar">
                                            <x-lucide-pencil class="h-4 w-4" />
                                        </a>
                                        <form action="{{ route('admin.perfumes.toggle-status', $perfume) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center rounded-sm border border-stone-300 p-2 text-stone-700 transition hover:bg-stone-100" title="{{ $perfume->is_active ? 'Desativar' : 'Ativar' }}">
                                                @if ($perfume->is_active)
                                                    <x-lucide-power-off class="h-4 w-4" />
                                                @else
                                                    <x-lucide-power class="h-4 w-4" />
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.perfumes.destroy', $perfume) }}" method="POST" class="inline-flex" onsubmit="return confirm('Deseja excluir este perfume?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-sm border border-red-200 p-2 text-red-700 transition hover:bg-red-50" title="Excluir">
                                                <x-lucide-trash-2 class="h-4 w-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-stone-500">Nenhum perfume encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-stone-200 px-4 py-3">
                {{ $perfumes->links() }}
            </div>
        </div>
    </section>
</x-layouts.admin>
