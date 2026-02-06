<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PerfumeVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'perfume_id',
        'sku',
        'volume_ml',
        'price',
        'compare_at_price',
        'stock_quantity',
        'is_default',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'volume_ml' => 'integer',
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }
}
