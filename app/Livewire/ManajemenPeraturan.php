<?php

namespace App\Livewire;

use App\Models\Peraturan;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenPeraturan extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showForm = false;
    public $editMode = false;
    public $peraturanId;

    // Form fields
    public $judul = '';
    public $isi = '';
    public $aktif = true;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
        'aktif' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function tambahPeraturan()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function editPeraturan($id)
    {
        $peraturan = Peraturan::findOrFail($id);
        $this->peraturanId = $id;
        $this->judul = $peraturan->judul;
        $this->isi = $peraturan->isi;
        $this->aktif = $peraturan->aktif;
        $this->showForm = true;
        $this->editMode = true;
    }

    public function simpan()
    {
        $this->validate();

        if ($this->editMode) {
            $peraturan = Peraturan::findOrFail($this->peraturanId);
            $peraturan->update([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'aktif' => $this->aktif,
            ]);
            session()->flash('message', 'Peraturan berhasil diupdate!');
        } else {
            Peraturan::create([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'aktif' => $this->aktif,
            ]);
            session()->flash('message', 'Peraturan baru berhasil ditambahkan!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function hapus($id)
    {
        $peraturan = Peraturan::findOrFail($id);
        $peraturan->delete();
        session()->flash('message', 'Peraturan berhasil dihapus!');
    }

    public function toggleAktif($id)
    {
        $peraturan = Peraturan::findOrFail($id);
        $peraturan->aktif = !$peraturan->aktif;
        $peraturan->save();
    }

    public function batalForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->peraturanId = null;
        $this->judul = '';
        $this->isi = '';
        $this->aktif = true;
        $this->editMode = false;
    }

    public function render()
    {
        $query = Peraturan::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('isi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== '') {
            $query->where('aktif', (int)$this->statusFilter);
        }

        $peraturan = $query->orderBy('judul')->paginate(10);

        $totalPeraturan = Peraturan::count();
        $totalPeraturanAktif = Peraturan::where('aktif', true)->count();

        return view('livewire.manajemen-peraturan', [
            'peraturan' => $peraturan,
            'totalPeraturan' => $totalPeraturan,
            'totalPeraturanAktif' => $totalPeraturanAktif,
        ]);
    }
} 