<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concentration;
use App\Models\FragranceFamily;
use App\Models\Intensity;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\Tag;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PerfumeController extends Controller
{
    public function index(): View
    {
        return view('admin.perfumes.index', [
            'perfumes' => Perfume::query()
                ->with(['fragranceFamily', 'concentration', 'occasion', 'intensity'])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.perfumes.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $perfume = Perfume::create([
            'fragrance_family_id' => (int) $data['fragrance_family_id'],
            'concentration_id' => (int) $data['concentration_id'],
            'occasion_id' => (int) $data['occasion_id'],
            'intensity_id' => (int) $data['intensity_id'],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'code' => $data['code'],
            'name' => $data['name'],
            'slug' => $this->resolveSlug($data['slug'] ?? null, $data['name']),
            'subtitle' => $data['subtitle'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'top_notes' => $this->notesFromString($data['top_notes'] ?? ''),
            'heart_notes' => $this->notesFromString($data['heart_notes'] ?? ''),
            'base_notes' => $this->notesFromString($data['base_notes'] ?? ''),
            'price' => (float) $data['price'],
            'compare_at_price' => isset($data['compare_at_price']) ? (float) $data['compare_at_price'] : null,
            'stock_quantity' => (int) $data['stock_quantity'],
            'projection' => $data['projection'] ?? null,
            'audience' => $data['audience'],
            'is_featured' => (bool) ($data['is_featured'] ?? false),
            'is_new_release' => (bool) ($data['is_new_release'] ?? false),
            'is_active' => (bool) ($data['is_active'] ?? false),
            'published_at' => (bool) ($data['is_active'] ?? false) ? now() : null,
        ]);

        $this->syncRelatedData($perfume, $data);

        return redirect()
            ->route('admin.perfumes.index')
            ->with('success', 'Perfume cadastrado com sucesso.');
    }

    public function edit(Perfume $perfume): View
    {
        return view('admin.perfumes.edit', $this->formData([
            'perfume' => $perfume->load(['tags', 'images', 'variants']),
        ]));
    }

    public function update(Request $request, Perfume $perfume): RedirectResponse
    {
        $data = $this->validateData($request, $perfume);

        $perfume->update([
            'fragrance_family_id' => (int) $data['fragrance_family_id'],
            'concentration_id' => (int) $data['concentration_id'],
            'occasion_id' => (int) $data['occasion_id'],
            'intensity_id' => (int) $data['intensity_id'],
            'updated_by' => auth()->id(),
            'code' => $data['code'],
            'name' => $data['name'],
            'slug' => $this->resolveSlug($data['slug'] ?? null, $data['name']),
            'subtitle' => $data['subtitle'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'top_notes' => $this->notesFromString($data['top_notes'] ?? ''),
            'heart_notes' => $this->notesFromString($data['heart_notes'] ?? ''),
            'base_notes' => $this->notesFromString($data['base_notes'] ?? ''),
            'price' => (float) $data['price'],
            'compare_at_price' => isset($data['compare_at_price']) ? (float) $data['compare_at_price'] : null,
            'stock_quantity' => (int) $data['stock_quantity'],
            'projection' => $data['projection'] ?? null,
            'audience' => $data['audience'],
            'is_featured' => (bool) ($data['is_featured'] ?? false),
            'is_new_release' => (bool) ($data['is_new_release'] ?? false),
            'is_active' => (bool) ($data['is_active'] ?? false),
            'published_at' => $perfume->published_at ?? ((bool) ($data['is_active'] ?? false) ? now() : null),
        ]);

        $this->syncRelatedData($perfume, $data);

        return redirect()
            ->route('admin.perfumes.index')
            ->with('success', 'Perfume atualizado com sucesso.');
    }

    public function destroy(Perfume $perfume): RedirectResponse
    {
        $perfume->delete();

        return back()->with('success', 'Perfume excluido com sucesso.');
    }

    public function toggleStatus(Perfume $perfume): RedirectResponse
    {
        $perfume->update([
            'is_active' => ! $perfume->is_active,
            'updated_by' => auth()->id(),
            'published_at' => $perfume->is_active ? $perfume->published_at : now(),
        ]);

        return back()->with('success', 'Status do perfume atualizado.');
    }

    private function validateData(Request $request, ?Perfume $perfume = null): array
    {
        return $request->validate([
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('perfumes', 'code')->ignore($perfume?->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('perfumes', 'slug')->ignore($perfume?->id),
            ],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'fragrance_family_id' => ['required', 'exists:fragrance_families,id'],
            'concentration_id' => ['required', 'exists:concentrations,id'],
            'occasion_id' => ['required', 'exists:occasions,id'],
            'intensity_id' => ['required', 'exists:intensities,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'projection' => ['nullable', 'string', 'max:20'],
            'audience' => ['required', 'in:masculino,feminino,unissex'],
            'is_featured' => ['nullable', 'boolean'],
            'is_new_release' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'top_notes' => ['nullable', 'string'],
            'heart_notes' => ['nullable', 'string'],
            'base_notes' => ['nullable', 'string'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'cover_image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'default_volume_ml' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'default_variant_sku' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function syncRelatedData(Perfume $perfume, array $data): void
    {
        $perfume->tags()->sync($data['tag_ids'] ?? []);

        $primaryImage = $perfume->images()->where('is_primary', true)->first();
        $imagePath = $this->resolveCoverImagePath($perfume, $data['cover_image'] ?? null, $primaryImage?->path);

        if ($imagePath !== null) {
            if ($primaryImage) {
                $primaryImage->update([
                    'path' => $imagePath,
                    'alt_text' => $perfume->name,
                ]);
            } else {
                $perfume->images()->create([
                    'path' => $imagePath,
                    'alt_text' => $perfume->name,
                    'sort_order' => 0,
                    'is_primary' => true,
                ]);
            }
        }

        if (! empty($data['default_volume_ml'])) {
            $defaultVariant = $perfume->variants()->where('is_default', true)->first();

            $variantPayload = [
                'sku' => $data['default_variant_sku'] ?: null,
                'volume_ml' => (int) $data['default_volume_ml'],
                'price' => (float) $data['price'],
                'compare_at_price' => isset($data['compare_at_price']) ? (float) $data['compare_at_price'] : null,
                'stock_quantity' => (int) $data['stock_quantity'],
                'is_default' => true,
                'is_active' => true,
            ];

            if ($defaultVariant) {
                $defaultVariant->update($variantPayload);
            } else {
                $perfume->variants()->create($variantPayload);
            }
        }
    }

    private function resolveCoverImagePath(Perfume $perfume, ?UploadedFile $file, ?string $currentPath): ?string
    {
        if ($file) {
            if ($currentPath && str_starts_with($currentPath, '/storage/')) {
                Storage::disk('public')->delete(Str::after($currentPath, '/storage/'));
            }

            $storedPath = $file->store('perfumes', 'public');

            return '/storage/'.$storedPath;
        }

        return $currentPath ?: null;
    }

    private function formData(array $extra = []): array
    {
        return array_merge([
            'families' => FragranceFamily::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'concentrations' => Concentration::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'occasions' => Occasion::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'intensities' => Intensity::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'tags' => Tag::query()->where('is_active', true)->orderBy('name')->get(),
        ], $extra);
    }

    private function resolveSlug(?string $slug, string $name): string
    {
        return Str::slug($slug ?: $name);
    }

    private function notesFromString(string $notes): array
    {
        $parsed = preg_split('/[\n,]+/', $notes) ?: [];

        return array_values(array_filter(array_map(
            static fn (string $item): string => trim($item),
            $parsed
        )));
    }
}
