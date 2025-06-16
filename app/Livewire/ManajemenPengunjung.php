<?php

namespace App\Livewire;

use App\Models\Pengunjung;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ManajemenPengunjung extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $statusFilter = '';
    public $showForm = false;
    public $editMode = false;
    public $pengunjungId;
    public $showImportBatchModal = false;

    // Form fields
    public $id_pengunjung = '';
    public $nama_lengkap = '';
    public $kelas_jabatan = '';
    public $status = 'Aktif';

    // Import batch
    public $file;
    public $importedCount = 0;
    public $failedRows = [];

    protected $rules = [
        'id_pengunjung' => 'required|string|unique:pengunjung,id_pengunjung',
        'nama_lengkap' => 'required|string|max:255',
        'kelas_jabatan' => 'nullable|string|max:255',
        'status' => 'required|in:Aktif,Lulus,Pindah,Nonaktif'
    ];

    protected $messages = [
        'id_pengunjung.required' => 'ID Pengunjung wajib diisi',
        'id_pengunjung.unique' => 'ID Pengunjung sudah terdaftar',
        'nama_lengkap.required' => 'Nama lengkap wajib diisi',
        'status.required' => 'Status wajib dipilih'
    ];

    protected $importRules = [
        'file' => 'required|file|mimes:xls,xlsx,csv|max:2048',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function tambahPengunjung()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function editPengunjung($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        $this->pengunjungId = $id;
        $this->id_pengunjung = $pengunjung->id_pengunjung;
        $this->nama_lengkap = $pengunjung->nama_lengkap;
        $this->kelas_jabatan = $pengunjung->kelas_jabatan;
        $this->status = $pengunjung->status;
        
        $this->showForm = true;
        $this->editMode = true;
    }

    public function simpan()
    {
        if ($this->editMode) {
            $this->rules['id_pengunjung'] = 'required|string|unique:pengunjung,id_pengunjung,' . $this->pengunjungId;
        }

        $this->validate();

        if ($this->editMode) {
            $pengunjung = Pengunjung::findOrFail($this->pengunjungId);
            $pengunjung->update([
                'id_pengunjung' => $this->id_pengunjung,
                'nama_lengkap' => $this->nama_lengkap,
                'kelas_jabatan' => $this->kelas_jabatan,
                'status' => $this->status,
            ]);
            
            session()->flash('message', '1 Data pengunjung berhasil diupdate!');
        } else {
            Pengunjung::create([
                'id_pengunjung' => $this->id_pengunjung,
                'nama_lengkap' => $this->nama_lengkap,
                'kelas_jabatan' => $this->kelas_jabatan,
                'status' => $this->status,
            ]);
            
            session()->flash('message', '1 Pengunjung baru berhasil ditambahkan!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function hapus($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->delete();
        session()->flash('message', '1 Data pengunjung berhasil dihapus!');
    }

    public function batalForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->pengunjungId = null;
        $this->id_pengunjung = '';
        $this->nama_lengkap = '';
        $this->kelas_jabatan = '';
        $this->status = 'Aktif';
        $this->editMode = false;
    }

    public function render()
    {
        $query = Pengunjung::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('id_pengunjung', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('kelas_jabatan', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $pengunjung = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.manajemen-pengunjung', [
            'pengunjung' => $pengunjung,
            'totalPengunjung' => Pengunjung::count(),
            'pengunjungAktif' => Pengunjung::where('status', 'Aktif')->count(),
            'showImportBatchModal' => $this->showImportBatchModal,
        ]);
    }

    public function getListeners()
    {
        return [
            'openImportBatchModal' => 'openImportBatchModal',
        ];
    }

    public function openImportBatchModal()
    {
        $this->emitTo('import-pengunjung-batch', 'openModal');
    }

    public function importBatchPengunjung()
    {
        $this->showImportBatchModal = true;
    }

    public function import()
    {
        $this->validate($this->importRules);
        $this->importedCount = 0;
        $this->failedRows = [];

        $path = $this->file->store('temp');
        $rows = Excel::toCollection(null, storage_path('app/' . $path))->first();

        if (!$rows || $rows->count() === 0) {
            Storage::delete($path);
            session()->flash('message', 'File tidak dapat dibaca atau kosong. Pastikan format dan isi file sudah benar.');
            $this->resetImportForm();
            return;
        }

        foreach ($rows as $index => $row) {
            if ($index === 0 && (strtolower($row[0]) === 'id_pengunjung' || strtolower($row['id_pengunjung'] ?? '') === 'id_pengunjung')) {
                continue;
            }
            // Skip baris kosong
            $id_pengunjung = $row['id_pengunjung'] ?? $row[0] ?? null;
            $nama_lengkap = $row['nama_lengkap'] ?? $row[1] ?? null;
            $kelas_jabatan = $row['kelas_jabatan'] ?? $row[2] ?? null;
            $status = $row['status'] ?? $row[3] ?? 'Aktif';
            if (empty($id_pengunjung) && empty($nama_lengkap) && empty($kelas_jabatan) && empty($status)) {
                continue;
            }
            $data = [
                'id_pengunjung' => $id_pengunjung,
                'nama_lengkap' => $nama_lengkap,
                'kelas_jabatan' => $kelas_jabatan,
                'status' => $status,
            ];
            $validator = Validator::make($data, [
                'id_pengunjung' => 'required|string|unique:pengunjung,id_pengunjung',
                'nama_lengkap' => 'required|string|max:255',
                'kelas_jabatan' => 'nullable|string|max:255',
                'status' => 'required|in:Aktif,Lulus,Pindah,Nonaktif',
            ]);
            if ($validator->fails()) {
                $this->failedRows[] = [
                    'row' => $index + 1,
                    'data' => $data,
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }
            Pengunjung::create($data);
            $this->importedCount++;
        }
        Storage::delete($path);
        $this->showImportBatchModal = false;
        session()->flash('message', "Import selesai. Berhasil: {$this->importedCount}, Gagal: " . count($this->failedRows));
        $this->resetImportForm();
    }

    public function closeModal()
    {
        $this->showImportBatchModal = false;
        $this->resetImportForm();
    }

    private function resetImportForm()
    {
        $this->file = null;
        $this->importedCount = 0;
        $this->failedRows = [];
    }
}
