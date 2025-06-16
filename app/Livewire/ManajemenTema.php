<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ManajemenTema extends Component
{
    public $selectedTheme = 'minimal';
    public $activeTheme = 'minimal';
    

    public function mount()
    {
        $this->activeTheme = DB::table('settings')->where('key', 'theme_global')->value('value') ?: 'minimal';
        $this->selectedTheme = request()->query('preview') ?: $this->activeTheme;
    }

    public function render()
    {
        $themes = DB::table('themes')->get();
        return view('livewire.manajemen-tema', [
            'themes' => $themes,
            'activeTheme' => $this->activeTheme,
            'selectedTheme' => $this->selectedTheme,
        ]);
    }

    public function edit()
    {
        $themes = DB::table('themes')->get();
        $active = DB::table('settings')->where('key', 'theme_global')->value('value') ?: 'minimal';
        return view('dashboard.theme', compact('themes', 'active'));
    }

    public function updateTheme()
    {
        $this->validate([
            'selectedTheme' => 'required|exists:themes,name',
        ]);
        DB::table('settings')->updateOrInsert(
            ['key' => 'theme_global'],
            ['value' => $this->selectedTheme]
        );
        $this->activeTheme = $this->selectedTheme;
        session()->flash('success', 'Tema berhasil diubah!');
    }
}
