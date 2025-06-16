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
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengumuman</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPengumuman }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Pengumuman Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pengumumanAktif }}</p>
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
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Pengumuman</h3>
                    <p class="text-sm text-gray-600">Kelola pengumuman perpustakaan</p>
                </div>
                <button wire:click="tambahPengumuman"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Pengumuman
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input wire:model.live="search" type="text"
                        placeholder="Cari berdasarkan judul atau isi pengumuman..."
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isi
                            Pengumuman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengumuman as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->judul }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ $item->isi }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->aktif)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-600">Nonaktif</span>
                                @endif
                                <button wire:click="toggleStatus({{ $item->id }})"
                                    class="ml-2 text-xs text-blue-600 hover:underline">Ubah</button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button wire:click="editPengumuman({{ $item->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button wire:click="hapus({{ $item->id }})"
                                    onclick="return confirm('Yakin ingin menghapus pengumuman ini?')"
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
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data pengumuman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pengumuman->links() }}
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
                            : 'bg-white') }}">
                <div class="mt-3">
                    <h3
                        class="text-lg font-bold mb-4 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-900' }}">
                        {{ $editMode ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}
                    </h3>

                    <form wire:submit.prevent="simpan" class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Judul
                                Pengumuman *</label>
                            <input wire:model="judul" type="text"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Masukkan judul pengumuman">
                            @error('judul')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Isi
                                Pengumuman *</label>
                            <textarea wire:model="isi" rows="6"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Masukkan isi pengumuman"></textarea>
                            @error('isi')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Status
                                *</label>
                            <select wire:model="aktif"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                            @error('aktif')
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
</div>
