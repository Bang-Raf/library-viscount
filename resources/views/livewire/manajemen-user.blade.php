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
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total User</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUser }}</p>
                </div>
            </div>
        </div>

        <div
            class="card p-6 border-l-4 border-red-500 {{ $activeTheme === 'glass' ? 'glass-card' : '' }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-red-100/60 backdrop-blur-md' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Administrator</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalAdmin }}</p>
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
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pustakawan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPustakawan }}</p>
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
                    <h3 class="text-lg font-semibold text-gray-800">Daftar User</h3>
                    <p class="text-sm text-gray-600">Kelola akun pengguna sistem</p>
                </div>
                <button wire:click="tambahUser"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah User
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input wire:model.live="search" type="text"
                        placeholder="Cari berdasarkan nama, username, atau email..."
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Role</label>
                    <select wire:model.live="roleFilter"
                        class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                        <option value="">Semua Role</option>
                        <option value="administrator">Administrator</option>
                        <option value="pustakawan">Pustakawan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            & Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->email ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->role === 'administrator' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button wire:click="editUser({{ $user->id }})"
                                        class="text-blue-600 hover:text-blue-900" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>

                                    <button wire:click="resetPassword({{ $user->id }})"
                                        onclick="return confirm('Reset password user {{ $user->name }} menjadi sandi acak baru?')"
                                        class="text-yellow-600 hover:text-yellow-900" title="Reset Password">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                            </path>
                                        </svg>
                                    </button>

                                    @if ($user->id !== auth()->id())
                                        <button wire:click="hapus({{ $user->id }})"
                                            onclick="return confirm('Yakin ingin menghapus user {{ $user->name }}?')"
                                            class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
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
                        {{ $editMode ? 'Edit User' : 'Tambah User' }}
                    </h3>
                    <form wire:submit.prevent="simpan" class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Nama
                                Lengkap *</label>
                            <input wire:model="name" type="text"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Nama lengkap user">
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Username
                                *</label>
                            <input wire:model="username" type="text"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Username untuk login">
                            @error('username')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Email</label>
                            <input wire:model="email" type="email"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Alamat email (opsional)">
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Role
                                *</label>
                            <select wire:model="role"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900' : 'bg-white border border-gray-300 text-gray-900' }}">
                                <option value="pustakawan">Pustakawan</option>
                                <option value="administrator">Administrator</option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">
                                Password {{ $editMode ? '(kosongkan jika tidak ingin mengubah)' : '*' }}
                            </label>
                            <input wire:model="password" type="password"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Password">
                            @error('password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold mb-1 {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-700' }}">Konfirmasi
                                Password</label>
                            <input wire:model="password_confirmation" type="password"
                                class="w-full px-3 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $activeTheme === 'glass' ? 'bg-white/80 border-2 border-blue-300 text-blue-900 placeholder-blue-400' : 'bg-white border border-gray-300 text-gray-900' }}"
                                placeholder="Konfirmasi password">
                            @error('password_confirmation')
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
