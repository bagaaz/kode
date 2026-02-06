<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    use HasFactory;

    protected $fillable = [
        'fragrance_family_id',
        'concentration_id',
        'occasion_id',
        'intensity_id',
        'created_by',
        'updated_by',
        'code',
        'name',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'top_notes',
        'heart_notes',
        'base_notes',
        'price',
        'compare_at_price',
        'stock_quantity',
        'fixation_min_hours',
        'fixation_max_hours',
        'projection',
        'audience',
        'score',
        'release_order',
        'best_seller_rank',
        'is_active',
        'is_featured',
        'is_new_release',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'top_notes' => 'array',
            'heart_notes' => 'array',
            'base_notes' => 'array',
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'fixation_min_hours' => 'integer',
            'fixation_max_hours' => 'integer',
            'score' => 'integer',
            'release_order' => 'integer',
            'best_seller_rank' => 'integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_release' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function fragranceFamily(): BelongsTo
    {
        return $this->belongsTo(FragranceFamily::class);
    }

    public function concentration(): BelongsTo
    {
        return $this->belongsTo(Concentration::class);
    }

    public function occasion(): BelongsTo
    {
        return $this->belongsTo(Occasion::class);
    }

    public function intensity(): BelongsTo
    {
        return $this->belongsTo(Intensity::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PerfumeImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(PerfumeVariant::class)->orderBy('volume_ml');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PerfumeReview::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(PerfumeCollection::class, 'perfume_collection_items')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
