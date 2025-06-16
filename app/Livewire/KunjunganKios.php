<?php

namespace App\Livewire;

use App\Models\Pengunjung;
use App\Models\RiwayatKunjungan;
use App\Models\Pengumuman;
use App\Models\Peraturan;
use App\Models\Setting;
use Livewire\Component;
use Carbon\Carbon;

class KunjunganKios extends Component
{
    public $id_pengunjung = '';
    public $pengunjung = null;
    public $showWelcome = false;
    public $keperluan = 'Membaca';
    public $message = '';
    public $messageType = '';
    public $leaderboardPeriod = 'bulan';

    protected $rules = [
        'id_pengunjung' => 'required|string',
        'keperluan' => 'required|string',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'id_pengunjung' && strlen($this->id_pengunjung) >= 3) {
            $this->validateOnly($propertyName);
        }
    }

    public function cariPengunjung()
    {
        $this->validate(['id_pengunjung' => 'required|string']);

        $pengunjung = Pengunjung::where('id_pengunjung', $this->id_pengunjung)
                                 ->where('status', 'Aktif')
                                 ->first();

        if ($pengunjung) {
            // Cek apakah pengunjung sudah tercatat hari ini
            $kunjunganHariIni = RiwayatKunjungan::where('pengunjung_id', $pengunjung->id)
                                                ->whereDate('waktu_masuk', today())
                                                ->first();

            if ($kunjunganHariIni) {
                $this->message = "Halo {$pengunjung->nama_lengkap}! Anda sudah tercatat berkunjung hari ini pada pukul " . 
                               $kunjunganHariIni->waktu_masuk->setTimezone('Asia/Jakarta')->format('H:i') . " WIB untuk keperluan: {$kunjunganHariIni->keperluan}. " .
                               "Setiap pengunjung hanya dapat tercatat sekali per hari.";
                $this->messageType = 'info';
                $this->resetForm();
                return;
            }

            $this->pengunjung = $pengunjung;
            $this->showWelcome = true;
            $this->message = '';
            $this->messageType = '';
        } else {
            $this->message = 'ID Pengunjung tidak ditemukan atau pengunjung tidak aktif';
            $this->messageType = 'error';
            $this->resetForm();
        }
    }

    public function simpanKunjungan()
    {
        if (!$this->pengunjung) {
            $this->message = 'Silakan cari pengunjung terlebih dahulu';
            $this->messageType = 'error';
            return;
        }

        try {
            RiwayatKunjungan::create([
                'pengunjung_id' => $this->pengunjung->id,
                'waktu_masuk' => Carbon::now('Asia/Jakarta'),
                'keperluan' => $this->keperluan,
            ]);

            $this->message = 'Selamat datang ' . $this->pengunjung->nama_lengkap . '! Kunjungan berhasil dicatat.';
            $this->messageType = 'success';
            
            $this->resetForm();
            
            // Auto reset after 3 seconds
            $this->js('setTimeout(() => { $wire.call("clearMessage") }, 3000);');
            
        } catch (\Exception $e) {
            $this->message = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function resetForm()
    {
        $this->id_pengunjung = '';
        $this->pengunjung = null;
        $this->showWelcome = false;
        $this->keperluan = 'Membaca';
    }

    public function clearMessage()
    {
        $this->message = '';
        $this->messageType = '';
        $this->resetForm();
    }

    protected $listeners = ['clearMessage'];

    public function getLeaderboardData()
    {
        $query = RiwayatKunjungan::with('pengunjung')
                                ->selectRaw('pengunjung_id, COUNT(*) as total_kunjungan')
                                ->groupBy('pengunjung_id');

        if ($this->leaderboardPeriod === 'bulan') {
            $query->bulanIni();
        } elseif ($this->leaderboardPeriod === 'semester') {
            $query->semesterIni();
        }

        return $query->orderByDesc('total_kunjungan')
                     ->limit(10)
                     ->get();
    }

    public function getJamOperasionalFormatted()
    {
        $jam = Setting::getJamOperasional();
        $hariList = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu',
        ];
        $grouped = [];
        foreach ($jam as $hari => $waktu) {
            $key = ($waktu['buka'] ?? '-') . '-' . ($waktu['tutup'] ?? '-');
            $grouped[$key][] = $hariList[$hari];
        }
        $result = [];
        foreach ($grouped as $waktu => $days) {
            [$buka, $tutup] = explode('-', $waktu);
            $labelHari = $this->rangeHari($days);
            if (empty($buka) || empty($tutup) || $buka === '-' || $tutup === '-') {
                $result[] = "$labelHari: Libur";
            } else {
                $result[] = "$labelHari: $buka-$tutup";
            }
        }
        return $result;
    }

    private function rangeHari($days)
    {
        $urutan = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $idx = array_flip($urutan);
        usort($days, fn($a, $b) => $idx[$a] <=> $idx[$b]);
        $ranges = [];
        $start = $end = $days[0];
        for ($i=1; $i<count($days); $i++) {
            if ($idx[$days[$i]] == $idx[$end]+1) {
                $end = $days[$i];
            } else {
                $ranges[] = $start == $end ? $start : "$start-$end";
                $start = $end = $days[$i];
            }
        }
        $ranges[] = $start == $end ? $start : "$start-$end";
        return implode(', ', $ranges);
    }

    public function render()
    {
        $pengumuman = Pengumuman::aktif()->terbaru()->limit(3)->get();
        $leaderboard = $this->getLeaderboardData();
        $totalHariIni = RiwayatKunjungan::hariIni()->count();
        $peraturan = Peraturan::where('aktif', true)->orderBy('id')->get();

        return view('livewire.kunjungan-kios', [
            'pengumuman' => $pengumuman,
            'leaderboard' => $leaderboard,
            'totalHariIni' => $totalHariIni,
            'peraturan' => $peraturan,
            'jamOperasional' => $this->getJamOperasionalFormatted(),
        ]);
    }
}
