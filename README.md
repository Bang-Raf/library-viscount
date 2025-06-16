# Lib-In MBS (Sistem Informasi Kunjungan Perpustakaan) MBS Pleret

## �� Deskripsi Sistem

Lib-In MBS adalah sistem informasi yang dirancang khusus untuk mendigitalisasi dan mengotomatisasi pencatatan kehadiran pengunjung perpustakaan MBS Pleret. Sistem ini menyediakan data analitik yang informatif untuk mendukung pengambilan keputusan dan pengembangan layanan perpustakaan.

## 🏗️ Arsitektur Sistem

-   **Framework:** Laravel 11
-   **Frontend:** Laravel Blade + Livewire (untuk interaktivitas real-time)
-   **Database:** SQLite
-   **Autentikasi:** Laravel Session-based Authentication
-   **Styling:** Tailwind CSS

## 📊 Struktur Database

### 1. Tabel `pengunjung`

-   `id` - Primary Key
-   `nis` - Nomor Induk Siswa/Santri (Unique)
-   `nama_lengkap` - Nama lengkap pengunjung
-   `kelas_jabatan` - Kelas (untuk siswa) atau Jabatan (untuk guru/staf)
-   `status` - Status pengunjung (Aktif, Lulus, Pindah, Nonaktif)
-   `created_at`, `updated_at` - Timestamps

### 2. Tabel `users`

-   `id` - Primary Key
-   `name` - Nama lengkap pengguna
-   `username` - Username untuk login
-   `email` - Email address
-   `password` - Password terenkripsi
-   `role` - Role pengguna (administrator, pustakawan)
-   `created_at`, `updated_at` - Timestamps

### 3. Tabel `riwayat_kunjungan`

-   `id` - Primary Key
-   `pengunjung_id` - Foreign Key ke tabel pengunjung
-   `waktu_masuk` - Timestamp waktu masuk
-   `keperluan` - Keperluan kunjungan (Membaca, Pinjam Buku, dll.)
-   `created_at`, `updated_at` - Timestamps

### 4. Tabel `pengumuman`

-   `id` - Primary Key
-   `judul` - Judul pengumuman
-   `isi` - Isi/konten pengumuman
-   `aktif` - Status aktif pengumuman
-   `created_at`, `updated_at` - Timestamps

## 🚀 Instalasi dan Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd lib-in-mbs
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

```bash
# Buat file database SQLite
touch database/database.sqlite  # Linux/Mac
# Atau di Windows PowerShell:
New-Item -Path "database/database.sqlite" -ItemType File

# Jalankan migrations dengan data awal
php artisan migrate:fresh --seed
```

### 5. Install Livewire

```bash
composer require livewire/livewire
```

### 6. Jalankan Server

```bash
php artisan serve
```

Sistem akan tersedia di `http://localhost:8000`

## 👥 Akun Default

Setelah menjalankan seeder, tersedia akun-akun berikut:

### Administrator

-   **Username:** `admin`
-   **Password:** `MBSPleretJaya123`
-   **Akses:** Semua fitur sistem

### Pustakawan

-   **Username:** `pustakawan`
-   **Password:** `PustakawanUtama123`
-   **Akses:** Fitur operasional (tidak termasuk manajemen user)

### Data Sample Pengunjung

-   **NIS:** `2024001` - Novada Putra Qurani (VII B - SMP)
-   **NIS:** `2024002` - Dewa Nuku Jaya (VII A - SMP)
-   **NIS:** `GURU001` - Muh. Fathul Mubin, M.Pd (Plt. Direktur)
-   **NIS:** `GURU002` - Kamiluddin, M.Pd (Wadir. Kesantrian)
-   **NIS:** `GURU003` - Ariel Amarta, S.Sos (Kepala Perpustakaan)
-   **NIS:** `GURU007` - R. Abdullah Hammami, S.Kom (Guru Informatika)

## 🎯 Fitur Sistem

### Modul Publik (Mode Kios)

-   **Pencatatan Kunjungan:** Input NIS dan pilih keperluan kunjungan
-   **Leaderboard Pengunjung:** Top 10 pengunjung terdepan (filter bulan/semester)
-   **Statistik Real-time:** Total kunjungan hari ini
-   **Informasi Perpustakaan:** Jam operasional dan pengumuman terbaru

### Dashboard Manajemen

-   **Dashboard Utama:** Statistik dan grafik kunjungan
-   **Manajemen Pengunjung:** CRUD data pengunjung, import Excel
-   **Manajemen Kunjungan:** Riwayat kunjungan dengan filter dan pencarian
-   **Laporan & Rekapitulasi:** Export data dalam berbagai format
-   **Manajemen Pengumuman:** CRUD pengumuman untuk ditampilkan di kios
-   **Manajemen User:** (Khusus Admin) CRUD akun pustakawan

## 🔧 Komponen Livewire

### 1. KunjunganKios

-   **File:** `app/Livewire/KunjunganKios.php`
-   **View:** `resources/views/livewire/kunjungan-kios.blade.php`
-   **Fungsi:** Halaman utama untuk pencatatan kunjungan mode kios

### 2. Dashboard

-   **File:** `app/Livewire/Dashboard.php`
-   **Fungsi:** Dashboard statistik untuk admin/pustakawan

### 3. ManajemenPengunjung

-   **File:** `app/Livewire/ManajemenPengunjung.php`
-   **Fungsi:** Kelola data pengunjung dengan fitur CRUD

### 4. ManajemenKunjungan

-   **File:** `app/Livewire/ManajemenKunjungan.php`
-   **Fungsi:** Kelola riwayat kunjungan

### 5. LaporanRekapitulasi

-   **File:** `app/Livewire/LaporanRekapitulasi.php`
-   **Fungsi:** Generate dan export laporan

### 6. ManajemenPengumuman

-   **File:** `app/Livewire/ManajemenPengumuman.php`
-   **Fungsi:** Kelola pengumuman

### 7. ManajemenUser

-   **File:** `app/Livewire/ManajemenUser.php`
-   **Fungsi:** (Admin only) Kelola akun pengguna

## 🎨 Tampilan dan UX

### Design System

-   **Color Scheme:** Blue gradient dengan aksen hijau untuk success states
-   **Typography:** Font Figtree dari Bunny Fonts
-   **Components:** Menggunakan Tailwind CSS untuk komponen modern
-   **Responsive:** Design yang responsive untuk berbagai ukuran layar

### Mode Kios

-   Interface sederhana dan user-friendly
-   Input NIS dengan validasi real-time
-   Visual feedback untuk setiap aksi
-   Auto-reset form setelah berhasil input
-   Leaderboard dinamis dengan filter periode

### Dashboard

-   Navigasi sidebar yang intuitif
-   Kartu statistik dengan visual yang menarik
-   Tabel data dengan fitur pencarian dan pagination
-   Form yang user-friendly dengan validasi

## 🔐 Keamanan

-   **Authentication:** Laravel session-based authentication
-   **Authorization:** Role-based access control (RBAC)
-   **CSRF Protection:** Semua form dilindungi CSRF token
-   **Password Hashing:** Menggunakan bcrypt untuk hash password
-   **Input Validation:** Validasi input di client dan server side

## 📈 Fitur Analytics

### Statistik Real-time

-   Total kunjungan hari ini
-   Kunjungan per bulan
-   Kunjungan per semester
-   Top pengunjung dengan ranking

### Laporan

-   Export ke Excel/PDF
-   Filter berdasarkan tanggal
-   Rekapitulasi per periode
-   Analisis pola kunjungan

## 🛠️ Development

### Struktur Direktori

```
lib-in-mbs/
├── app/
│   ├── Http/Controllers/
│   ├── Livewire/           # Komponen Livewire
│   └── Models/             # Eloquent Models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Data seeders
├── resources/
│   └── views/
│       ├── livewire/      # Livewire views
│       ├── auth/          # Authentication views
│       └── layouts/       # Layout templates
└── routes/
    ├── web.php            # Web routes
    └── auth.php           # Authentication routes
```

### Menambah Fitur Baru

1. Buat Livewire component: `php artisan make:livewire NamaKomponen`
2. Implementasi logic di class PHP
3. Design tampilan di file Blade
4. Tambahkan route jika perlu
5. Update navigasi dashboard

## 🚦 Testing

### Manual Testing

1. Akses `http://localhost:8000` untuk mode kios
2. Test input NIS dan pencatatan kunjungan
3. Login ke dashboard dengan akun admin/pustakawan
4. Test semua fitur CRUD
5. Verifikasi permission akses

### Test Data

-   Gunakan NIS sample yang tersedia di seeder
-   Test dengan berbagai keperluan kunjungan
-   Verifikasi statistik dan leaderboard

## 🔧 Troubleshooting

### Common Issues

1. **Error 500 saat akses halaman**

    - Pastikan `.env` sudah dikonfigurasi dengan benar
    - Jalankan `php artisan key:generate`
    - Periksa permission direktori storage

2. **Database tidak terbaca**

    - Pastikan file `database/database.sqlite` sudah dibuat
    - Jalankan `php artisan migrate:fresh --seed`

3. **Livewire tidak berfungsi**

    - Pastikan `@livewireStyles` dan `@livewireScripts` ada di layout
    - Periksa console browser untuk error JavaScript

4. **Login tidak berhasil**
    - Gunakan username, bukan email untuk login
    - Pastikan seeder sudah dijalankan

## 📞 Support

Untuk pertanyaan atau bantuan teknis, silakan hubungi tim pengembang atau buat issue di repository ini.

## 📄 License

Sistem ini dikembangkan khusus untuk MBS Pleret dan dilindungi hak cipta sesuai kebijakan institusi.

---

© 2024 Alfalimbany Tech. Seluruh hak cipta dilindungi undang-undang. | [Tentang Developer](./TENTANG_DEVELOPER.md)

## 🗺️ Entity Relationship Diagram (ERD)

```
[ERD akan ditampilkan di bawah ini]
```

![ERD](#)

### Penjelasan Relasi Model

-   **Pengunjung** memiliki banyak **RiwayatKunjungan** (one-to-many)
-   **RiwayatKunjungan** hanya dimiliki oleh satu **Pengunjung**
-   **User**, **Pengumuman**, dan **Peraturan** tidak saling berelasi secara langsung

### Detail Field & Relasi Model

#### Pengunjung

-   `id` (PK)
-   `id_pengunjung` (unique, string): NIS/NIP
-   `nama_lengkap` (string)
-   `kelas_jabatan` (string, nullable): Kelas/jabatan
-   `status` (enum): Aktif/Lulus/Pindah/Nonaktif
-   Relasi: hasMany ke RiwayatKunjungan

#### RiwayatKunjungan

-   `id` (PK)
-   `pengunjung_id` (FK ke pengunjung.id)
-   `waktu_masuk` (timestamp)
-   `keperluan` (enum): Membaca/Pinjam Buku/dll
-   Relasi: belongsTo ke Pengunjung

#### User

-   `id` (PK)
-   `name`, `username`, `email`, `password`, `role` (enum: administrator/pustakawan)
-   Tidak ada relasi ke tabel lain

#### Pengumuman

-   `id` (PK)
-   `judul`, `isi`, `aktif` (boolean)
-   Tidak ada relasi ke tabel lain

#### Peraturan

-   `id` (PK)
-   `judul`, `isi`, `aktif` (boolean)
-   Tidak ada relasi ke tabel lain

## 🔒 Alur Autentikasi & Otorisasi

-   **Login**: Username & password (bukan email)
-   **Session-based**: Menggunakan session Laravel (driver: database)
-   **Role**: Hanya administrator bisa mengakses/mengelola user
-   **Middleware**: Route dashboard dibungkus `auth`, route user dicek role secara manual
-   **Logout**: POST ke /logout, session dihapus

## ⚙️ Konfigurasi Penting

-   **config/app.php**: Nama, timezone, locale
-   **config/auth.php**: Guard default `web`, provider `users` (model User)
-   **config/session.php**: Driver `database`, lifetime 120 menit
-   **.env**: Pastikan variabel DB, APP_KEY, APP_URL, SESSION_DRIVER, dsb terisi

## 🔄 Alur Data Utama (Livewire)

### KunjunganKios

1. Input NIS → cariPengunjung → validasi status
2. Jika valid, tampilkan form keperluan
3. Simpan kunjungan → RiwayatKunjungan::create
4. Tampilkan pesan sukses/gagal
5. Leaderboard & statistik realtime diambil dari model

### ManajemenPengunjung

-   CRUD data pengunjung, import batch Excel
-   Validasi unik id_pengunjung
-   Pagination, filter status, pencarian

### ManajemenUser

-   CRUD user (khusus admin)
-   Validasi unik username/email
-   Reset password user

### Dashboard

-   Statistik kunjungan, top pengunjung, chart keperluan, kunjungan 7 hari terakhir

## 👣 Contoh User Journey

1. **Santri datang ke perpustakaan** → Input NIS di kios → Pilih keperluan → Data kunjungan tercatat
2. **Pustakawan login dashboard** → Kelola data pengunjung/kunjungan/pengumuman
3. **Admin login dashboard** → Kelola user pustakawan

## 🚀 Deployment ke Production

1. Pastikan environment `.env` sudah di-setup (APP_KEY, DB, SESSION_DRIVER, dsb)
2. Jalankan `composer install --optimize-autoloader --no-dev`
3. Jalankan `php artisan migrate --force`
4. Jalankan `php artisan config:cache && php artisan route:cache && php artisan view:cache`
5. Setup web server (Nginx/Apache) ke public/
6. Pastikan permission storage/ dan bootstrap/cache/ writable
7. Gunakan supervisor/pm2 untuk queue (jika ada)

## 📦 Contoh Payload (Jika Ada API)

Saat ini sistem tidak expose API publik, semua interaksi via web & Livewire.

## 🗂️ Diagram Alur Sistem

```
flowchart TD
  A[Santri Input NIS] --> B{Validasi NIS}
  B -- Tidak Valid --> C[Tampilkan Error]
  B -- Valid --> D[Pilih Keperluan]
  D --> E[Simpan ke RiwayatKunjungan]
  E --> F[Tampilkan Pesan Sukses]
  F --> G[Reset Form]
```

## 🖌️ Manajemen Tema (Theme Management)

Fitur ini memungkinkan admin/pustakawan memilih tema tampilan aplikasi secara global melalui dashboard.

-   **Menu:** Dashboard → Sidebar → Manajemen Tema
-   **Teknologi:** Livewire (`ManajemenTema`), tabel `themes` & `settings`, helper `ThemeHelper`
-   **Alur:**
    1. Pilih tema pada halaman Manajemen Tema.
    2. Klik Simpan Tema.
    3. Halaman reload otomatis, tema langsung aktif di seluruh aplikasi.
-   **Catatan:** Tema `dark` dan `digital` masih dalam tahap pengembangan, saat ini hanya memengaruhi widget jam & kalender.

## 🧩 Widget & Komponen Kustom

### RTC Clock (Widget Jam)

-   Jam digital real-time, timezone Asia/Jakarta
-   4 style: `glass` (glassmorphism), `minimal`, `digital`, `dark`
-   Properti: `style`, `showSeconds`, `class`, `wireIgnore`
-   Efek animasi pulse pada tanggal hari ini
-   Digital & dark: icon jam di kiri, jam & tanggal vertikal
-   Glass: border kaca tebal, efek blur, animasi halus

### Calendar Widget (Widget Kalender)

-   Kalender bulanan, highlight hari ini, hari pertama Senin
-   4 style: `glass`, `minimal`, `digital`, `dark`
-   Properti: `style`, `showHeader`, `highlightToday`, `class`
-   Efek glassmorphism, digital, minimal, dark
-   Keterangan hari ini & sudah lewat di footer

## 🛠️ Helper & Utilitas

### ThemeHelper

-   Mendapatkan tema aktif dari database (tabel settings)
-   Digunakan di layout dan komponen untuk konsistensi tampilan

## 🧩 Komponen Livewire Utama

-   **KunjunganKios:** Pencatatan kunjungan, leaderboard, statistik, pengumuman, peraturan
-   **Dashboard:** Statistik, chart, top pengunjung, kunjungan 7 hari terakhir
-   **ManajemenPengunjung:** CRUD pengunjung, import Excel
-   **ManajemenKunjungan:** Riwayat kunjungan, filter, pencarian
-   **ManajemenUser:** CRUD user (admin), validasi unik
-   **ManajemenTema:** Pilih & simpan tema global
-   **ManajemenPeraturan:** CRUD peraturan
-   **ManajemenPengumuman:** CRUD pengumuman
-   **LaporanRekapitulasi:** Export data, filter, rekap

## 🌐 Routing & Endpoint Utama

-   `/` : Mode kios (pencatatan kunjungan)
-   `/tentang-developer` : Profil developer
-   `/dashboard` : Dashboard utama (auth)
-   `/dashboard/pengunjung` : Manajemen pengunjung
-   `/dashboard/kunjungan` : Manajemen kunjungan
-   `/dashboard/laporan` : Laporan & rekap
-   `/dashboard/pengumuman` : Manajemen pengumuman
-   `/dashboard/users` : Manajemen user (admin)
-   `/dashboard/peraturan` : Manajemen peraturan
-   `/dashboard/theme` : Manajemen tema

## ⚠️ Catatan Pengembangan & Personalisasi

-   Tema dark & digital hanya mengubah widget jam & kalender, layout utama masih mengikuti tema default
-   Widget dan komponen dapat dikustomisasi style-nya via properti
-   Gunakan Livewire untuk interaktivitas, hindari reload JS manual jika bisa redirect dari controller
-   Struktur kode modular, mudah dikembangkan
-   Branding developer dan halaman tentang developer sudah terintegrasi
