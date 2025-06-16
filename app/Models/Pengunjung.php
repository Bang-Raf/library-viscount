<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengunjung extends Model
{
    use HasFactory;

    protected $table = 'pengunjung'; // id_pengunjung sebagai primary unique

    protected $fillable = [
        'id_pengunjung',
        'nama_lengkap',
        'kelas_jabatan',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the riwayat kunjungan for the pengunjung.
     */
    public function riwayatKunjungan(): HasMany
    {
        return $this->hasMany(RiwayatKunjungan::class);
    }

    /**
     * Get the latest kunjungan for the pengunjung.
     */
    public function kunjunganTerakhir()
    {
        return $this->riwayatKunjungan()->latest('waktu_masuk')->first();
    }

    /**
     * Get the total kunjungan count for the pengunjung.
     */
    public function totalKunjungan()
    {
        return $this->riwayatKunjungan()->count();
    }
} 