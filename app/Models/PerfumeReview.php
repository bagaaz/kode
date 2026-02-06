<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PerfumeReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'perfume_id',
        'user_id',
        'reviewer_name',
        'rating',
        'title',
        'comment',
        'is_approved',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
