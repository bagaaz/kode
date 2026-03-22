<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concentration;
use App\Models\FragranceFamily;
use App\Models\Intensity;
use App\Models\Occasion;
use App\Models\PerfumeCollection;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CatalogSettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.catalog-settings.index', [
            'families' => FragranceFamily::query()->orderBy('sort_order')->orderBy('name')->get(),
            'concentrations' => Concentration::query()->orderBy('sort_order')->orderBy('name')->get(),
            'occasions' => Occasion::query()->orderBy('sort_order')->orderBy('name')->get(),
            'intensities' => Intensity::query()->orderBy('sort_order')->orderBy('name')->get(),
            'tags' => Tag::query()->orderBy('sort_order')->orderBy('name')->get(),
            'collections' => PerfumeCollection::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function storeFamily(Request $request): RedirectResponse
    {
        $this->createSimpleCatalogEntity($request, FragranceFamily::class, 'familia');

        return back()->with('success', 'Familia cadastrada com sucesso.');
    }

    public function storeConcentration(Request $request): RedirectResponse
    {
        $this->createSimpleCatalogEntity($request, Concentration::class, 'concentracao');

        return back()->with('success', 'Concentracao cadastrada com sucesso.');
    }

    public function storeOccasion(Request $request): RedirectResponse
    {
        $this->createSimpleCatalogEntity($request, Occasion::class, 'ocasiao');

        return back()->with('success', 'Ocasiao cadastrada com sucesso.');
    }

    public function storeIntensity(Request $request): RedirectResponse
    {
        $this->createSimpleCatalogEntity($request, Intensity::class, 'intensidade');

        return back()->with('success', 'Intensidade cadastrada com sucesso.');
    }

    public function storeTag(Request $request): RedirectResponse
    {
        $this->createSimpleCatalogEntity($request, Tag::class, 'tag');

        return back()->with('success', 'Tag cadastrada com sucesso.');
    }

    public function storeCollection(Request $request): RedirectResponse
    {
        $data = $this->validateCollection($request);
        PerfumeCollection::create($this->collectionPayload($data));

        return back()->with('success', 'Colecao cadastrada com sucesso.');
    }

    public function edit(string $type, int $id): View
    {
        $config = $this->resolveTypeConfig($type);
        $item = $config['model']::query()->findOrFail($id);

        return view('admin.catalog-settings.edit', [
            'type' => $type,
            'label' => $config['label'],
            'item' => $item,
            'isCollection' => $type === 'collections',
            'indexRoute' => route('admin.catalog-settings.index'),
        ]);
    }

    public function update(Request $request, string $type, int $id): RedirectResponse
    {
        $config = $this->resolveTypeConfig($type);
        $item = $config['model']::query()->findOrFail($id);

        if ($type === 'collections') {
            $data = $this->validateCollection($request, $item->id);
            $item->update($this->collectionPayload($data));
        } else {
            $data = $this->validateSimpleCatalogEntity($request, $config['model'], $config['label'], $item->id);
            $item->update($this->simpleEntityPayload($data));
        }

        return redirect()
            ->route('admin.catalog-settings.index')
            ->with('success', ucfirst($config['label']).' atualizada com sucesso.');
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $config = $this->resolveTypeConfig($type);
        $item = $config['model']::query()->findOrFail($id);

        try {
            $item->delete();
        } catch (QueryException) {
            return back()->with('error', 'Nao foi possivel excluir: item em uso por outros registros.');
        }

        return back()->with('success', ucfirst($config['label']).' excluida com sucesso.');
    }

    private function createSimpleCatalogEntity(Request $request, string $modelClass, string $entityName): void
    {
        $data = $this->validateSimpleCatalogEntity($request, $modelClass, $entityName);
        $modelClass::create($this->simpleEntityPayload($data));
    }

    private function validateSimpleCatalogEntity(
        Request $request,
        string $modelClass,
        string $entityName,
        ?int $ignoreId = null
    ): array {
        $table = (new $modelClass())->getTable();

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'name')->ignore($ignoreId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique($table, 'slug')->ignore($ignoreId),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'name' => "nome da {$entityName}",
            'slug' => "slug da {$entityName}",
        ]);
    }

    private function simpleEntityPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'slug' => Str::slug($data['slug'] ?: $data['name']),
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ];
    }

    private function validateCollection(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('perfume_collections', 'name')->ignore($ignoreId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('perfume_collections', 'slug')->ignore($ignoreId),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'show_on_home' => ['nullable', 'boolean'],
        ]);
    }

    private function collectionPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'slug' => Str::slug($data['slug'] ?: $data['name']),
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
            'show_on_home' => (bool) ($data['show_on_home'] ?? false),
        ];
    }

    private function resolveTypeConfig(string $type): array
    {
        $config = match ($type) {
            'families' => ['model' => FragranceFamily::class, 'label' => 'familia'],
            'concentrations' => ['model' => Concentration::class, 'label' => 'concentracao'],
            'occasions' => ['model' => Occasion::class, 'label' => 'ocasiao'],
            'intensities' => ['model' => Intensity::class, 'label' => 'intensidade'],
            'tags' => ['model' => Tag::class, 'label' => 'tag'],
            'collections' => ['model' => PerfumeCollection::class, 'label' => 'colecao'],
            default => null,
        };

        if (! $config) {
            abort(404);
        }

        return $config;
    }
}
