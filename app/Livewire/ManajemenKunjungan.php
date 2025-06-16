<?php

namespace App\Livewire;

use App\Models\RiwayatKunjungan;
use App\Models\Pengunjung;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ManajemenKunjungan extends Component
{
    use WithPagination;

    public $search = '';
    public $keperluanFilter = '';
    public $tanggalMulai = '';
    public $tanggalSelesai = '';
    public $statusFilter = '';

    public function mount()
    {
        // Default filter ke hari ini
        $this->tanggalMulai = now()->format('Y-m-d');
        $this->tanggalSelesai = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKeperluanFilter()
    {
        $this->resetPage();
    }

    public function updatingTanggalMulai()
    {
        $this->resetPage();
    }

    public function updatingTanggalSelesai()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->keperluanFilter = '';
        $this->tanggalMulai = now()->format('Y-m-d');
        $this->tanggalSelesai = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function filterHariIni()
    {
        $this->tanggalMulai = now()->format('Y-m-d');
        $this->tanggalSelesai = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function filterMingguIni()
    {
        $this->tanggalMulai = now()->startOfWeek()->format('Y-m-d');
        $this->tanggalSelesai = now()->endOfWeek()->format('Y-m-d');
        $this->resetPage();
    }

    public function filterBulanIni()
    {
        $this->tanggalMulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggalSelesai = now()->endOfMonth()->format('Y-m-d');
        $this->resetPage();
    }

    public function hapusKunjungan($id)
    {
        $kunjungan = RiwayatKunjungan::findOrFail($id);
        $kunjungan->delete();
        session()->flash('message', 'Data kunjungan berhasil dihapus!');
    }

    public function render()
    {
        $query = RiwayatKunjungan::with('pengunjung');

        // Filter pencarian
        if ($this->search) {
            $query->whereHas('pengunjung', function($q) {
                $q->where('id_pengunjung', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $this->search . '%');
            });
        }

        // Filter keperluan
        if ($this->keperluanFilter) {
            $query->where('keperluan', $this->keperluanFilter);
        }

        // Filter tanggal
        if ($this->tanggalMulai) {
            $query->whereDate('waktu_masuk', '>=', $this->tanggalMulai);
        }
        if ($this->tanggalSelesai) {
            $query->whereDate('waktu_masuk', '<=', $this->tanggalSelesai);
        }

        $kunjungan = $query->orderBy('waktu_masuk', 'desc')->paginate(15);

        // Statistik
        $totalKunjungan = $query->count();
        $kunjunganHariIni = RiwayatKunjungan::hariIni()->count();
        $pengunjungUnik = $query->distinct('pengunjung_id')->count('pengunjung_id');

        // Keperluan untuk filter
        $daftarKeperluan = RiwayatKunjungan::distinct()->pluck('keperluan');

        return view('livewire.manajemen-kunjungan', [
            'kunjungan' => $kunjungan,
            'totalKunjungan' => $totalKunjungan,
            'kunjunganHariIni' => $kunjunganHariIni,
            'pengunjungUnik' => $pengunjungUnik,
            'daftarKeperluan' => $daftarKeperluan,
        ]);
    }
}
