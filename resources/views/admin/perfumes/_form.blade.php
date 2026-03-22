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

    $primaryImagePath = $perfume?->images?->firstWhere('is_primary', true)?->path ?? '/src/images/mini-perfume-exemplo.jpg';
    $defaultVariant = $perfume?->variants?->firstWhere('is_default', true);
    $dropzoneId = 'dropzone-'.uniqid();
    $inputId = 'cover-image-'.uniqid();
    $previewId = 'cover-preview-'.uniqid();
    $filenameId = 'cover-filename-'.uniqid();
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div>
            <label for="code" class="mb-1 block text-sm font-medium text-stone-800">Codigo</label>
            <input id="code" name="code" type="text" value="{{ old('code', $perfume?->code) }}" placeholder="AURORA-01" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        </div>
        <div class="md:col-span-2">
            <label for="name" class="mb-1 block text-sm font-medium text-stone-800">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name', $perfume?->name) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        </div>
        <div>
            <label for="slug" class="mb-1 block text-sm font-medium text-stone-800">Slug (opcional)</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $perfume?->slug) }}" placeholder="aurora-01" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label for="subtitle" class="mb-1 block text-sm font-medium text-stone-800">Subtitulo</label>
            <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $perfume?->subtitle) }}" placeholder="Eau de Parfum" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-stone-800">Imagem principal</label>
            <div
                id="{{ $dropzoneId }}"
                data-upload-dropzone
                data-target="{{ $inputId }}"
                data-preview="{{ $previewId }}"
                data-filename="{{ $filenameId }}"
                class="flex h-full min-h-[130px] cursor-pointer flex-col items-center justify-center rounded-sm border border-dashed border-stone-300 bg-stone-50 px-4 py-4 text-center transition hover:border-green hover:bg-green/5"
            >
                <x-lucide-upload-cloud class="mb-2 h-5 w-5 text-stone-500" />
                <p class="text-sm font-medium text-stone-700">Arraste a imagem aqui</p>
                <p class="text-xs text-stone-500">ou clique para selecionar um arquivo da sua maquina</p>
                <p id="{{ $filenameId }}" class="mt-2 text-xs font-medium text-green"></p>
                <input id="{{ $inputId }}" name="cover_image" type="file" accept="image/*" class="hidden" />
            </div>
            <p class="mt-1 text-xs text-stone-500">JPG, PNG ou WEBP ate 10MB.</p>
            @error('cover_image')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2">
            <div class="overflow-hidden rounded-sm border border-stone-200 bg-white">
                <img
                    id="{{ $previewId }}"
                    src="{{ $primaryImagePath }}"
                    alt="Preview da imagem do perfume"
                    class="aspect-[16/6] w-full object-cover"
                />
            </div>
        </div>

        <div class="md:col-span-2">
            <label for="short_description" class="mb-1 block text-sm font-medium text-stone-800">Descricao curta</label>
            <textarea id="short_description" name="short_description" rows="2" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('short_description', $perfume?->short_description) }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label for="description" class="mb-1 block text-sm font-medium text-stone-800">Descricao completa</label>
            <textarea id="description" name="description" rows="4" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('description', $perfume?->description) }}</textarea>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div>
            <label for="fragrance_family_id" class="mb-1 block text-sm font-medium text-stone-800">Familia</label>
            <select id="fragrance_family_id" name="fragrance_family_id" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required>
                <option value="">Selecione</option>
                @foreach ($families as $family)
                    <option value="{{ $family->id }}" @selected((string) old('fragrance_family_id', $perfume?->fragrance_family_id) === (string) $family->id)>{{ $family->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="concentration_id" class="mb-1 block text-sm font-medium text-stone-800">Concentracao</label>
            <select id="concentration_id" name="concentration_id" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required>
                <option value="">Selecione</option>
                @foreach ($concentrations as $concentration)
                    <option value="{{ $concentration->id }}" @selected((string) old('concentration_id', $perfume?->concentration_id) === (string) $concentration->id)>{{ $concentration->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="occasion_id" class="mb-1 block text-sm font-medium text-stone-800">Ocasiao</label>
            <select id="occasion_id" name="occasion_id" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required>
                <option value="">Selecione</option>
                @foreach ($occasions as $occasion)
                    <option value="{{ $occasion->id }}" @selected((string) old('occasion_id', $perfume?->occasion_id) === (string) $occasion->id)>{{ $occasion->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="intensity_id" class="mb-1 block text-sm font-medium text-stone-800">Intensidade</label>
            <select id="intensity_id" name="intensity_id" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required>
                <option value="">Selecione</option>
                @foreach ($intensities as $intensity)
                    <option value="{{ $intensity->id }}" @selected((string) old('intensity_id', $perfume?->intensity_id) === (string) $intensity->id)>{{ $intensity->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div>
            <label for="price" class="mb-1 block text-sm font-medium text-stone-800">Preco</label>
            <input id="price" name="price" type="number" value="{{ old('price', $perfume?->price) }}" min="0" step="0.01" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        </div>
        <div>
            <label for="compare_at_price" class="mb-1 block text-sm font-medium text-stone-800">Preco de</label>
            <input id="compare_at_price" name="compare_at_price" type="number" value="{{ old('compare_at_price', $perfume?->compare_at_price) }}" min="0" step="0.01" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>
        <div>
            <label for="stock_quantity" class="mb-1 block text-sm font-medium text-stone-800">Estoque</label>
            <input id="stock_quantity" name="stock_quantity" type="number" value="{{ old('stock_quantity', $perfume?->stock_quantity ?? 0) }}" min="0" step="1" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        </div>
        <div>
            <label for="default_volume_ml" class="mb-1 block text-sm font-medium text-stone-800">Volume padrao (ml)</label>
            <input id="default_volume_ml" name="default_volume_ml" type="number" value="{{ old('default_volume_ml', $defaultVariant?->volume_ml) }}" min="1" step="1" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>
        <div>
            <label for="default_variant_sku" class="mb-1 block text-sm font-medium text-stone-800">SKU padrao</label>
            <input id="default_variant_sku" name="default_variant_sku" type="text" value="{{ old('default_variant_sku', $defaultVariant?->sku) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div>
            <label for="audience" class="mb-1 block text-sm font-medium text-stone-800">Publico</label>
            <select id="audience" name="audience" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">
                <option value="unissex" @selected(old('audience', $perfume?->audience ?? 'unissex') === 'unissex')>Unissex</option>
                <option value="masculino" @selected(old('audience', $perfume?->audience) === 'masculino')>Masculino</option>
                <option value="feminino" @selected(old('audience', $perfume?->audience) === 'feminino')>Feminino</option>
            </select>
        </div>
        <div>
            <label for="projection" class="mb-1 block text-sm font-medium text-stone-800">Projecao</label>
            <input id="projection" name="projection" type="text" value="{{ old('projection', $perfume?->projection ?? 'moderada') }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>
        <div>
            <label for="tag_ids" class="mb-1 block text-sm font-medium text-stone-800">Tags</label>
            <select id="tag_ids" name="tag_ids[]" multiple class="h-[90px] w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array((string) $tag->id, $selectedTags, true))>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div>
            <label for="top_notes" class="mb-1 block text-sm font-medium text-stone-800">Notas de topo (uma por linha)</label>
            <textarea id="top_notes" name="top_notes" rows="3" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('top_notes', $perfume?->top_notes ? implode(PHP_EOL, $perfume->top_notes) : '') }}</textarea>
        </div>
        <div>
            <label for="heart_notes" class="mb-1 block text-sm font-medium text-stone-800">Notas de coracao</label>
            <textarea id="heart_notes" name="heart_notes" rows="3" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('heart_notes', $perfume?->heart_notes ? implode(PHP_EOL, $perfume->heart_notes) : '') }}</textarea>
        </div>
        <div>
            <label for="base_notes" class="mb-1 block text-sm font-medium text-stone-800">Notas de fundo</label>
            <textarea id="base_notes" name="base_notes" rows="3" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">{{ old('base_notes', $perfume?->base_notes ? implode(PHP_EOL, $perfume->base_notes) : '') }}</textarea>
        </div>
    </div>

    <div class="flex flex-col gap-3 border-t border-stone-200 pt-4 md:flex-row md:items-center md:justify-between">
        <div class="flex flex-wrap items-center gap-4 text-sm text-stone-700">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $perfume?->is_active ?? true)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                Ativo
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $perfume?->is_featured ?? false)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                Destaque
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_new_release" value="1" @checked(old('is_new_release', $perfume?->is_new_release ?? false)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
                Lancamento
            </label>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.perfumes.index') }}" class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 transition hover:bg-stone-100">
                Cancelar
            </a>
            <button type="submit" class="rounded-sm bg-green px-4 py-2 text-sm font-semibold text-stone-50 transition hover:bg-green-hover">
                {{ $submitLabel }}
            </button>
        </div>
    </div>
</form>

@once
    <script>
        document.querySelectorAll('[data-upload-dropzone]').forEach((dropzone) => {
            const input = document.getElementById(dropzone.dataset.target);
            const preview = document.getElementById(dropzone.dataset.preview);
            const filename = document.getElementById(dropzone.dataset.filename);

            if (!input) {
                return;
            }

            const prevent = (event) => {
                event.preventDefault();
                event.stopPropagation();
            };

            const setFile = (file) => {
                if (!file) {
                    return;
                }

                filename.textContent = file.name;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        if (preview && event.target?.result) {
                            preview.src = event.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            };

            dropzone.addEventListener('click', () => input.click());

            ['dragenter', 'dragover'].forEach((eventName) => {
                dropzone.addEventListener(eventName, (event) => {
                    prevent(event);
                    dropzone.classList.add('border-green', 'bg-green/5');
                });
            });

            ['dragleave', 'dragend', 'drop'].forEach((eventName) => {
                dropzone.addEventListener(eventName, (event) => {
                    prevent(event);
                    dropzone.classList.remove('border-green', 'bg-green/5');
                });
            });

            dropzone.addEventListener('drop', (event) => {
                const files = event.dataTransfer?.files;
                if (!files || files.length === 0) {
                    return;
                }

                input.files = files;
                setFile(files[0]);
            });

            input.addEventListener('change', (event) => {
                const target = event.target;
                if (!(target instanceof HTMLInputElement) || !target.files || target.files.length === 0) {
                    return;
                }

                setFile(target.files[0]);
            });
        });
    </script>
@endonce
