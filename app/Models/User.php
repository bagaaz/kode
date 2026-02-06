<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdPerfumes(): HasMany
    {
        return $this->hasMany(Perfume::class, 'created_by');
    }

    public function updatedPerfumes(): HasMany
    {
        return $this->hasMany(Perfume::class, 'updated_by');
    }

    public function perfumeReviews(): HasMany
    {
        return $this->hasMany(PerfumeReview::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
