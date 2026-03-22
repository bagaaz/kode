<x-layouts.admin :title="'Editar '.ucfirst($label)">
    <section class="space-y-6">
        <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
            <div class="mb-6">
                <h2 class="text-base font-semibold text-stone-900">Editar {{ $label }}</h2>
                <p class="mt-1 text-sm text-stone-600">Atualize os dados de cadastro.</p>
            </div>

            <form action="{{ route('admin.catalog-settings.update', ['type' => $type, 'id' => $item->id]) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-stone-800">Nome</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $item->name) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
                    </div>
                    <div>
                        <label for="slug" class="mb-1 block text-sm font-medium text-stone-800">Slug</label>
                        <input id="slug" name="slug" type="text" value="{{ old('slug', $item->slug) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
                    </div>
                </div>

                <div>
                    <label for="description" class="mb-1 block text-sm font-medium text-stone-800">Descricao</label>
                    <textarea id="description" name="description" rows="3" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('description', $item->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="sort_order" class="mb-1 block text-sm font-medium text-stone-800">Ordem</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
                    </div>
                    @if ($isCollection)
                        <div class="flex items-center gap-5 pt-7">
                            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                                Ativo
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="show_on_home" value="1" @checked(old('show_on_home', $item->show_on_home)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                                Exibir na home
                            </label>
                        </div>
                    @else
                        <div class="flex items-center pt-7">
                            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                                Ativo
                            </label>
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-stone-200 pt-4">
                    <a href="{{ $indexRoute }}" class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 transition hover:bg-stone-100">
                        Cancelar
                    </a>
                    <button type="submit" class="rounded-sm bg-green px-4 py-2 text-sm font-semibold text-stone-50 transition hover:bg-green-hover">
                        Salvar alteracoes
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.admin>
