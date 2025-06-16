@php
    $activeTheme =
        $activeTheme ??
        (function_exists('theme_active') ? theme_active() : \App\Helpers\ThemeHelper::getActiveTheme() ?? 'glass');
@endphp
<div
    class="min-h-screen {{ $activeTheme === 'glass' ? 'kios-glass-bg' : 'bg-gradient-to-br from-blue-50 to-indigo-100' }} flex flex-col">
    <!-- Header -->
    <div class="{{ $activeTheme === 'glass' ? 'kios-glass-header' : 'bg-blue-50/80 shadow-sm' }}">
        <div class="container mx-auto px-4 py-6">
            <div class="text-center">
                <div class="flex items-center justify-between w-full max-w-4xl mx-auto">
                    <div class="flex-1 text-center">
                        <h1
                            class="text-3xl font-bold {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-blue-700' }}">
                            Lib-In MBS</h1>
                        <p class="text-lg {{ $activeTheme === 'glass' ? 'text-blue-700' : 'text-blue-600' }} mt-2">Sistem
                            Informasi Kunjungan Perpustakaan MBS Pleret</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        @auth
                            <div class="flex items-center space-x-3">
                                <span class="text-sm text-blue-700">
                                    Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>
                                </span>
                                <a href="{{ route('dashboard.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 5a2 2 0 012-2h4a2 2 0 012 2v0M8 5a2 2 0 012-2h4a2 2 0 012 2v0">
                                        </path>
                                    </svg>
                                    Dashboard
                                </a>
                            </div>
                        @else
                            <a href="{{ route('dashboard.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Masuk Dashboard
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Form Pencatatan Kunjungan -->
            <div class="lg:col-span-2">
                <div
                    class="{{ $activeTheme === 'glass' ? 'calendar-glass-card' : 'bg-white border border-gray-200 shadow-lg rounded-xl' }} p-8">
                    <div class="text-center mb-8">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Pencatatan Kunjungan</h2>
                        <p class="text-gray-600 mt-2">Masukkan ID Pengunjung Anda untuk mencatat kunjungan ke
                            perpustakaan</p>
                    </div>

                    <!-- Messages -->
                    @if ($message)
                        <div
                            class="mb-6 p-4 rounded-lg border-l-4 {{ $messageType === 'success' ? 'bg-green-100 border-green-500 text-green-700' : ($messageType === 'info' ? 'bg-blue-100 border-blue-500 text-blue-700' : 'bg-red-100 border-red-500 text-red-700') }}">
                            <div class="flex items-start">
                                @if ($messageType === 'success')
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @elseif ($messageType === 'info')
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                                <span class="text-sm leading-relaxed">{{ $message }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Form Input ID Pengunjung -->
                    @if (!$showWelcome)
                        <form wire:submit.prevent="cariPengunjung" class="space-y-6">
                            <div>
                                <label for="id_pengunjung" class="block text-sm font-medium text-gray-700 mb-2">
                                    ID Pengunjung
                                </label>
                                <input autofocus wire:model.live="id_pengunjung" type="text" id="id_pengunjung"
                                    class="w-full px-4 py-3 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 text-center {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'border border-gray-300 text-gray-900' }}"
                                    placeholder="Masukkan ID Pengunjung Anda" autocomplete="off">
                                @error('id_pengunjung')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-lg"
                                {{ !$id_pengunjung ? 'disabled' : '' }}>
                                Cari Pengunjung
                            </button>
                        </form>
                    @endif

                    <!-- Form Keperluan Kunjungan -->
                    @if ($showWelcome && $pengunjung)
                        <div class="text-center mb-6">
                            <div
                                class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Selamat Datang!</h3>
                            <p class="text-lg text-gray-600 mt-1">{{ $pengunjung->nama_lengkap }}</p>
                            <p class="text-sm text-gray-500">{{ $pengunjung->kelas_jabatan }}</p>
                        </div>

                        <form wire:submit.prevent="simpanKunjungan" class="space-y-6">
                            <div>
                                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keperluan Kunjungan
                                </label>
                                <select wire:model="keperluan" id="keperluan"
                                    class="w-full px-4 py-3 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'border border-gray-300 text-gray-900' }}">
                                    <option value="Membaca">Membaca</option>
                                    <option value="Pinjam Buku">Pinjam Buku</option>
                                    <option value="Kembali Buku">Kembali Buku</option>
                                    <option value="Mengerjakan Tugas">Mengerjakan Tugas</option>
                                    <option value="Diskusi">Diskusi</option>
                                    <option value="Penelitian">Penelitian</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" wire:click="resetForm"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                    Catat Kunjungan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                <!-- Card Peraturan Perpustakaan (tepat di bawah form input) -->
                <div
                    class="{{ $activeTheme === 'glass' ? 'calendar-glass-card kios-glass-peraturan p-6' : 'bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-xl shadow' }} mt-8">
                    <h3
                        class="text-lg font-semibold mb-2 {{ $activeTheme === 'glass' ? 'kios-peraturan-title' : 'text-yellow-800' }}">
                        Peraturan Perpustakaan</h3>
                    @php
                        $grouped = $peraturan->groupBy('judul');
                    @endphp
                    @foreach ($grouped as $judul => $items)
                        <div class="mb-4">
                            <div
                                class="font-bold mb-1 {{ $activeTheme === 'glass' ? 'kios-peraturan-title' : 'text-yellow-900' }}">
                                {{ $judul }}</div>
                            <ul
                                class="list-disc ml-6 text-sm {{ $activeTheme === 'glass' ? 'kios-peraturan-list' : 'text-yellow-900' }}">
                                @foreach ($items as $rule)
                                    <li class="mb-1">{{ $rule->isi }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Widget Jam -->
                <x-rtc-clock style="{{ $activeTheme === 'glass' ? 'glass' : 'minimal' }}" />

                <!-- Statistik Hari Ini -->
                <div
                    class="{{ $activeTheme === 'glass' ? 'calendar-glass-card' : 'bg-white border border-gray-200 shadow-lg rounded-xl' }} p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Hari Ini</h3>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $totalHariIni }}</div>
                        <div class="text-sm text-gray-600">Total Kunjungan</div>
                    </div>
                </div>

                <!-- Widget Kalender -->
                <x-calendar-widget style="{{ $activeTheme === 'glass' ? 'glass' : 'minimal' }}" />

                <!-- Leaderboard -->
                <div
                    class="{{ $activeTheme === 'glass' ? 'calendar-glass-card' : 'bg-white border border-gray-200 shadow-lg rounded-xl' }} p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pengunjung Terdepan</h3>
                        <select wire:model.live="leaderboardPeriod"
                            class="text-sm border border-gray-300 rounded px-2 py-1">
                            <option value="bulan">Bulan Ini</option>
                            <option value="semester">Semester Ini</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        @forelse($leaderboard as $index => $item)
                            <div
                                class="flex items-center space-x-3 p-2 rounded-lg {{ $index < 3 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }}">
                                <div class="flex-shrink-0">
                                    @if ($index === 0)
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-yellow-800 bg-yellow-300 rounded-full">1</span>
                                    @elseif($index === 1)
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-gray-800 bg-gray-300 rounded-full">2</span>
                                    @elseif($index === 2)
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-orange-800 bg-orange-300 rounded-full">3</span>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-gray-600 bg-gray-200 rounded-full">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->pengunjung->nama_lengkap ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->pengunjung->kelas_jabatan ?? '' }}</p>
                                </div>
                                <div class="text-sm font-semibold text-blue-600">
                                    {{ $item->total_kunjungan }}x
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 text-sm">Belum ada data kunjungan</p>
                        @endforelse
                    </div>
                </div>

                <!-- Informasi Perpustakaan -->
                <div
                    class="{{ $activeTheme === 'glass' ? 'calendar-glass-card' : 'bg-white border border-gray-200 shadow-lg rounded-xl' }} p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Perpustakaan</h3>

                    <!-- Jam Operasional -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Jam Operasional</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div>Senin - Kamis: 07:00 - 16:00</div>
                            <div>Jumat: 07:00 - 11:00</div>
                            <div>Sabtu: 07:00 - 14:00</div>
                        </div>
                    </div>

                    <!-- Pengumuman -->
                    @if ($pengumuman->count() > 0)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Pengumuman</h4>
                            <div class="space-y-2">
                                @foreach ($pengumuman as $announcement)
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                                        <h5 class="text-sm font-medium text-blue-800">{{ $announcement->judul }}</h5>
                                        <p class="text-xs text-blue-600 mt-1">
                                            {{ $announcement->isi }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-reset script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('auto-reset', function() {
                setTimeout(() => {
                    @this.call('clearMessage');
                }, 3000);
            });
        });
    </script>
</div>
