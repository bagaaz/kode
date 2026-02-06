<?php

namespace App\Livewire\Public;

use Illuminate\Pagination\LengthAwarePaginator;
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

    public int $perPage = 8;

    public array $familyOptions = [
        'citrico' => 'Citrico',
        'floral' => 'Floral',
        'amadeirado' => 'Amadeirado',
        'oriental' => 'Oriental',
        'aquatico' => 'Aquatico',
        'gourmand' => 'Gourmand',
    ];

    public array $concentrationOptions = [
        'parfum' => 'Parfum',
        'eau_de_parfum' => 'Eau de Parfum',
        'eau_de_toilette' => 'Eau de Toilette',
    ];

    public array $occasionOptions = [
        'dia' => 'Dia a dia',
        'noite' => 'Noite',
        'evento' => 'Evento especial',
    ];

    public array $intensityOptions = [
        'suave' => 'Fixacao suave',
        'moderada' => 'Fixacao moderada',
        'intensa' => 'Fixacao intensa',
    ];

    public array $sortOptions = [
        'featured' => 'Mais relevantes',
        'newest' => 'Lancamentos',
        'price_asc' => 'Preco: menor para maior',
        'price_desc' => 'Preco: maior para menor',
        'name_asc' => 'Nome: A-Z',
    ];

    public function updated(string $property): void
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function updatedSort(string $value): void
    {
        if (!array_key_exists($value, $this->sortOptions)) {
            $this->sort = 'featured';
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
        $sort = array_key_exists($this->sort, $this->sortOptions) ? $this->sort : 'featured';
        $allProducts = $this->mockProducts();
        $filteredProducts = $this->filterAndSortProducts($allProducts, $sort);
        $products = $this->paginateArray($filteredProducts);

        return view('livewire.public.catalog-grid', [
            'products' => $products,
            'filteredCount' => count($filteredProducts),
            'totalCount' => count($allProducts),
            'activeFiltersCount' => $this->activeFiltersCount(),
            'currentSort' => $sort,
        ]);
    }

    private function paginateArray(array $items): LengthAwarePaginator
    {
        $page = $this->getPage();
        $total = count($items);
        $results = array_slice($items, ($page - 1) * $this->perPage, $this->perPage);

        return new LengthAwarePaginator(
            $results,
            $total,
            $this->perPage,
            $page,
            [
                'pageName' => 'page',
                'path' => request()->url(),
            ]
        );
    }

    private function filterAndSortProducts(array $products, string $sort): array
    {
        $search = mb_strtolower(trim($this->search));

        $products = array_values(array_filter($products, function (array $product) use ($search): bool {
            if ($this->selectedFamilies !== [] && !in_array($product['family'], $this->selectedFamilies, true)) {
                return false;
            }

            if ($this->selectedConcentrations !== [] && !in_array($product['concentration'], $this->selectedConcentrations, true)) {
                return false;
            }

            if ($this->selectedOccasions !== [] && !in_array($product['occasion'], $this->selectedOccasions, true)) {
                return false;
            }

            if ($this->selectedIntensities !== [] && !in_array($product['intensity'], $this->selectedIntensities, true)) {
                return false;
            }

            if ($search === '') {
                return true;
            }

            $haystack = mb_strtolower($product['name'].' '.$product['description'].' '.implode(' ', $product['tags']));

            return str_contains($haystack, $search);
        }));

        usort($products, static function (array $left, array $right) use ($sort): int {
            return match ($sort) {
                'newest' => $left['release_order'] <=> $right['release_order'],
                'price_asc' => $left['price_value'] <=> $right['price_value'],
                'price_desc' => $right['price_value'] <=> $left['price_value'],
                'name_asc' => strcmp($left['name'], $right['name']),
                default => $right['score'] <=> $left['score'],
            };
        });

        return $products;
    }

    private function activeFiltersCount(): int
    {
        return count($this->selectedFamilies)
            + count($this->selectedConcentrations)
            + count($this->selectedOccasions)
            + count($this->selectedIntensities)
            + (trim($this->search) !== '' ? 1 : 0);
    }

    private function mockProducts(): array
    {
        $mockImage = asset('/src/images/mini-perfume-exemplo.jpg');

        $baseProducts = [
            [
                'number' => '01',
                'name' => 'Aurora 01',
                'description' => 'Bergamota italiana e flor de laranjeira com base ambarada elegante.',
                'family' => 'citrico',
                'concentration' => 'eau_de_parfum',
                'occasion' => 'dia',
                'intensity' => 'moderada',
                'price_value' => 199.90,
                'score' => 94,
                'release_order' => 4,
            ],
            [
                'number' => '02',
                'name' => 'Velour 02',
                'description' => 'Rosa turca, peonia e musk cremoso para uso refinado no trabalho.',
                'family' => 'floral',
                'concentration' => 'eau_de_parfum',
                'occasion' => 'dia',
                'intensity' => 'suave',
                'price_value' => 189.90,
                'score' => 91,
                'release_order' => 8,
            ],
            [
                'number' => '03',
                'name' => 'Santal 03',
                'description' => 'Sandalwood, vetiver e pimenta preta com assinatura seca e sofisticada.',
                'family' => 'amadeirado',
                'concentration' => 'parfum',
                'occasion' => 'noite',
                'intensity' => 'intensa',
                'price_value' => 259.90,
                'score' => 98,
                'release_order' => 2,
            ],
            [
                'number' => '04',
                'name' => 'Atlas 04',
                'description' => 'Notas marinhas, limao siciliano e cedro claro para dias quentes.',
                'family' => 'aquatico',
                'concentration' => 'eau_de_toilette',
                'occasion' => 'dia',
                'intensity' => 'suave',
                'price_value' => 169.90,
                'score' => 88,
                'release_order' => 10,
            ],
            [
                'number' => '05',
                'name' => 'Noir 05',
                'description' => 'Oud, acafrao e baunilha negra em trilha marcante para eventos.',
                'family' => 'oriental',
                'concentration' => 'parfum',
                'occasion' => 'evento',
                'intensity' => 'intensa',
                'price_value' => 299.90,
                'score' => 96,
                'release_order' => 3,
            ],
            [
                'number' => '06',
                'name' => 'Moka 06',
                'description' => 'Cafe torrado, cacau e fava tonka em perfil gourmand envolvente.',
                'family' => 'gourmand',
                'concentration' => 'eau_de_parfum',
                'occasion' => 'noite',
                'intensity' => 'intensa',
                'price_value' => 239.90,
                'score' => 95,
                'release_order' => 5,
            ],
            [
                'number' => '07',
                'name' => 'Iris 07',
                'description' => 'Iris, jasmin e notas atalcadas com acabamento aveludado.',
                'family' => 'floral',
                'concentration' => 'parfum',
                'occasion' => 'evento',
                'intensity' => 'moderada',
                'price_value' => 279.90,
                'score' => 93,
                'release_order' => 1,
            ],
            [
                'number' => '08',
                'name' => 'Solar 08',
                'description' => 'Mandarina verde, neroli e musk limpo para presenca fresca.',
                'family' => 'citrico',
                'concentration' => 'eau_de_toilette',
                'occasion' => 'dia',
                'intensity' => 'suave',
                'price_value' => 159.90,
                'score' => 84,
                'release_order' => 12,
            ],
            [
                'number' => '09',
                'name' => 'Cedro 09',
                'description' => 'Cedro atlas e ambroxan com fundo seco e contemporaneo.',
                'family' => 'amadeirado',
                'concentration' => 'eau_de_parfum',
                'occasion' => 'dia',
                'intensity' => 'moderada',
                'price_value' => 209.90,
                'score' => 90,
                'release_order' => 9,
            ],
            [
                'number' => '10',
                'name' => 'Brise 10',
                'description' => 'Acorde salgado, lavanda e bergamota para estilo leve e limpo.',
                'family' => 'aquatico',
                'concentration' => 'eau_de_parfum',
                'occasion' => 'dia',
                'intensity' => 'moderada',
                'price_value' => 199.90,
                'score' => 87,
                'release_order' => 11,
            ],
            [
                'number' => '11',
                'name' => 'Amber 11',
                'description' => 'Resinas quentes, canela e baunilha para noites frias.',
                'family' => 'oriental',
                'concentration' => 'eau_de_parfum',
                'occasion' => 'noite',
                'intensity' => 'intensa',
                'price_value' => 249.90,
                'score' => 92,
                'release_order' => 6,
            ],
            [
                'number' => '12',
                'name' => 'Praline 12',
                'description' => 'Praline, caramelo seco e musk branco para assinatura doce elegante.',
                'family' => 'gourmand',
                'concentration' => 'parfum',
                'occasion' => 'evento',
                'intensity' => 'intensa',
                'price_value' => 289.90,
                'score' => 97,
                'release_order' => 7,
            ],
            [
                'number' => '13',
                'name' => 'Lumen 13',
                'description' => 'Limao tahiti, cha branco e cedro suave para o cotidiano.',
                'family' => 'citrico',
                'concentration' => 'eau_de_toilette',
                'occasion' => 'dia',
                'intensity' => 'suave',
                'price_value' => 149.90,
                'score' => 82,
                'release_order' => 14,
            ],
            [
                'number' => '14',
                'name' => 'Bloom 14',
                'description' => 'Gardenia luminosa e pera branca com fundo musk cremoso.',
                'family' => 'floral',
                'concentration' => 'eau_de_toilette',
                'occasion' => 'dia',
                'intensity' => 'suave',
                'price_value' => 169.90,
                'score' => 85,
                'release_order' => 13,
            ],
            [
                'number' => '15',
                'name' => 'Smoked 15',
                'description' => 'Madeiras secas, couro limpo e incenso para perfil marcante.',
                'family' => 'amadeirado',
                'concentration' => 'parfum',
                'occasion' => 'evento',
                'intensity' => 'intensa',
                'price_value' => 319.90,
                'score' => 99,
                'release_order' => 0,
            ],
            [
                'number' => '16',
                'name' => 'Velvet 16',
                'description' => 'Patchouli, ameixa escura e resina quente para noite premium.',
                'family' => 'oriental',
                'concentration' => 'parfum',
                'occasion' => 'noite',
                'intensity' => 'intensa',
                'price_value' => 309.90,
                'score' => 95,
                'release_order' => 15,
            ],
        ];

        return array_map(function (array $product) use ($mockImage): array {
            $product['price'] = 'R$ '.number_format((float) $product['price_value'], 2, ',', '.');
            $product['badge'] = $this->concentrationOptions[$product['concentration']];
            $product['href'] = route('parfum', ['name' => $product['number']]);
            $product['image'] = $mockImage;

            return $product;
        }, $baseProducts);
    }
}
