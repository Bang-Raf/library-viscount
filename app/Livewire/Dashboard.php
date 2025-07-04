<?php

namespace App\Livewire;

use App\Models\Pengunjung;
use App\Models\RiwayatKunjungan;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $selectedPeriod = 'week';

    public function mount()
    {
        $this->selectedPeriod = 'week';
    }

    public function render()
    {
        // Cache current time calculations to avoid repeated calls
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Statistik Umum - Optimize with single queries where possible
        $totalPengunjung = Pengunjung::where('status', 'Aktif')->count();
        $totalUsers = User::count();
        
        // Optimize visit statistics with fewer queries
        $visitStats = RiwayatKunjungan::selectRaw('
            COUNT(CASE WHEN DATE(waktu_masuk) = ? THEN 1 END) as hari_ini,
            COUNT(CASE WHEN waktu_masuk >= ? AND waktu_masuk <= ? THEN 1 END) as minggu_ini,
            COUNT(CASE WHEN waktu_masuk >= ? AND waktu_masuk <= ? THEN 1 END) as bulan_ini
        ', [
            $today->format('Y-m-d'),
            $startOfWeek->format('Y-m-d H:i:s'),
            $endOfWeek->format('Y-m-d H:i:s'),
            $startOfMonth->format('Y-m-d H:i:s'),
            $endOfMonth->format('Y-m-d H:i:s')
        ])->first();

        $totalKunjunganHariIni = $visitStats->hari_ini;
        $kunjunganMingguIni = $visitStats->minggu_ini;
        $totalKunjunganBulanIni = $visitStats->bulan_ini;

        // Top 5 Pengunjung Aktif - Add index hint for better performance
        $topPengunjung = RiwayatKunjungan::with(['pengunjung' => function($query) {
                $query->select('id', 'nama_lengkap', 'id_pengunjung');
            }])
            ->selectRaw('pengunjung_id, COUNT(*) as total_kunjungan')
            ->groupBy('pengunjung_id')
            ->orderByDesc('total_kunjungan')
            ->limit(5)
            ->get();

        // Kunjungan per Keperluan (Chart Data)
        $kunjunganPerKeperluan = RiwayatKunjungan::selectRaw('keperluan, COUNT(*) as total')
            ->groupBy('keperluan')
            ->orderByDesc('total')
            ->get();

        // Kunjungan 7 Hari Terakhir
        $kunjungan7Hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $jumlah = RiwayatKunjungan::whereDate('waktu_masuk', $tanggal)->count();
            $kunjungan7Hari[] = [
                'tanggal' => $tanggal->format('d/m'),
                'hari' => $tanggal->translatedFormat('D'),
                'jumlah' => $jumlah
            ];
        }

        // Pengunjung terbaru hari ini
        $pengunjungTerbaru = RiwayatKunjungan::with('pengunjung')
            ->hariIni()
            ->latest('waktu_masuk')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', [
            'totalPengunjung' => $totalPengunjung,
            'totalKunjunganHariIni' => $totalKunjunganHariIni,
            'totalKunjunganBulanIni' => $totalKunjunganBulanIni,
            'kunjunganMingguIni' => $kunjunganMingguIni,
            'totalUsers' => $totalUsers,
            'topPengunjung' => $topPengunjung,
            'kunjunganPerKeperluan' => $kunjunganPerKeperluan,
            'kunjungan7Hari' => $kunjungan7Hari,
            'pengunjungTerbaru' => $pengunjungTerbaru,
        ]);
    }
}
