<?php

namespace App\Livewire\Public;

use Livewire\Component;

class ProductCarousel extends Component
{
    public string $title = '';
    public ?string $subtitle = null;
    public array $products = [];
    public ?string $actionLabel = null;
    public ?string $actionHref = null;
    public string $sectionClass = '';

    public function render()
    {
        return view('livewire.public.product-carousel');
    }
}
