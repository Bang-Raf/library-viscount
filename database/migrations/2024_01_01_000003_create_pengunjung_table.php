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
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('id_pengunjung')->unique()->comment('ID Pengunjung');
            $table->string('nama_lengkap');
            $table->string('kelas_jabatan')->nullable()->comment('Kelas untuk santri atau Jabatan untuk guru/staf');
            $table->enum('status', ['Aktif', 'Lulus', 'Pindah', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
}; 