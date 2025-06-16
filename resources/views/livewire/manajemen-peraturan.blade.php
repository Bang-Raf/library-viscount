<div>
    <!-- Pesan Sukses -->
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

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-blue-100/60 backdrop-blur-md' : 'bg-blue-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Peraturan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPeraturan }}</p>
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Peraturan Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPeraturanAktif }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }}">
        <!-- Header -->
        <div
            class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Manajemen Peraturan</h3>
                <p class="text-sm text-gray-600">Kelola peraturan perpustakaan</p>
            </div>
            <div>
                <button wire:click="tambahPeraturan"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Tambah
                    Peraturan</button>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input wire:model.live="search" type="text" placeholder="Cari judul atau isi peraturan..."
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabel Peraturan -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 w-12 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #</th>
                        <th class="px-6 py-3 w-48 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul</th>
                        <th class="px-6 py-3 w-96 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Isi</th>
                        <th class="px-6 py-3 w-32 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 w-32 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peraturan as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ($peraturan->currentPage() - 1) * $peraturan->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->judul }}
                            </td>
                            <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900">
                                {{ $item->isi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->aktif)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-600">Nonaktif</span>
                                @endif
                                <button wire:click="toggleAktif({{ $item->id }})"
                                    class="ml-2 text-xs text-blue-600 hover:underline">Ubah</button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button wire:click="editPeraturan({{ $item->id }})"
                                    class="text-yellow-600 hover:text-yellow-900">Edit</button>
                                <button wire:click="hapus({{ $item->id }})"
                                    onclick="return confirm('Yakin ingin menghapus peraturan ini?')"
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data peraturan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $peraturan->links() }}
        </div>
    </div>

    <!-- Modal Form Tambah/Edit -->
    @if ($showForm)
        <div
            class="fixed inset-0 {{ $activeTheme === 'glass' ? 'bg-white/40 backdrop-blur-sm' : 'bg-black bg-opacity-40' }} flex items-center justify-center z-50">
            <div
                class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white' }} rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <button wire:click="batalForm"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
                <h3 class="text-lg font-bold mb-4 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-900' }}">
                    {{ $editMode ? 'Edit Peraturan' : 'Tambah Peraturan' }}</h3>
                <form wire:submit.prevent="simpan">
                    <div class="mb-4">
                        <label
                            class="block text-sm font-semibold mb-2 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Judul</label>
                        <input wire:model.defer="judul" type="text"
                            class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}">
                        @error('judul')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-sm font-semibold mb-2 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Isi</label>
                        <textarea wire:model.defer="isi" rows="3"
                            class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"></textarea>
                        @error('isi')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model.defer="aktif" class="form-checkbox">
                            <span class="ml-2">Aktif</span>
                        </label>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="batalForm"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
