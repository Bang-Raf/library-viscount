<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
        // Authorization check - only administrators can modify operational hours
        if (!auth()->check() || auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat mengubah jam operasional!');
            return;
        }

        try {
            // Validate and sanitize all time inputs
            $validatedTimes = $this->validateAndSanitizeTimeInputs();
            
            if (!$validatedTimes) {
                return; // Validation errors already set in session
            }

            // Save the validated operational hours
            Setting::setJamOperasional($validatedTimes);
            
            // Log the change for audit purposes
            Log::info('Operational hours updated', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'new_hours' => $validatedTimes
            ]);
            
            session()->flash('success', 'Jam operasional berhasil disimpan!');
            
        } catch (\Exception $e) {
            Log::error('Failed to save operational hours', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'input_data' => $this->jam
            ]);
            
            session()->flash('error', 'Gagal menyimpan jam operasional. Silakan coba lagi.');
        }
    }

    /**
     * Validate and sanitize time inputs
     */
    private function validateAndSanitizeTimeInputs()
    {
        $validatedTimes = [];
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        $dayNames = [
            'senin' => 'Senin',
            'selasa' => 'Selasa', 
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu'
        ];

        foreach ($days as $day) {
            $buka = trim($this->jam[$day]['buka'] ?? '');
            $tutup = trim($this->jam[$day]['tutup'] ?? '');

            // Skip validation if both times are empty (closed day)
            if (empty($buka) && empty($tutup)) {
                $validatedTimes[$day] = ['buka' => '', 'tutup' => ''];
                continue;
            }

            // Both opening and closing time must be provided if one is provided
            if (empty($buka) || empty($tutup)) {
                session()->flash('error', "Hari {$dayNames[$day]}: Jika perpustakaan buka, jam buka dan tutup harus diisi.");
                return false;
            }

            // Validate time format (HH:MM)
            if (!$this->isValidTimeFormat($buka)) {
                session()->flash('error', "Hari {$dayNames[$day]}: Format jam buka tidak valid. Gunakan format HH:MM (contoh: 08:00)");
                return false;
            }

            if (!$this->isValidTimeFormat($tutup)) {
                session()->flash('error', "Hari {$dayNames[$day]}: Format jam tutup tidak valid. Gunakan format HH:MM (contoh: 17:00)");
                return false;
            }

            // Validate business logic: opening time must be before closing time
            if (!$this->isOpeningBeforeClosing($buka, $tutup)) {
                session()->flash('error', "Hari {$dayNames[$day]}: Jam buka harus lebih awal dari jam tutup.");
                return false;
            }

            // Validate reasonable operating hours (not more than 18 hours)
            if (!$this->isReasonableOperatingHours($buka, $tutup)) {
                session()->flash('error', "Hari {$dayNames[$day]}: Jam operasional tidak boleh lebih dari 18 jam per hari.");
                return false;
            }

            $validatedTimes[$day] = [
                'buka' => $buka,
                'tutup' => $tutup
            ];
        }

        return $validatedTimes;
    }

    /**
     * Validate time format (HH:MM)
     */
    private function isValidTimeFormat($time)
    {
        // Check basic format with regex
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time)) {
            return false;
        }

        // Additional validation using Carbon to ensure it's a valid time
        try {
            Carbon::createFromFormat('H:i', $time);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate that opening time is before closing time
     */
    private function isOpeningBeforeClosing($buka, $tutup)
    {
        try {
            $openTime = Carbon::createFromFormat('H:i', $buka);
            $closeTime = Carbon::createFromFormat('H:i', $tutup);
            
            // Handle overnight operations (e.g., 22:00 to 06:00)
            if ($closeTime->lessThan($openTime)) {
                $closeTime->addDay();
            }
            
            return $openTime->lessThan($closeTime);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate reasonable operating hours (max 18 hours per day)
     */
    private function isReasonableOperatingHours($buka, $tutup)
    {
        try {
            $openTime = Carbon::createFromFormat('H:i', $buka);
            $closeTime = Carbon::createFromFormat('H:i', $tutup);
            
            // Handle overnight operations
            if ($closeTime->lessThan($openTime)) {
                $closeTime->addDay();
            }
            
            $diffInHours = $openTime->diffInHours($closeTime);
            return $diffInHours <= 18;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function render()
    {
        return view('livewire.manajemen-jam-operasional');
    }
} 