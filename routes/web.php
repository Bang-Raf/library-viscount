<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\ManajemenPeraturan;

// Halaman utama - Mode Kios
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Tentang Developer
Route::view('/tentang-developer', 'tentang-developer')->name('tentang-developer');

// Dashboard routes (akan dibuat auth middleware)
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard.index');
    
    Route::get('/pengunjung', function () {
        return view('dashboard.pengunjung');
    })->name('dashboard.pengunjung');
    
    Route::get('/kunjungan', function () {
        return view('dashboard.kunjungan');
    })->name('dashboard.kunjungan');
    
    Route::get('/laporan', function () {
        return view('dashboard.laporan');
    })->name('dashboard.laporan');
    
    Route::get('/pengumuman', function () {
        return view('dashboard.pengumuman');
    })->name('dashboard.pengumuman');
    
    // Route khusus administrator - Simplified
    Route::get('/users', function () {
        // Simple check without complex debugging
        if (!auth()->check() || auth()->user()->role !== 'administrator') {
            return redirect()->route('dashboard.index')->with('error', 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }
        
        return view('dashboard.users');
    })->name('dashboard.users');
    
    // Debug route - simple version
    Route::get('/debug-user', function () {
        $user = auth()->user();
        
        return [
            'logged_in' => auth()->check(),
            'user_id' => $user ? $user->id : null,
            'username' => $user ? $user->username : null,
            'role' => $user ? $user->role : null,
            'is_admin' => $user ? ($user->role === 'administrator') : false,
        ];
    });

    Route::get('/peraturan', function () {
        return view('dashboard.peraturan');
    })->name('dashboard.peraturan');

    Route::get('/theme', function () {
        return view('dashboard.theme');
    })->name('dashboard.theme');

    Route::get('/jam-operasional', function () {
        return view('dashboard.jam-operasional');
    })->name('dashboard.jam-operasional');
});

// Auth routes
require __DIR__.'/auth.php';

