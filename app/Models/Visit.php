<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'store_id',
        'visit_date',
        'status',
        'result_status',
        'check_in_time',
        'order_value',
        'fail_reason',
        'notes',
        'simulated_latitude',
        'simulated_longitude',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'check_in_time' => 'datetime',
            'order_value' => 'decimal:2',
            'simulated_latitude' => 'float',
            'simulated_longitude' => 'float',
        ];
    }

    /**
     * Relasi ke sales yang ditugaskan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke toko yang dikunjungi.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Cek apakah kunjungan sudah berstatus Selesai.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'Selesai';
    }

    /**
     * Cek apakah hasil kunjungan Berhasil.
     */
    public function isSuccess(): bool
    {
        return $this->result_status === 'Berhasil';
    }

    /**
     * Scope kunjungan yang direncanakan.
     */
    public function scopePlanned($query)
    {
        return $query->where('status', 'Direncanakan');
    }

    /**
     * Scope kunjungan yang telah selesai.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Selesai');
    }
}

