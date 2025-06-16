<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengunjung_id')->constrained('pengunjung')->onDelete('cascade');
            $table->timestamp('waktu_masuk');
            $table->enum('keperluan', [
                'Membaca',
                'Pinjam Buku',
                'Kembali Buku',
                'Mengerjakan Tugas',
                'Diskusi',
                'Penelitian',
                'Lainnya'
            ])->default('Membaca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kunjungan');
    }
}; 