<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKunjungan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kunjungan';

    protected $fillable = [
        'pengunjung_id',
        'waktu_masuk',
        'keperluan'
    ];

    protected $casts = [
        'waktu_masuk' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the pengunjung that owns the riwayat kunjungan.
     */
    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengunjung::class);
    }

    /**
     * Scope untuk hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('waktu_masuk', today());
    }

    /**
     * Scope untuk bulan ini
     */
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('waktu_masuk', now()->month)
                    ->whereYear('waktu_masuk', now()->year);
    }

    /**
     * Scope untuk semester ini
     */
    public function scopeSemesterIni($query)
    {
        $currentMonth = now()->month;
        if ($currentMonth >= 7) {
            // Semester ganjil (Juli-Desember)
            return $query->whereBetween('waktu_masuk', [
                now()->startOfYear()->addMonths(6)->startOfMonth(),
                now()->endOfYear()->endOfDay()
            ]);
        } else {
            // Semester genap (Januari-Juni)
            return $query->whereBetween('waktu_masuk', [
                now()->startOfYear()->startOfDay(),
                now()->startOfYear()->addMonths(5)->endOfMonth()->endOfDay()
            ]);
        }
    }
} 