<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Perfume;

class ParfumController extends Controller
{
    public function index()
    {
        $slug = (string) request()->route('name', '');

        $perfume = Perfume::query()
            ->with(['images', 'tags', 'fragranceFamily', 'concentration', 'occasion', 'intensity', 'variants'])
            ->active()
            ->where('slug', $slug)
            ->orWhere('code', $slug)
            ->first();

        if (! $perfume) {
            abort(404);
        }

        $primaryImage = $perfume->images->where('is_primary', true)->first()
            ?? $perfume->images->first();

        $galleryImages = $perfume->images->map(fn ($img) => [
            'url'   => asset($img->path),
            'label' => $img->alt_text ?? 'Imagem',
            'hint'  => 'frasco',
        ])->all();

        $notes = array_filter([
            $perfume->top_notes   ? 'Topo: '.implode(', ', $perfume->top_notes)   : null,
            $perfume->heart_notes ? 'Coração: '.implode(', ', $perfume->heart_notes) : null,
            $perfume->base_notes  ? 'Fundo: '.implode(', ', $perfume->base_notes)  : null,
        ]);

        $fixation = $perfume->fixation_min_hours && $perfume->fixation_max_hours
            ? "{$perfume->fixation_min_hours} a {$perfume->fixation_max_hours} horas"
            : ($perfume->fixation_min_hours ? "{$perfume->fixation_min_hours}+ horas" : '—');

        $volumes = $perfume->variants->pluck('volume_ml')->map(fn ($v) => "{$v}ml")->all();
        if (empty($volumes)) {
            $volumes = ['50ml', '100ml', '150ml'];
        }

        $related = Perfume::query()
            ->with(['images'])
            ->active()
            ->where('id', '!=', $perfume->id)
            ->where('fragrance_family_id', $perfume->fragrance_family_id)
            ->limit(4)
            ->get()
            ->map(fn ($p) => [
                'number' => $p->code,
                'name'   => $p->name,
                'price'  => 'R$ '.number_format((float) $p->price, 2, ',', '.'),
                'tag'    => $p->fragranceFamily?->name ?? '—',
                'href'   => route('parfum', ['name' => $p->slug ?? $p->code]),
                'image'  => $p->images->first()?->path ? asset($p->images->first()->path) : null,
            ])->all();

        return view('public.parfum', [
            'perfume'      => $perfume,
            'primaryImage' => $primaryImage ? asset($primaryImage->path) : null,
            'gallery'      => $galleryImages,
            'notes'        => array_values($notes),
            'fixation'     => $fixation,
            'volumes'      => $volumes,
            'related'      => $related,
        ]);
    }
}
