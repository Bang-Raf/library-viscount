<?php

namespace App\Livewire;

use App\Models\Pengunjung;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // Ensure only administrators can delete visitor records
        if (!auth()->check() || auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat menghapus data pengunjung!');
            return;
        }

        try {
            $pengunjung = Pengunjung::findOrFail($id);
            
            // Check if visitor has any visit history
            $visitCount = $pengunjung->riwayatKunjungan()->count();
            if ($visitCount > 0) {
                session()->flash('error', 'Tidak dapat menghapus pengunjung yang memiliki riwayat kunjungan. Total kunjungan: ' . $visitCount);
                return;
            }
            
            $pengunjung->delete();
            session()->flash('message', 'Data pengunjung berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to delete visitor', [
                'visitor_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Gagal menghapus data pengunjung. Silakan coba lagi.');
        }
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
        // Ensure only administrators can import data
        if (!auth()->check() || auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat melakukan import data!');
            return;
        }

        $this->validate($this->importRules);
        $this->importedCount = 0;
        $this->failedRows = [];

        $path = $this->file->store('temp');
        
        try {
            // Security: Verify file size and content before processing
            $fileSize = Storage::size($path);
            if ($fileSize > 5 * 1024 * 1024) { // 5MB limit
                throw new \Exception('File terlalu besar. Maksimal 5MB.');
            }

            $rows = Excel::toCollection(null, storage_path('app/' . $path))->first();

            if (!$rows || $rows->count() === 0) {
                throw new \Exception('File tidak dapat dibaca atau kosong.');
            }

            // Security: Limit number of rows to prevent memory exhaustion
            if ($rows->count() > 1000) {
                throw new \Exception('File terlalu besar. Maksimal 1000 baris data.');
            }

            // Use database transaction for data consistency
            DB::transaction(function () use ($rows) {
                foreach ($rows as $index => $row) {
                    // Skip header row
                    if ($index === 0 && (strtolower($row[0]) === 'id_pengunjung' || strtolower($row['id_pengunjung'] ?? '') === 'id_pengunjung')) {
                        continue;
                    }
                    
                    // Skip empty rows
                    $id_pengunjung = trim($row['id_pengunjung'] ?? $row[0] ?? '');
                    $nama_lengkap = trim($row['nama_lengkap'] ?? $row[1] ?? '');
                    $kelas_jabatan = trim($row['kelas_jabatan'] ?? $row[2] ?? '');
                    $status = trim($row['status'] ?? $row[3] ?? 'Aktif');
                    
                    if (empty($id_pengunjung) && empty($nama_lengkap)) {
                        continue;
                    }
                    
                    // Security: Sanitize and validate input data
                    $data = [
                        'id_pengunjung' => substr($id_pengunjung, 0, 255), // Limit length
                        'nama_lengkap' => substr($nama_lengkap, 0, 255),
                        'kelas_jabatan' => $kelas_jabatan ? substr($kelas_jabatan, 0, 255) : null,
                        'status' => in_array($status, ['Aktif', 'Lulus', 'Pindah', 'Nonaktif']) ? $status : 'Aktif',
                    ];
                    
                    $validator = Validator::make($data, [
                        'id_pengunjung' => 'required|string|max:255|unique:pengunjung,id_pengunjung',
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
            });
            
        } catch (\Exception $e) {
            Log::error('Import failed', [
                'user_id' => auth()->id(),
                'file_path' => $path,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Import gagal: ' . $e->getMessage());
        } finally {
            // Always clean up temporary file
            Storage::delete($path);
        }
        
        $this->showImportBatchModal = false;
        
        if ($this->importedCount > 0 || count($this->failedRows) > 0) {
            session()->flash('message', "Import selesai. Berhasil: {$this->importedCount}, Gagal: " . count($this->failedRows));
        }
        
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
