<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengunjung;
use App\Models\Pengumuman;
use App\Models\RiwayatKunjungan;
use App\Models\Peraturan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@mbspleret.sch.id',
            'password' => Hash::make('MBSPleretJaya123'),
            'role' => 'administrator',
        ]);

        // Create pustakawan user
        User::create([
            'name' => 'Pustakawan Utama',
            'username' => 'pustakawan',
            'email' => 'pustakawan@mbspleret.sch.id',
            'password' => Hash::make('PustakawanUtama123'),
            'role' => 'pustakawan',
        ]);

        // Create sample pengunjung
        $pengunjung = [
            [
                'id_pengunjung' => '2024001',
                'nama_lengkap' => 'Novada Putra Qurani',
                'kelas_jabatan' => 'VII B - SMP',
                'status' => 'Aktif',
            ],
            [
                'id_pengunjung' => '2024002',
                'nama_lengkap' => 'Dewa Nuku Jaya',
                'kelas_jabatan' => 'VII A - SMP',
                'status' => 'Aktif',
            ],
            [
                'id_pengunjung' => 'GURU001',
                'nama_lengkap' => 'Muh. Fathul Mubin, M.Pd',
                'kelas_jabatan' => 'Plt. Direktur',
                'status' => 'Aktif',
            ],
            [
                'id_pengunjung' => 'GURU002',
                'nama_lengkap' => 'Kamiluddin, M.Pd',
                'kelas_jabatan' => 'Wadir. Kesantrian',
                'status' => 'Aktif',
            ],
            [
                'id_pengunjung' => 'GURU003',
                'nama_lengkap' => 'Ariel Amarta, S.Sos',
                'kelas_jabatan' => 'Kepala Perpustakaan',
                'status' => 'Aktif',
            ],
            [
                'id_pengunjung' => 'GURU007',
                'nama_lengkap' => 'R. Abdullah Hammami, S.Kom',
                'kelas_jabatan' => 'Guru Informatika',
                'status' => 'Aktif',
            ],
        ];

        foreach ($pengunjung as $data) {
            Pengunjung::create($data);
        }

        // Create sample pengumuman
        Pengumuman::create([
            'judul' => 'Jam Operasional Perpustakaan',
            'isi' => 'Perpustakaan buka setiap hari Senin-Kamis pukul 07:00-16:00, Jumat 07:00-11:00, dan Sabtu 07:00-14:00.',
            'aktif' => true,
        ]);

        Pengumuman::create([
            'judul' => 'Peraturan Penggunaan Perpustakaan',
            'isi' => 'Harap menjaga ketenangan, tidak makan dan minum di area baca, serta mengembalikan buku pada tempatnya setelah selesai membaca.',
            'aktif' => true,
        ]);

        // Create sample riwayat kunjungan
        $pengunjungIds = Pengunjung::pluck('id')->toArray();
        
        for ($i = 0; $i < 20; $i++) {
            RiwayatKunjungan::create([
                'pengunjung_id' => $pengunjungIds[array_rand($pengunjungIds)],
                'waktu_masuk' => Carbon::now()->subDays(rand(0, 7))->addHours(rand(7, 15)),
                'keperluan' => ['Membaca', 'Pinjam Buku', 'Kembali Buku', 'Mengerjakan Tugas', 'Diskusi', 'Lainnya'][array_rand(['Membaca', 'Pinjam Buku', 'Kembali Buku', 'Mengerjakan Tugas', 'Diskusi', 'Lainnya'])],
        ]);
        }

        // Seeder SOP Ketertiban Pemustaka
        Peraturan::insert([
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka wajib melepaskan alas kaki dan memastikan kaki telah kering dan bersih sebelum memasuki ruang perpustakaan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka menggunakan pakaian rapi dan sopan selama di ruangan (jam pagi-siang)',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka tidak diperkenankan membawa makanan dan minuman ke dalam perpustakaan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka hanya diperbolehkan membawa air mineral dan diletakkan di area khusus yang disediakan untuk minum',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka tidak diperkenankan membawa buku pribadi dari luar (sementara)',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka mengisi daftar kunjungan di buku atau perangkat yang telah disediakan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka wajib mengikuti SOP penggunaan komputer yang sudah ditetapkan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka wajib menjaga ketenangan selama di ruang perpustakaan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka meletakkan buku yang telah dibaca pada troli/kotak khusus yang telah disediakan, jika belum tersedia maka cukup meninggalkan buku di meja yang ada',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka wajib memperhatikan adab-adab terhadap buku, seperti: tidak meletakkan buku di lantai, tidak merobek, melipat, mencoret, mengotori dan tindakan-tindakan apapun yang dapat merusak buku',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka disediakan sticky note untuk menandai buku yang sedang dibaca',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka wajib menaati pustakawan dalam hal berkaitan dengan keluar dan masuk ruangan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Pemustaka merapikan kembali meja, kursi, dan inventaris lainnya sebelum meninggalkan perpustakaan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Ketertiban Pemustaka',
                'isi' => 'Penggunaan AC hanya diperkenankan saat jadwal buka untuk umum atau ketika ada rapat ustadz/ah',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder SOP Komputer
        Peraturan::insert([
            [
                'judul' => 'SOP Komputer',
                'isi' => 'Setiap anak diberi waktu maksimal 15 menit untuk menggunakan komputer',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Komputer',
                'isi' => 'Komputer hanya digunakan untuk mencari informasi teks atau teks bergambar',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Komputer',
                'isi' => 'Penggunaan komputer untuk melihat video harus melalui izin pustakawan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Komputer',
                'isi' => 'Tidak boleh menggunakan komputer untuk keperluan organisasi',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Komputer',
                'isi' => 'Komputer boleh digunakan untuk persiapan lomba eksternal',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'SOP Komputer',
                'isi' => 'Seluruh santri harus menaati keputusan pustakawan terkait dengan penggunaan komputer',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('themes')->insert([
            [
                'name' => 'minimal',
                'label' => 'Minimal / Light',
                'description' => 'Tema minimalis dan terang, cocok untuk tampilan bersih dan sederhana.',
            ],
            [
                'name' => 'dark',
                'label' => 'Dark',
                'description' => 'Tema gelap yang nyaman untuk mata di malam hari.',
            ],
            [
                'name' => 'glass',
                'label' => 'Glass',
                'description' => 'Tema glassmorphism modern dengan efek transparan dan blur.',
            ],
            [
                'name' => 'digital',
                'label' => 'Digital',
                'description' => 'Tema digital modern dengan warna-warna cerah dan kontras.',
            ],
        ]);
    }
}
