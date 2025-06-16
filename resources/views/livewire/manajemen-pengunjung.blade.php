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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-blue-100/60 backdrop-blur-md' : 'bg-blue-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengunjung</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPengunjung }}</p>
                </div>
            </div>
        </div>

        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-green-500">
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
                    <p class="text-sm font-medium text-gray-600">Pengunjung Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pengunjungAktif }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }}">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Pengunjung</h3>
                    <p class="text-sm text-gray-600">Kelola data pengunjung perpustakaan</p>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="tambahPengunjung"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Pengunjung
                    </button>
                    <button wire:click="importBatchPengunjung"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v16h16M4 4l16 16"></path>
                        </svg>
                        Import Batch
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input wire:model.live="search" type="text"
                        placeholder="Cari berdasarkan ID Pengunjung, nama, atau kelas..."
                        class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Pindah">Pindah</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                            Pengunjung
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas/Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengunjung as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->id_pengunjung }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->kelas_jabatan ?: '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $item->status === 'Aktif'
                                        ? 'bg-green-100 text-green-800'
                                        : ($item->status === 'Lulus'
                                            ? 'bg-blue-100 text-blue-800'
                                            : ($item->status === 'Pindah'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800')) }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button wire:click="editPengunjung({{ $item->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button wire:click="hapus({{ $item->id }})"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
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
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data pengunjung
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pengunjung->links() }}
        </div>
        @push('styles')
            <style>
                .pagination {
                    @apply flex items-center justify-center space-x-1 mt-2;
                }

                .pagination .page-link {
                    @apply px-3 py-1 rounded-lg border text-sm font-semibold transition duration-150;
                }

                .pagination .page-item.active .page-link {
                    @apply bg-blue-600 text-white border-blue-600;
                }

                .pagination .page-link:hover {
                    @apply bg-blue-50 text-blue-700 border-blue-400;
                }

                .pagination .page-item.disabled .page-link {
                    @apply bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed;
                }

                /* Kustom warna tombol prev/next */
                .pagination .page-item:first-child .page-link {
                    @apply bg-green-600 text-white border-green-600;
                }

                .pagination .page-item:last-child .page-link {
                    @apply bg-orange-500 text-white border-orange-500;
                }
            </style>
        @endpush
    </div>

    <!-- Modal Form -->
    @if ($showForm)
        <div
            class="fixed inset-0
                {{ $activeTheme === 'glass'
                    ? 'bg-white/40 backdrop-blur-sm'
                    : ($activeTheme === 'minimal'
                        ? 'bg-white/40 backdrop-blur-sm'
                        : 'bg-gray-600 bg-opacity-50') }}
                overflow-y-auto h-full w-full z-50">
            <div
                class="relative top-20 mx-auto p-5 w-full max-w-lg shadow-lg rounded-md
                    {{ $activeTheme === 'glass'
                        ? 'glass-card'
                        : ($activeTheme === 'minimal'
                            ? 'bg-white/90 border border-gray-200/60'
                            : 'bg-white border') }}">
                <div class="mt-3">
                    <h3
                        class="text-lg font-bold mb-4 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-900' }}">
                        {{ $editMode ? 'Edit Pengunjung' : 'Tambah Pengunjung' }}
                    </h3>

                    <form wire:submit.prevent="simpan" class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">ID
                                Pengunjung *</label>
                            <input wire:model="id_pengunjung" type="text"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Nomor Induk Siswa/Santri">
                            @error('id_pengunjung')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Nama
                                Lengkap *</label>
                            <input wire:model="nama_lengkap" type="text"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Nama lengkap pengunjung">
                            @error('nama_lengkap')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Kelas/Jabatan</label>
                            <input wire:model="kelas_jabatan" type="text"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Kelas untuk siswa atau jabatan untuk guru/staf">
                            @error('kelas_jabatan')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Status
                                *</label>
                            <select wire:model="status"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                                <option value="Aktif">Aktif</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Pindah">Pindah</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex space-x-3 pt-4">
                            <button type="button" wire:click="batalForm"
                                class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-lg transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                {{ $editMode ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($showImportBatchModal)
        <div
            class="fixed inset-0
                {{ $activeTheme === 'glass'
                    ? 'bg-white/40 backdrop-blur-sm'
                    : ($activeTheme === 'minimal'
                        ? 'bg-white/40 backdrop-blur-sm'
                        : 'bg-gray-600 bg-opacity-50') }}
                overflow-y-auto h-full w-full z-50">
            <div
                class="relative top-20 mx-auto p-5 w-full max-w-lg shadow-lg rounded-md
                    {{ $activeTheme === 'glass'
                        ? 'glass-card'
                        : ($activeTheme === 'minimal'
                            ? 'bg-white/90 border border-gray-200/60'
                            : 'bg-white border') }}">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-900' }}">
                        Import Pengunjung (Batch)</h3>
                </div>
                <form wire:submit.prevent="import" class="space-y-4">
                    <div>
                        <label
                            class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">File
                            Excel/CSV *</label>
                        <input type="file" wire:model="file" accept=".xls,.xlsx,.csv"
                            class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}">
                        @error('file')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex space-x-3 pt-4">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-lg transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                            Import
                        </button>
                    </div>
                </form>
                @if ($importedCount > 0 || count($failedRows) > 0)
                    <div class="mt-4">
                        <div class="mb-2 text-green-700" v-if="$importedCount > 0">
                            <strong>{{ $importedCount }}</strong> data berhasil diimport.
                        </div>
                        @if (count($failedRows) > 0)
                            <div class="mb-2 text-red-700">
                                <strong>{{ count($failedRows) }}</strong> baris gagal diimport:
                                <ul class="list-disc ml-5 text-xs">
                                    @foreach ($failedRows as $fail)
                                        <li>Baris {{ $fail['row'] }}: {{ implode(', ', $fail['errors']) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="mt-4 text-xs text-gray-500">
                    <b>Format kolom:</b> ID Pengunjung, Nama Lengkap, Kelas/Jabatan, Status
                    (Aktif/Lulus/Pindah/Nonaktif)<br>
                    Baris pertama bisa header atau langsung data.
                </div>
            </div>
        </div>
    @endif
</div>
