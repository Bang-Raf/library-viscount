<div>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @php
        $activeTheme =
            $activeTheme ??
            (function_exists('theme_active') ? theme_active() : \App\Helpers\ThemeHelper::getActiveTheme() ?? 'glass');
    @endphp

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="card p-6 border-l-4 border-blue-500 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-blue-100/60 backdrop-blur-md' : 'bg-blue-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKunjungan }}</p>
                    <p class="text-xs text-gray-500">Berdasarkan Filter</p>
                </div>
            </div>
        </div>

        <div
            class="card p-6 border-l-4 border-green-500 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-green-100/60 backdrop-blur-md' : 'bg-green-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kunjungan Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $kunjunganHariIni }}</p>
                    <p class="text-xs text-gray-500">{{ now()->setTimezone('Asia/Jakarta')->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div
            class="card p-6 border-l-4 border-purple-500 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-purple-100/60 backdrop-blur-md' : 'bg-purple-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pengunjung Unik</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pengunjungUnik }}</p>
                    <p class="text-xs text-gray-500">Berdasarkan Filter</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Kunjungan</h3>
                    <p class="text-sm text-gray-600">Data kunjungan perpustakaan</p>
                </div>

                <!-- Quick Filter Buttons -->
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
                    <button wire:click="resetFilter"
                        class="px-3 py-1 text-xs bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full transition duration-200">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input wire:model.live="search" type="text"
                        placeholder="Cari berdasarkan ID Pengunjung atau nama..."
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                    <select wire:model.live="keperluanFilter"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                        <option value="">Semua Keperluan</option>
                        @foreach ($daftarKeperluan as $keperluan)
                            <option value="{{ $keperluan }}">{{ $keperluan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input wire:model.live="tanggalMulai" type="date"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                    <input wire:model.live="tanggalSelesai" type="date"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu
                            Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                            Pengunjung
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas/Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kunjungan as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ($kunjungan->currentPage() - 1) * $kunjungan->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>
                                    <div class="font-medium">
                                        {{ $item->waktu_masuk->setTimezone('Asia/Jakarta')->format('d/m/Y') }}</div>
                                    <div class="text-gray-500">
                                        {{ $item->waktu_masuk->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->pengunjung->id_pengunjung ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->pengunjung->nama_lengkap ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->pengunjung->kelas_jabatan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->keperluan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="hapusKunjungan({{ $item->id }})"
                                    onclick="return confirm('Yakin ingin menghapus data kunjungan ini?')"
                                    class="text-red-600 hover:text-red-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data kunjungan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $kunjungan->links() }}
        </div>
    </div>
</div>
