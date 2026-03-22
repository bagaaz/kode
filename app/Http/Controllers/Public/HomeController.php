<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Perfume;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Perfume::query()
            ->with(['images', 'tags', 'fragranceFamily'])
            ->active()
            ->where('is_featured', true)
            ->orderBy('release_order')
            ->first();

        $launches = Perfume::query()
            ->with(['images', 'tags', 'concentration'])
            ->active()
            ->where('is_new_release', true)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $bestSellers = Perfume::query()
            ->with(['images', 'tags', 'concentration'])
            ->active()
            ->whereNotNull('best_seller_rank')
            ->orderBy('best_seller_rank')
            ->limit(10)
            ->get();

        return view('public.home', [
            'featured'    => $this->mapFeatured($featured),
            'launches'    => $launches->map(fn ($p) => $this->mapProduct($p))->all(),
            'bestSellers' => $bestSellers->map(fn ($p, $i) => $this->mapProduct($p, '#'.($i + 1)))->all(),
        ]);
    }

    private function mapFeatured(?Perfume $perfume): array
    {
        if (! $perfume) {
            return [
                'number'      => '—',
                'name'        => 'Em breve',
                'description' => 'Novidades chegando em breve.',
                'tags'        => [],
                'href'        => route('catalog'),
                'image'       => null,
            ];
        }

        return [
            'number'      => $perfume->code,
            'name'        => $perfume->name,
            'description' => $perfume->short_description ?? $perfume->description,
            'tags'        => $perfume->tags->pluck('name')->all(),
            'href'        => route('parfum', ['name' => $perfume->slug ?? $perfume->code]),
            'image'       => $this->imageUrl($perfume),
        ];
    }

    private function mapProduct(Perfume $perfume, ?string $badge = null): array
    {
        return [
            'number'      => $perfume->code,
            'name'        => $perfume->name,
            'description' => $perfume->short_description ?? $perfume->description,
            'tags'        => $perfume->tags->pluck('name')->all(),
            'badge'       => $badge ?? $perfume->concentration?->name,
            'href'        => route('parfum', ['name' => $perfume->slug ?? $perfume->code]),
            'image'       => $this->imageUrl($perfume),
            'price'       => 'R$ '.number_format((float) $perfume->price, 2, ',', '.'),
        ];
    }

    private function imageUrl(Perfume $perfume): ?string
    {
        $path = $perfume->images->first()?->path;

        return $path ? asset($path) : null;
    }
}
