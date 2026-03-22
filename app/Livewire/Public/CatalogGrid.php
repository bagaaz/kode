<?php

namespace App\Livewire\Public;

use App\Models\Concentration;
use App\Models\FragranceFamily;
use App\Models\Intensity;
use App\Models\Occasion;
use App\Models\Perfume;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogGrid extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sort = 'featured';
    public array $selectedFamilies = [];
    public array $selectedConcentrations = [];
    public array $selectedOccasions = [];
    public array $selectedIntensities = [];

    public int $perPage = 12;

    public array $sortOptions = [
        'featured'   => 'Mais relevantes',
        'newest'     => 'Lançamentos',
        'price_asc'  => 'Preço: menor para maior',
        'price_desc' => 'Preço: maior para menor',
        'name_asc'   => 'Nome: A-Z',
    ];

    public function updated(string $property): void
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function updateSearch(string $value): void
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function updateSort(string $value): void
    {
        $this->sort = array_key_exists($value, $this->sortOptions) ? $value : 'featured';
        $this->resetPage();
    }

    public function render()
    {
        $query = Perfume::query()
            ->with(['images', 'tags', 'fragranceFamily', 'concentration', 'occasion', 'intensity'])
            ->active();

        if (trim($this->search) !== '') {
            $search = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('short_description', 'like', $search)
                  ->orWhere('code', 'like', $search);
            });
        }

        if ($this->selectedFamilies !== []) {
            $query->whereHas('fragranceFamily', fn ($q) => $q->whereIn('slug', $this->selectedFamilies));
        }

        if ($this->selectedConcentrations !== []) {
            $query->whereHas('concentration', fn ($q) => $q->whereIn('slug', $this->selectedConcentrations));
        }

        if ($this->selectedOccasions !== []) {
            $query->whereHas('occasion', fn ($q) => $q->whereIn('slug', $this->selectedOccasions));
        }

        if ($this->selectedIntensities !== []) {
            $query->whereHas('intensity', fn ($q) => $q->whereIn('slug', $this->selectedIntensities));
        }

        match ($this->sort) {
            'newest'     => $query->orderByDesc('created_at'),
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            default      => $query->orderByDesc('is_featured')->orderByDesc('score')->orderBy('name'),
        };

        $paginated = $query->paginate($this->perPage);

        $products = collect($paginated->items())->map(fn (Perfume $p) => $this->mapProduct($p));

        $familyOptions = FragranceFamily::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')
            ->pluck('name', 'slug')->all();

        $concentrationOptions = Concentration::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')
            ->pluck('name', 'slug')->all();

        $occasionOptions = Occasion::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')
            ->pluck('name', 'slug')->all();

        $intensityOptions = Intensity::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')
            ->pluck('name', 'slug')->all();

        $paginatorWithMapped = new LengthAwarePaginator(
            $products,
            $paginated->total(),
            $paginated->perPage(),
            $paginated->currentPage(),
            ['pageName' => 'page', 'path' => request()->url()]
        );

        return view('livewire.public.catalog-grid', [
            'products'             => $paginatorWithMapped,
            'activeFiltersCount'   => $this->activeFiltersCount(),
            'currentSort'          => $this->sort,
            'familyOptions'        => $familyOptions,
            'concentrationOptions' => $concentrationOptions,
            'occasionOptions'      => $occasionOptions,
            'intensityOptions'     => $intensityOptions,
        ]);
    }

    private function mapProduct(Perfume $perfume): array
    {
        $path = $perfume->images->first()?->path;

        return [
            'number'      => $perfume->code,
            'name'        => $perfume->name,
            'description' => $perfume->short_description ?? $perfume->description,
            'tags'        => $perfume->tags->pluck('name')->all(),
            'badge'       => $perfume->concentration?->name,
            'href'        => route('parfum', ['name' => $perfume->slug ?? $perfume->code]),
            'image'       => $path ? Storage::url($path) : null,
            'price'       => 'R$ '.number_format((float) $perfume->price, 2, ',', '.'),
        ];
    }

    private function activeFiltersCount(): int
    {
        return count($this->selectedFamilies)
            + count($this->selectedConcentrations)
            + count($this->selectedOccasions)
            + count($this->selectedIntensities)
            + (trim($this->search) !== '' ? 1 : 0);
    }
}
