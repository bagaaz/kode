@props([
    'action',
    'method' => 'POST',
    'perfume' => null,
    'families' => collect(),
    'concentrations' => collect(),
    'occasions' => collect(),
    'intensities' => collect(),
    'tags' => collect(),
    'submitLabel' => 'Salvar',
])

@php
    $selectedTags = collect(old('tag_ids', $perfume?->tags?->pluck('id')->all() ?? []))
        ->map(fn ($id) => (string) $id)
        ->all();

    $primaryImagePath = $perfume?->images?->firstWhere('is_primary', true)?->path ?? null;
    $defaultVariant = $perfume?->variants?->firstWhere('is_default', true);
    $dropzoneId = 'dropzone-'.uniqid();
    $inputId = 'cover-image-'.uniqid();
    $previewId = 'cover-preview-'.uniqid();
    $filenameId = 'cover-filename-'.uniqid();
    $quickCreateUrl = route('admin.catalog-settings.quick-create');
@endphp

{{-- Quick-create modal template --}}
<template id="quick-create-modal-template">
    <div
        x-data="{
            open: false,
            loading: false,
            name: '',
            error: '',
            targetSelectId: '',
            label: '',
            type: '',
            init() {
                window.addEventListener('open-quick-create', (e) => {
                    this.targetSelectId = e.detail.selectId;
                    this.label = e.detail.label;
                    this.type = e.detail.type;
                    this.name = '';
                    this.error = '';
                    this.open = true;
                    this.$nextTick(() => this.$refs.nameInput?.focus());
                });
            },
            async submit() {
                if (!this.name.trim()) { this.error = 'O nome é obrigatório.'; return; }
                this.loading = true;
                this.error = '';
                try {
                    const resp = await fetch('{{ $quickCreateUrl }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ type: this.type, name: this.name }),
                    });
                    const data = await resp.json();
                    if (!resp.ok) {
                        this.error = data?.message ?? data?.errors?.name?.[0] ?? 'Erro ao cadastrar.';
                        return;
                    }
                    const select = document.getElementById(this.targetSelectId);
                    if (select) {
                        const opt = new Option(data.name, data.id, true, true);
                        select.appendChild(opt);
                    }
                    this.open = false;
                } catch {
                    this.error = 'Erro de comunicação. Tente novamente.';
                } finally {
                    this.loading = false;
                }
            },
        }"
        id="quick-create-modal"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center"
    >
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="open = false"></div>

        {{-- Dialog --}}
        <div class="relative z-10 w-full max-w-sm rounded-md border border-stone-200 bg-white p-6 shadow-xl" @keydown.escape.window="open = false">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold text-stone-900">Adicionar <span x-text="label"></span></h3>
                <button type="button" @click="open = false" class="text-stone-400 transition hover:text-stone-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-stone-800">Nome</label>
                    <input
                        x-ref="nameInput"
                        type="text"
                        x-model="name"
                        @keydown.enter.prevent="submit()"
                        :placeholder="'Nome d' + (label.match(/^[aeiouAEIOU]/) ? 'a ' : 'o ') + label"
                        class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20"
                    />
                    <p x-show="error" x-text="error" class="mt-1 text-xs text-red-600"></p>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="open = false" class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 transition hover:bg-stone-100">
                        Cancelar
                    </button>
                    <button type="button" @click="submit()" :disabled="loading" class="rounded-sm bg-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-hover disabled:opacity-60">
                        <span x-show="!loading">Adicionar</span>
                        <span x-show="loading">Salvando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

{{-- Mount modal --}}
<div id="quick-create-mount"></div>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- Section: Identificação --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-stone-900">Identificação</h3>
            <p class="mt-0.5 text-xs text-stone-500">Código, nome e slug público do perfume.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-4">
            <div>
                <label for="code" class="mb-1 block text-sm font-medium text-stone-800">Código <span class="text-red-500">*</span></label>
                <input id="code" name="code" type="text" value="{{ old('code', $perfume?->code) }}" placeholder="AURORA-01" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
                @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="name" class="mb-1 block text-sm font-medium text-stone-800">Nome <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $perfume?->name) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="slug" class="mb-1 block text-sm font-medium text-stone-800">Slug <span class="text-xs font-normal text-stone-400">(opcional)</span></label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $perfume?->slug) }}" placeholder="gerado-automaticamente" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
                @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="subtitle" class="mb-1 block text-sm font-medium text-stone-800">Subtítulo</label>
                <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $perfume?->subtitle) }}" placeholder="Eau de Parfum" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
            </div>
            <div class="sm:col-span-3">
                <label for="short_description" class="mb-1 block text-sm font-medium text-stone-800">Descrição curta</label>
                <textarea id="short_description" name="short_description" rows="2" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('short_description', $perfume?->short_description) }}</textarea>
            </div>
            <div class="sm:col-span-4">
                <label for="description" class="mb-1 block text-sm font-medium text-stone-800">Descrição completa</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('description', $perfume?->description) }}</textarea>
            </div>
        </div>
    </div>

    {{-- Section: Imagem --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-stone-900">Imagem principal</h3>
            <p class="mt-0.5 text-xs text-stone-500">JPG, PNG ou WEBP até 10MB.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 md:grid-cols-2">
            <div>
                <div
                    id="{{ $dropzoneId }}"
                    data-upload-dropzone
                    data-target="{{ $inputId }}"
                    data-preview="{{ $previewId }}"
                    data-filename="{{ $filenameId }}"
                    class="flex h-full min-h-[140px] cursor-pointer flex-col items-center justify-center rounded-sm border border-dashed border-stone-300 bg-stone-50 px-4 py-4 text-center transition hover:border-green hover:bg-green/5"
                >
                    <x-lucide-upload-cloud class="mb-2 h-6 w-6 text-stone-400" />
                    <p class="text-sm font-medium text-stone-700">Arraste a imagem aqui</p>
                    <p class="mt-0.5 text-xs text-stone-500">ou clique para selecionar</p>
                    <p id="{{ $filenameId }}" class="mt-2 text-xs font-medium text-green"></p>
                    <input id="{{ $inputId }}" name="cover_image" type="file" accept="image/*" class="hidden" />
                </div>
                @error('cover_image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="overflow-hidden rounded-sm border border-stone-200 bg-stone-50">
                @if ($primaryImagePath)
                    <img
                        id="{{ $previewId }}"
                        src="{{ asset($primaryImagePath) }}"
                        alt="Preview"
                        class="h-full w-full object-cover"
                        style="min-height:140px;max-height:220px"
                    />
                @else
                    <div id="{{ $previewId }}-wrapper" class="flex items-center justify-center gap-3 text-stone-300" style="min-height:140px">
                        <x-lucide-image class="h-8 w-8" />
                        <span class="text-sm">Nenhuma imagem</span>
                    </div>
                    <img id="{{ $previewId }}" src="" alt="Preview" class="hidden w-full object-cover" style="max-height:220px" />
                @endif
            </div>
        </div>
    </div>

    {{-- Section: Classificação --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-stone-900">Classificação</h3>
            <p class="mt-0.5 text-xs text-stone-500">Família, concentração, ocasião e intensidade.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 xl:grid-cols-4">
            @php
                $selects = [
                    ['id' => 'fragrance_family_id',  'label' => 'Família',       'items' => $families,       'type' => 'families',       'qcLabel' => 'família'],
                    ['id' => 'concentration_id',     'label' => 'Concentração',  'items' => $concentrations, 'type' => 'concentrations', 'qcLabel' => 'concentração'],
                    ['id' => 'occasion_id',          'label' => 'Ocasião',       'items' => $occasions,      'type' => 'occasions',      'qcLabel' => 'ocasião'],
                    ['id' => 'intensity_id',         'label' => 'Intensidade',   'items' => $intensities,    'type' => 'intensities',    'qcLabel' => 'intensidade'],
                ];
            @endphp

            @foreach ($selects as $sel)
                <div>
                    <div class="mb-1 flex items-center justify-between">
                        <label for="{{ $sel['id'] }}" class="text-sm font-medium text-stone-800">{{ $sel['label'] }} <span class="text-red-500">*</span></label>
                        <button
                            type="button"
                            onclick="openQuickCreate('{{ $sel['id'] }}', '{{ $sel['qcLabel'] }}', '{{ $sel['type'] }}')"
                            class="flex items-center gap-0.5 text-xs font-medium text-green transition hover:text-green-hover"
                            title="Cadastrar nova {{ $sel['qcLabel'] }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Nova
                        </button>
                    </div>
                    <select id="{{ $sel['id'] }}" name="{{ $sel['id'] }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required>
                        <option value="">Selecione</option>
                        @foreach ($sel['items'] as $item)
                            <option value="{{ $item->id }}" @selected((string) old($sel['id'], $perfume?->{$sel['id']}) === (string) $item->id)>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error($sel['id']) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        {{-- Tags --}}
        <div class="border-t border-stone-100 px-5 py-4">
            <div class="mb-1 flex items-center justify-between">
                <label class="text-sm font-medium text-stone-800">Tags</label>
                <button
                    type="button"
                    onclick="openQuickCreate('tag_ids', 'tag', 'tags')"
                    class="flex items-center gap-0.5 text-xs font-medium text-green transition hover:text-green-hover"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nova tag
                </button>
            </div>
            <select id="tag_ids" name="tag_ids[]" multiple class="h-[100px] w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array((string) $tag->id, $selectedTags, true))>{{ $tag->name }}</option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-stone-400">Segure Ctrl/Cmd para selecionar múltiplas tags.</p>
        </div>
    </div>

    {{-- Section: Preço e estoque --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-stone-900">Preço e estoque</h3>
        </div>
        <div class="grid grid-cols-2 gap-4 p-5 md:grid-cols-5">
            <div>
                <label for="price" class="mb-1 block text-sm font-medium text-stone-800">Preço <span class="text-red-500">*</span></label>
                <input id="price" name="price" type="number" value="{{ old('price', $perfume?->price) }}" min="0" step="0.01" placeholder="0,00" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
                @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="compare_at_price" class="mb-1 block text-sm font-medium text-stone-800">Preço de</label>
                <input id="compare_at_price" name="compare_at_price" type="number" value="{{ old('compare_at_price', $perfume?->compare_at_price) }}" min="0" step="0.01" placeholder="0,00" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
            </div>
            <div>
                <label for="stock_quantity" class="mb-1 block text-sm font-medium text-stone-800">Estoque <span class="text-red-500">*</span></label>
                <input id="stock_quantity" name="stock_quantity" type="number" value="{{ old('stock_quantity', $perfume?->stock_quantity ?? 0) }}" min="0" step="1" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
            </div>
            <div>
                <label for="default_volume_ml" class="mb-1 block text-sm font-medium text-stone-800">Volume padrão (ml)</label>
                <input id="default_volume_ml" name="default_volume_ml" type="number" value="{{ old('default_volume_ml', $defaultVariant?->volume_ml) }}" min="1" step="1" placeholder="100" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
            </div>
            <div>
                <label for="default_variant_sku" class="mb-1 block text-sm font-medium text-stone-800">SKU padrão</label>
                <input id="default_variant_sku" name="default_variant_sku" type="text" value="{{ old('default_variant_sku', $defaultVariant?->sku) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
            </div>
        </div>
    </div>

    {{-- Section: Características --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-stone-900">Características</h3>
            <p class="mt-0.5 text-xs text-stone-500">Público-alvo, projeção e outras informações.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2">
            <div>
                <label for="audience" class="mb-1 block text-sm font-medium text-stone-800">Público <span class="text-red-500">*</span></label>
                <select id="audience" name="audience" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">
                    <option value="unissex" @selected(old('audience', $perfume?->audience ?? 'unissex') === 'unissex')>Unissex</option>
                    <option value="masculino" @selected(old('audience', $perfume?->audience) === 'masculino')>Masculino</option>
                    <option value="feminino" @selected(old('audience', $perfume?->audience) === 'feminino')>Feminino</option>
                </select>
            </div>
            <div>
                <label for="projection" class="mb-1 block text-sm font-medium text-stone-800">Projeção</label>
                <input id="projection" name="projection" type="text" value="{{ old('projection', $perfume?->projection ?? 'moderada') }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
            </div>
        </div>
    </div>

    {{-- Section: Pirâmide olfativa --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-stone-900">Pirâmide olfativa</h3>
            <p class="mt-0.5 text-xs text-stone-500">Uma nota por linha ou separadas por vírgula.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 md:grid-cols-3">
            <div>
                <label for="top_notes" class="mb-1 block text-sm font-medium text-stone-800">Notas de topo</label>
                <textarea id="top_notes" name="top_notes" rows="4" placeholder="Bergamota&#10;Limão&#10;Pimenta rosa" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('top_notes', $perfume?->top_notes ? implode(PHP_EOL, $perfume->top_notes) : '') }}</textarea>
            </div>
            <div>
                <label for="heart_notes" class="mb-1 block text-sm font-medium text-stone-800">Notas de coração</label>
                <textarea id="heart_notes" name="heart_notes" rows="4" placeholder="Rosa&#10;Jasmim&#10;Gerânio" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('heart_notes', $perfume?->heart_notes ? implode(PHP_EOL, $perfume->heart_notes) : '') }}</textarea>
            </div>
            <div>
                <label for="base_notes" class="mb-1 block text-sm font-medium text-stone-800">Notas de fundo</label>
                <textarea id="base_notes" name="base_notes" rows="4" placeholder="Sândalo&#10;Âmbar&#10;Almíscar" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('base_notes', $perfume?->base_notes ? implode(PHP_EOL, $perfume->base_notes) : '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Section: Publicação --}}
    <div class="rounded-md border border-stone-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-5 text-sm text-stone-700">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $perfume?->is_active ?? true)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                    <span class="font-medium">Ativo</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $perfume?->is_featured ?? false)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                    <span class="font-medium">Destaque</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_new_release" value="1" @checked(old('is_new_release', $perfume?->is_new_release ?? false)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                    <span class="font-medium">Lançamento</span>
                </label>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.perfumes.index') }}" class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 transition hover:bg-stone-100">
                    Cancelar
                </a>
                <button type="submit" class="rounded-sm bg-green px-5 py-2 text-sm font-semibold text-white transition hover:bg-green-hover">
                    {{ $submitLabel }}
                </button>
            </div>
        </div>
    </div>
</form>

@once
<script>
    // Mount quick-create modal from template
    (function() {
        const mount = document.getElementById('quick-create-mount');
        const tmpl  = document.getElementById('quick-create-modal-template');
        if (mount && tmpl) {
            mount.appendChild(tmpl.content.cloneNode(true));
        }
    })();

    function openQuickCreate(selectId, label, type) {
        window.dispatchEvent(new CustomEvent('open-quick-create', {
            detail: { selectId, label, type }
        }));
    }

    // Image dropzone
    document.querySelectorAll('[data-upload-dropzone]').forEach((dropzone) => {
        const input    = document.getElementById(dropzone.dataset.target);
        const preview  = document.getElementById(dropzone.dataset.preview);
        const filename = document.getElementById(dropzone.dataset.filename);

        if (!input) return;

        const prevent = (e) => { e.preventDefault(); e.stopPropagation(); };

        const setFile = (file) => {
            if (!file) return;
            filename.textContent = file.name;
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (preview && e.target?.result) {
                        const wrapper = document.getElementById(preview.id + '-wrapper');
                        if (wrapper) wrapper.classList.add('hidden');
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        };

        dropzone.addEventListener('click', () => input.click());
        ['dragenter', 'dragover'].forEach(ev => dropzone.addEventListener(ev, (e) => { prevent(e); dropzone.classList.add('border-green', 'bg-green/5'); }));
        ['dragleave', 'dragend', 'drop'].forEach(ev => dropzone.addEventListener(ev, (e) => { prevent(e); dropzone.classList.remove('border-green', 'bg-green/5'); }));
        dropzone.addEventListener('drop', (e) => { const f = e.dataTransfer?.files; if (f?.length) { input.files = f; setFile(f[0]); } });
        input.addEventListener('change', (e) => { if (e.target.files?.length) setFile(e.target.files[0]); });
    });
</script>
@endonce
