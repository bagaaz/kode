<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concentration;
use App\Models\FragranceFamily;
use App\Models\Intensity;
use App\Models\Note;
use App\Models\Occasion;
use App\Models\PerfumeCollection;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CatalogSettingsController extends Controller
{
    public function index(): View
    {
        $counts = [];
        foreach ($this->allTypeConfigs() as $key => $cfg) {
            $counts[$key] = $cfg['model']::query()->count();
        }

        return view('admin.catalog-settings.index', ['counts' => $counts]);
    }

    public function typeIndex(string $type): View
    {
        $config = $this->resolveTypeConfig($type);

        $items = $config['model']::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.catalog-settings.type', [
            'type'         => $type,
            'label'        => $config['label'],
            'labelPlural'  => $config['labelPlural'],
            'items'        => $items,
            'isCollection' => $type === 'collections',
        ]);
    }

    public function storeByType(Request $request, string $type): RedirectResponse
    {
        $config = $this->resolveTypeConfig($type);

        if ($type === 'collections') {
            $data = $this->validateCollection($request);
            $config['model']::create($this->collectionPayload($data));
        } else {
            $data = $this->validateSimpleCatalogEntity($request, $config['model'], $config['label']);
            $config['model']::create($this->simpleEntityPayload($data));
        }

        return back()->with('success', ucfirst($config['labelPlural']).' cadastrado com sucesso.');
    }

    public function quickCreate(Request $request): JsonResponse
    {
        $type = $request->input('type');
        $config = $this->resolveTypeConfig($type);

        $data = $this->validateSimpleCatalogEntity($request, $config['model'], $config['label']);
        $item = $config['model']::create($this->simpleEntityPayload($data));

        return response()->json(['id' => $item->id, 'name' => $item->name]);
    }

    public function edit(string $type, int $id): View
    {
        $config = $this->resolveTypeConfig($type);
        $item = $config['model']::query()->findOrFail($id);

        return view('admin.catalog-settings.edit', [
            'type'        => $type,
            'label'       => $config['label'],
            'item'        => $item,
            'isCollection' => $type === 'collections',
            'indexRoute'  => route('admin.catalog-settings.type', $type),
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
            ->route('admin.catalog-settings.type', $type)
            ->with('success', ucfirst($config['label']).' atualizado com sucesso.');
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $config = $this->resolveTypeConfig($type);
        $item = $config['model']::query()->findOrFail($id);

        try {
            $item->delete();
        } catch (QueryException) {
            return back()->with('error', 'Não foi possível excluir: item em uso por outros registros.');
        }

        return back()->with('success', ucfirst($config['label']).' excluído com sucesso.');
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
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ], [], [
            'name' => "nome da {$entityName}",
            'slug' => "slug da {$entityName}",
        ]);
    }

    private function simpleEntityPayload(array $data): array
    {
        return [
            'name'        => $data['name'],
            'slug'        => Str::slug($data['slug'] ?: $data['name']),
            'description' => $data['description'] ?? null,
            'sort_order'  => (int) ($data['sort_order'] ?? 0),
            'is_active'   => (bool) ($data['is_active'] ?? false),
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
            'description'   => ['nullable', 'string'],
            'sort_order'    => ['nullable', 'integer', 'min:0'],
            'is_active'     => ['nullable', 'boolean'],
            'show_on_home'  => ['nullable', 'boolean'],
        ]);
    }

    private function collectionPayload(array $data): array
    {
        return [
            'name'         => $data['name'],
            'slug'         => Str::slug($data['slug'] ?: $data['name']),
            'description'  => $data['description'] ?? null,
            'sort_order'   => (int) ($data['sort_order'] ?? 0),
            'is_active'    => (bool) ($data['is_active'] ?? false),
            'show_on_home' => (bool) ($data['show_on_home'] ?? false),
        ];
    }

    /** @return array<string, array{model: class-string, label: string, labelPlural: string}> */
    private function allTypeConfigs(): array
    {
        return [
            'families'       => ['model' => FragranceFamily::class,  'label' => 'família',      'labelPlural' => 'família'],
            'concentrations' => ['model' => Concentration::class,    'label' => 'concentração', 'labelPlural' => 'concentração'],
            'occasions'      => ['model' => Occasion::class,         'label' => 'ocasião',      'labelPlural' => 'ocasião'],
            'intensities'    => ['model' => Intensity::class,        'label' => 'intensidade',  'labelPlural' => 'intensidade'],
            'tags'           => ['model' => Tag::class,              'label' => 'tag',          'labelPlural' => 'tag'],
            'collections'    => ['model' => PerfumeCollection::class,'label' => 'coleção',      'labelPlural' => 'coleção'],
            'notes'          => ['model' => Note::class,             'label' => 'nota',         'labelPlural' => 'nota'],
        ];
    }

    private function resolveTypeConfig(string $type): array
    {
        $configs = $this->allTypeConfigs();

        if (! isset($configs[$type])) {
            abort(404);
        }

        return $configs[$type];
    }
}
