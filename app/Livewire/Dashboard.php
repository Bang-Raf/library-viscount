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
        // Statistik Umum
        $totalPengunjung = Pengunjung::where('status', 'Aktif')->count();
        $totalKunjunganHariIni = RiwayatKunjungan::hariIni()->count();
        $totalKunjunganBulanIni = RiwayatKunjungan::bulanIni()->count();
        $totalUsers = User::count();

        // Statistik Kunjungan Minggu Ini
        $kunjunganMingguIni = RiwayatKunjungan::whereBetween('waktu_masuk', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Top 5 Pengunjung Aktif
        $topPengunjung = RiwayatKunjungan::with('pengunjung')
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
