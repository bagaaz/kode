@props([
    'title',
    'submitRoute',
    'items' => collect(),
    'type',
    'namePlaceholder' => 'Nome',
    'slugPlaceholder' => 'Slug (opcional)',
    'descriptionPlaceholder' => 'Descricao',
    'includeShowOnHome' => false,
])

<article class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
    <h3 class="text-sm font-semibold text-stone-900">{{ $title }}</h3>

    <form action="{{ $submitRoute }}" method="POST" class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
        @csrf
        <input name="name" type="text" placeholder="{{ $namePlaceholder }}" class="rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        <input name="slug" type="text" placeholder="{{ $slugPlaceholder }}" class="rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        <textarea name="description" rows="2" placeholder="{{ $descriptionPlaceholder }}" class="sm:col-span-2 rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20"></textarea>
        <div class="flex items-center gap-3">
            <input name="sort_order" type="number" min="0" value="0" class="w-24 rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                Ativo
            </label>
        </div>
        @if ($includeShowOnHome)
            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                <input type="checkbox" name="show_on_home" value="1" class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                Exibir na home
            </label>
        @endif
        <button type="submit" class="sm:justify-self-end rounded-sm bg-green px-4 py-2 text-sm font-semibold text-stone-50 transition hover:bg-green-hover">Adicionar</button>
    </form>

    <div class="mt-4 max-h-56 overflow-auto rounded-sm border border-stone-200">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-stone-800">Nome</th>
                    <th class="px-3 py-2 text-left font-semibold text-stone-800">Status</th>
                    <th class="px-3 py-2 text-right font-semibold text-stone-800">Acoes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($items as $item)
                    <tr>
                        <td class="px-3 py-2 text-stone-900">{{ $item->name }}</td>
                        <td class="px-3 py-2">
                            <div class="inline-flex gap-1">
                                <span class="inline-flex rounded-full px-2 py-1 text-xs {{ $item->is_active ? 'bg-green/10 text-green' : 'bg-red-50 text-red-700' }}">
                                    {{ $item->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                                @if ($includeShowOnHome)
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs {{ $item->show_on_home ? 'bg-gold/30 text-stone-900' : 'bg-stone-100 text-stone-600' }}">
                                        {{ $item->show_on_home ? 'Home' : 'Interna' }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-3 py-2 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.catalog-settings.edit', ['type' => $type, 'id' => $item->id]) }}" class="inline-flex items-center rounded-sm border border-stone-300 p-2 text-stone-700 transition hover:bg-stone-100" title="Editar">
                                    <x-lucide-pencil class="h-4 w-4" />
                                </a>
                                <form action="{{ route('admin.catalog-settings.destroy', ['type' => $type, 'id' => $item->id]) }}" method="POST" class="inline-flex" onsubmit="return confirm('Deseja excluir este registro?');">
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
                        <td colspan="3" class="px-3 py-3 text-sm text-stone-500">Sem registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</article>
