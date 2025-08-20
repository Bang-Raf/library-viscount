<div>
    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Laporan & Rekapitulasi</h2>
        <p class="text-gray-600">Export data kunjungan dan pengunjung perpustakaan</p>
    </div>

    <!-- Export Configuration -->
    @php
        $activeTheme =
            $activeTheme ??
            (function_exists('theme_active') ? theme_active() : \App\Helpers\ThemeHelper::getActiveTheme() ?? 'glass');
    @endphp
    <div
        class="card p-6 mb-8 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfigurasi Export</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Laporan</label>
                    <select wire:model="jenisLaporan"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                        <option value="kunjungan">Laporan Kunjungan</option>
                        <option value="pengunjung">Laporan Pengunjung</option>
                    </select>
                </div>

                @if ($jenisLaporan === 'kunjungan')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Keperluan</label>
                        <select wire:model="keperluanFilter"
                            class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                            <option value="">Semua Keperluan</option>
                            @foreach ($daftarKeperluan as $keperluan)
                                <option value="{{ $keperluan }}">{{ $keperluan }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Format Export</label>
                    <select wire:model="formatExport"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                        <option value="csv">CSV (.csv)</option>
                        <option value="excel" disabled>Excel (.xlsx) - Coming Soon</option>
                    </select>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                @if ($jenisLaporan === 'kunjungan')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input wire:model="tanggalMulai" type="date"
                            class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input wire:model="tanggalSelesai" type="date"
                            class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                    </div>

                    <!-- Quick Filter Buttons -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Cepat</label>
                        <div class="flex space-x-2">
                            <button wire:click="filterHariIni"
                                class="px-3 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-full transition duration-200">
                                Hari Ini
                            </button>
                            <button wire:click="filterMingguIni"
                                class="px-3 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-800 rounded-full transition duration-200">
                                Minggu Ini
                            </button>
                            <button wire:click="filterBulanIni"
                                class="px-3 py-1 text-xs bg-purple-100 hover:bg-purple-200 text-purple-800 rounded-full transition duration-200">
                                Bulan Ini
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Export Button -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <button wire:click="exportData"
                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export {{ ucfirst($jenisLaporan) }}
            </button>
        </div>
    </div>

    <!-- Preview Statistics -->
    @if ($jenisLaporan === 'kunjungan' && !empty($statistik))
        <div
            class="card p-6 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview Statistik</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="rounded-lg p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-blue-50 border border-blue-100' }}">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-blue-100/60 backdrop-blur-md' : 'bg-blue-100' }} rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $statistik['total_kunjungan'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-lg p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-green-50 border border-green-100' }}">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-green-100/60 backdrop-blur-md' : 'bg-green-100' }} rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Pengunjung Unik</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $statistik['pengunjung_unik'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-lg p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-purple-50 border border-purple-100' }}">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-purple-100/60 backdrop-blur-md' : 'bg-purple-100' }} rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Rata-rata Harian</p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ number_format($statistik['rata_harian'] ?? 0, 1) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-gray-50 rounded-lg' }}">
                <p class="text-sm text-gray-600">
                    <strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
                    @if ($keperluanFilter)
                        <br><strong>Keperluan:</strong> {{ $keperluanFilter }}
                    @endif
                </p>
            </div>
        </div>
    @endif

    @if ($jenisLaporan === 'pengunjung')
        <div
            class="card p-6 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Laporan Pengunjung</h3>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Laporan pengunjung akan mengexport semua data pengunjung yang terdaftar beserta statistik
                            kunjungan mereka.
                            Data mencakup total kunjungan dan waktu kunjungan terakhir untuk setiap pengunjung.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
