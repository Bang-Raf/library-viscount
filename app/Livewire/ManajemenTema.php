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
        
        // Sanitize and validate the preview parameter to prevent injection
        $previewTheme = request()->query('preview');
        if ($previewTheme) {
            // Validate that the preview theme exists in the themes table
            $validTheme = DB::table('themes')->where('name', $previewTheme)->exists();
            $this->selectedTheme = $validTheme ? $previewTheme : $this->activeTheme;
        } else {
            $this->selectedTheme = $this->activeTheme;
        }
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
            'selectedTheme' => 'required|string|exists:themes,name',
        ]);
        
        try {
            // Use a transaction for data consistency
            DB::transaction(function () {
                DB::table('settings')->updateOrInsert(
                    ['key' => 'theme_global'],
                    ['value' => $this->selectedTheme, 'updated_at' => now()]
                );
            });
            
            $this->activeTheme = $this->selectedTheme;
            session()->flash('success', 'Tema berhasil diterapkan!');
            return redirect()->route('dashboard.theme');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menerapkan tema. Silakan coba lagi.');
            \Log::error('Theme update failed: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
