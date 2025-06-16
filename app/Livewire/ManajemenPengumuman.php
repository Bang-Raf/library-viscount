<?php

namespace App\Livewire;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenPengumuman extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showForm = false;
    public $editMode = false;
    public $pengumumanId;

    // Form fields
    public $judul = '';
    public $isi = '';
    public $aktif = true;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
        'aktif' => 'boolean',
    ];

    protected $messages = [
        'judul.required' => 'Judul pengumuman wajib diisi',
        'isi.required' => 'Isi pengumuman wajib diisi',
        'status.required' => 'Status wajib dipilih'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function tambahPengumuman()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function editPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $this->pengumumanId = $id;
        $this->judul = $pengumuman->judul;
        $this->isi = $pengumuman->isi;
        $this->aktif = $pengumuman->aktif;
        $this->showForm = true;
        $this->editMode = true;
    }

    public function simpan()
    {
        $this->validate();

        if ($this->editMode) {
            $pengumuman = Pengumuman::findOrFail($this->pengumumanId);
            $pengumuman->update([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'aktif' => $this->aktif,
            ]);
            
            session()->flash('message', 'Pengumuman berhasil diupdate!');
        } else {
            Pengumuman::create([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'aktif' => $this->aktif,
            ]);
            
            session()->flash('message', 'Pengumuman baru berhasil ditambahkan!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function toggleStatus($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'aktif' => !$pengumuman->aktif
        ]);
        session()->flash('message', 'Status pengumuman berhasil diubah!');
    }

    public function hapus($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        session()->flash('message', 'Pengumuman berhasil dihapus!');
    }

    public function batalForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->pengumumanId = null;
        $this->judul = '';
        $this->isi = '';
        $this->aktif = true;
        $this->editMode = false;
    }

    public function render()
    {
        $query = Pengumuman::query();

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('isi', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter !== '') {
            $query->where('aktif', (bool)$this->statusFilter);
        }

        $pengumuman = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.manajemen-pengumuman', [
            'pengumuman' => $pengumuman,
            'totalPengumuman' => Pengumuman::count(),
            'pengumumanAktif' => Pengumuman::where('aktif', true)->count(),
        ]);
    }
}
