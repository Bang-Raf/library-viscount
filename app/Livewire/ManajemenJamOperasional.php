<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class ManajemenJamOperasional extends Component
{
    public $jam = [
        'senin' => ['buka' => '', 'tutup' => ''],
        'selasa' => ['buka' => '', 'tutup' => ''],
        'rabu' => ['buka' => '', 'tutup' => ''],
        'kamis' => ['buka' => '', 'tutup' => ''],
        'jumat' => ['buka' => '', 'tutup' => ''],
        'sabtu' => ['buka' => '', 'tutup' => ''],
        'minggu' => ['buka' => '', 'tutup' => ''],
    ];

    public function mount()
    {
        $data = Setting::getJamOperasional();
        if ($data) $this->jam = array_merge($this->jam, $data);
    }

    public function simpan()
    {
        Setting::setJamOperasional($this->jam);
        session()->flash('success', 'Jam operasional berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.manajemen-jam-operasional');
    }
} 