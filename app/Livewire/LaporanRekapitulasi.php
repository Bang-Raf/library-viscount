<?php

namespace App\Livewire;

use App\Models\RiwayatKunjungan;
use App\Models\Pengunjung;
use Livewire\Component;
use Carbon\Carbon;

class LaporanRekapitulasi extends Component
{
    public $tanggalMulai = '';
    public $tanggalSelesai = '';
    public $keperluanFilter = '';
    public $jenisLaporan = 'kunjungan'; // kunjungan, pengunjung
    public $formatExport = 'csv'; // csv, excel
    
    public function mount()
    {
        // Default ke bulan ini
        $this->tanggalMulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggalSelesai = now()->endOfMonth()->format('Y-m-d');
    }

    public function filterHariIni()
    {
        $this->tanggalMulai = now()->format('Y-m-d');
        $this->tanggalSelesai = now()->format('Y-m-d');
    }

    public function filterMingguIni()
    {
        $this->tanggalMulai = now()->startOfWeek()->format('Y-m-d');
        $this->tanggalSelesai = now()->endOfWeek()->format('Y-m-d');
    }

    public function filterBulanIni()
    {
        $this->tanggalMulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggalSelesai = now()->endOfMonth()->format('Y-m-d');
    }

    public function exportData()
    {
        if (!$this->tanggalMulai || !$this->tanggalSelesai) {
            session()->flash('error', 'Tanggal mulai dan selesai harus diisi!');
            return;
        }

        if (Carbon::parse($this->tanggalMulai)->gt(Carbon::parse($this->tanggalSelesai))) {
            session()->flash('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai!');
            return;
        }

        if ($this->jenisLaporan === 'kunjungan') {
            return $this->exportKunjungan();
        } else {
            return $this->exportPengunjung();
        }
    }

    private function exportKunjungan()
    {
        $query = RiwayatKunjungan::with('pengunjung')
            ->whereDate('waktu_masuk', '>=', $this->tanggalMulai)
            ->whereDate('waktu_masuk', '<=', $this->tanggalSelesai);

        if ($this->keperluanFilter) {
            $query->where('keperluan', $this->keperluanFilter);
        }

        $data = $query->orderBy('waktu_masuk', 'desc')->get();

        $filename = 'laporan_kunjungan_' . $this->tanggalMulai . '_' . $this->tanggalSelesai . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Tanggal',
                'Waktu',
                'ID Pengunjung',
                'Nama Pengunjung',
                'Kelas/Jabatan',
                'Keperluan'
            ]);

            // Data
            foreach ($data as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->waktu_masuk->setTimezone('Asia/Jakarta')->format('d/m/Y'),
                    $item->waktu_masuk->setTimezone('Asia/Jakarta')->format('H:i'),
                    $item->pengunjung->id_pengunjung ?? 'N/A',
                    $item->pengunjung->nama_lengkap ?? 'N/A',
                    $item->pengunjung->kelas_jabatan ?? '-',
                    $item->keperluan
                ]);
            }

            fclose($file);
        };

        session()->flash('message', 'Laporan kunjungan berhasil diexport!');
        return response()->stream($callback, 200, $headers);
    }

    private function exportPengunjung()
    {
        $data = Pengunjung::orderBy('nama_lengkap')->get();

        $filename = 'laporan_pengunjung_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No',
                'ID Pengunjung',
                'Nama Lengkap',
                'Kelas/Jabatan',
                'Status',
                'Total Kunjungan',
                'Kunjungan Terakhir'
            ]);

            // Data
            foreach ($data as $index => $item) {
                $totalKunjungan = $item->riwayatKunjungan()->count();
                $kunjunganTerakhir = $item->riwayatKunjungan()->latest()->first();
                
                fputcsv($file, [
                    $index + 1,
                    $item->id_pengunjung,
                    $item->nama_lengkap,
                    $item->kelas_jabatan ?? '-',
                    $item->status,
                    $totalKunjungan,
                    $kunjunganTerakhir ? $kunjunganTerakhir->waktu_masuk->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        session()->flash('message', 'Laporan pengunjung berhasil diexport!');
        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        // Statistik untuk preview
        $statistik = [];
        
        if ($this->tanggalMulai && $this->tanggalSelesai) {
            $query = RiwayatKunjungan::whereDate('waktu_masuk', '>=', $this->tanggalMulai)
                ->whereDate('waktu_masuk', '<=', $this->tanggalSelesai);
                
            if ($this->keperluanFilter) {
                $query->where('keperluan', $this->keperluanFilter);
            }
            
            $statistik = [
                'total_kunjungan' => $query->count(),
                'pengunjung_unik' => $query->distinct('pengunjung_id')->count(),
                'rata_harian' => $query->count() / max(1, Carbon::parse($this->tanggalMulai)->diffInDays($this->tanggalSelesai) + 1)
            ];
        }

        $daftarKeperluan = RiwayatKunjungan::distinct()->pluck('keperluan');

        return view('livewire.laporan-rekapitulasi', [
            'statistik' => $statistik,
            'daftarKeperluan' => $daftarKeperluan
        ]);
    }
}
