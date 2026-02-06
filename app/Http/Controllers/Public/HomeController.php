<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $mockImage = asset('/src/images/mini-perfume-exemplo.jpg');

        $featured = [
            'number' => '07',
            'name' => 'Perfume 07',
            'description' => 'Uma fragrancia sedutora que combina ambar dourado com baunilha de Madagascar. Notas de cafe torrado e chocolate amargo trazem uma qualidade gourmand irresistivel, enquanto patchouli e benjoim conferem profundidade.',
            'tags' => ['Unissex', 'Climas frios', 'Noites especiais', 'Fixacao intensa'],
            'href' => route('parfum', ['name' => '07']),
            'image' => $mockImage,
        ];

        $launchTemplates = [
            [
                'description' => 'Aromatico mediterraneo fresco e verde.',
                'tags' => ['Fresco', 'Aromatico'],
            ],
            [
                'description' => 'Frutado elegante com toques florais.',
                'tags' => ['Frutado', 'Floral'],
            ],
            [
                'description' => 'Tuberosa hipnotica com fundo cremoso.',
                'tags' => ['Floral', 'Cremoso'],
            ],
            [
                'description' => 'Couro refinado com tabaco e especiarias.',
                'tags' => ['Couro', 'Especiado'],
            ],
        ];

        $launches = [];
        for ($i = 9; $i <= 18; $i++) {
            $number = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            $template = $launchTemplates[($i - 9) % count($launchTemplates)];

            $launches[] = [
                'number' => $number,
                'name' => "Perfume {$number}",
                'description' => $template['description'],
                'tags' => $template['tags'],
                'href' => route('parfum', ['name' => $number]),
                'image' => $mockImage,
            ];
        }

        $bestSellerTemplates = [
            [
                'description' => 'Frescor citrico com fundo amadeirado elegante.',
                'tags' => ['Citrico', 'Amadeirado'],
            ],
            [
                'description' => 'Floral intenso com notas orientais sensuais.',
                'tags' => ['Floral', 'Oriental'],
            ],
            [
                'description' => 'Aquatico fresco com notas minerais unicas.',
                'tags' => ['Aquatico', 'Mineral'],
            ],
            [
                'description' => 'Oud nobre com especiarias orientais refinadas.',
                'tags' => ['Oud', 'Oriental'],
            ],
        ];

        $bestSellers = [];
        for ($i = 1; $i <= 10; $i++) {
            $number = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            $template = $bestSellerTemplates[($i - 1) % count($bestSellerTemplates)];

            $bestSellers[] = [
                'badge' => "#{$i}",
                'number' => $number,
                'name' => "Perfume {$number}",
                'description' => $template['description'],
                'tags' => $template['tags'],
                'href' => route('parfum', ['name' => $number]),
                'image' => $mockImage,
            ];
        }

        return view('public.home', [
            'featured' => $featured,
            'launches' => $launches,
            'bestSellers' => $bestSellers,
        ]);
    }
}
