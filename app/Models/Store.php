<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'owner_name',
        'phone',
        'address',
        'area',
        'latitude',
        'longitude',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * Relasi ke kunjungan toko.
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Scope untuk toko yang masih aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
