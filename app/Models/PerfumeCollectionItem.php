<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PerfumeCollectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'perfume_collection_id',
        'perfume_id',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(PerfumeCollection::class, 'perfume_collection_id');
    }

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }
}
