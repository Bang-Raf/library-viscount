<div>
    <!-- Statistics Cards Grid -->
    @php
        $activeTheme =
            $activeTheme ??
            (function_exists('theme_active') ? theme_active() : \App\Helpers\ThemeHelper::getActiveTheme() ?? 'glass');
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengunjung Aktif -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-blue-500 relative overflow-hidden">
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
                    <p class="text-xs text-gray-500 mt-1">Pengunjung Aktif</p>
                </div>
            </div>
        </div>

        <!-- Kunjungan Hari Ini -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-green-500 relative overflow-hidden">
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
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKunjunganHariIni }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ now()->setTimezone('Asia/Jakarta')->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Kunjungan Bulan Ini -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-yellow-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-yellow-100/60 backdrop-blur-md' : 'bg-yellow-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kunjungan Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKunjunganBulanIni }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6 border-l-4 border-purple-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 {{ $activeTheme === 'glass' ? 'bg-purple-100/60 backdrop-blur-md' : 'bg-purple-100' }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500 mt-1">Admin & Pustakawan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Dipindah ke posisi yang lebih terlihat -->
    <div class="mb-8">
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-800">⚡ Aksi Cepat</h3>
                <span class="text-gray-500 text-sm">Menu shortcut populer</span>
            </div>
            <div class="flex flex-row gap-4 p-4 justify-between rounded-lg">
                <a href="{{ route('dashboard.pengunjung') }}"
                    class="flex items-center min-w-[220px] p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-blue-50 border border-blue-100' }} rounded-lg hover:bg-blue-100 transition duration-200 transform hover:scale-105">
                    <div class="flex-shrink-0 mr-3">
                        <div
                            class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-blue-100/60 backdrop-blur-md' : 'bg-blue-100' }} rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Kelola Pengunjung</div>
                        <div class="text-xs text-gray-500">Tambah & edit data</div>
                    </div>
                </a>

                <a href="{{ route('dashboard.kunjungan') }}"
                    class="flex items-center min-w-[220px] p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-green-50 border border-green-100' }} rounded-lg hover:bg-green-100 transition duration-200 transform hover:scale-105">
                    <div class="flex-shrink-0 mr-3">
                        <div
                            class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-green-100/60 backdrop-blur-md' : 'bg-green-100' }} rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Riwayat Kunjungan</div>
                        <div class="text-xs text-gray-500">Lihat & filter data</div>
                    </div>
                </a>

                <a href="{{ route('dashboard.pengumuman') }}"
                    class="flex items-center min-w-[220px] p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-yellow-50 border border-yellow-100' }} rounded-lg hover:bg-yellow-100 transition duration-200 transform hover:scale-105">
                    <div class="flex-shrink-0 mr-3">
                        <div
                            class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-yellow-100/60 backdrop-blur-md' : 'bg-yellow-100' }} rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Kelola Pengumuman</div>
                        <div class="text-xs text-gray-500">Buat & edit info</div>
                    </div>
                </a>

                <a href="{{ route('dashboard.laporan') }}"
                    class="flex items-center min-w-[220px] p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-purple-50 border border-purple-100' }} rounded-lg hover:bg-purple-100 transition duration-200 transform hover:scale-105">
                    <div class="flex-shrink-0 mr-3">
                        <div
                            class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-purple-100/60 backdrop-blur-md' : 'bg-purple-100' }} rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Export Laporan</div>
                        <div class="text-xs text-gray-500">Download data CSV</div>
                    </div>
                </a>

                @if (auth()->user()->role === 'administrator')
                    <a href="{{ route('dashboard.users') }}"
                        class="flex items-center min-w-[220px] p-4 {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-red-50 border border-red-100' }} rounded-lg hover:bg-red-100 transition duration-200 transform hover:scale-105">
                        <div class="flex-shrink-0 mr-3">
                            <div
                                class="w-10 h-10 {{ $activeTheme === 'glass' ? 'bg-red-100/60 backdrop-blur-md' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-800">Kelola Users</div>
                            <div class="text-xs text-gray-500">Admin only</div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Chart Kunjungan 7 Hari Terakhir -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Kunjungan 7 Hari Terakhir</h3>
                <div class="text-sm text-gray-500">{{ $kunjunganMingguIni }} kunjungan minggu ini</div>
            </div>

            <div class="space-y-4">
                @foreach ($kunjungan7Hari as $data)
                    <div class="flex items-center">
                        <div class="w-16 text-sm text-gray-600">{{ $data['hari'] }}</div>
                        <div class="w-16 text-sm text-gray-500">{{ $data['tanggal'] }}</div>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $maxValue = max(array_column($kunjungan7Hari, 'jumlah')) ?: 1;
                                    $percentage = ($data['jumlah'] / $maxValue) * 100;
                                @endphp
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        <div class="w-12 text-right text-sm font-semibold text-gray-800">{{ $data['jumlah'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chart Kunjungan per Keperluan -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Kunjungan per Keperluan</h3>

            <div class="space-y-4">
                @php
                    $colors = [
                        'bg-blue-500',
                        'bg-green-500',
                        'bg-yellow-500',
                        'bg-red-500',
                        'bg-purple-500',
                        'bg-indigo-500',
                        'bg-pink-500',
                    ];
                    $totalKeperluan = $kunjunganPerKeperluan->sum('total') ?: 1;
                @endphp

                @foreach ($kunjunganPerKeperluan as $index => $keperluan)
                    <div class="flex items-center">
                        <div class="flex items-center flex-1">
                            <div class="w-4 h-4 rounded-full {{ $colors[$index % count($colors)] }} mr-3"></div>
                            <span class="text-sm text-gray-700">{{ $keperluan->keperluan }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                @php $percentage = ($keperluan->total / $totalKeperluan) * 100; @endphp
                                <div class="{{ $colors[$index % count($colors)] }} h-2 rounded-full"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                            <span
                                class="text-sm font-semibold text-gray-800 w-8 text-right">{{ $keperluan->total }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top 5 Pengunjung Aktif -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Top 5 Pengunjung Aktif</h3>

            <div class="space-y-4">
                @forelse($topPengunjung as $index => $item)
                    <div
                        class="flex items-center p-3 rounded-lg {{ $index < 3 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }}">
                        <div class="flex-shrink-0">
                            @if ($index === 0)
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-yellow-800 bg-yellow-300 rounded-full">1</span>
                            @elseif($index === 1)
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-gray-800 bg-gray-300 rounded-full">2</span>
                            @elseif($index === 2)
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-orange-800 bg-orange-300 rounded-full">3</span>
                            @else
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-gray-600 bg-gray-200 rounded-full">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $item->pengunjung->nama_lengkap ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $item->pengunjung->kelas_jabatan ?? '' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-blue-600">{{ $item->total_kunjungan }}</span>
                            <p class="text-xs text-gray-500">kunjungan</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm py-8">Belum ada data kunjungan</p>
                @endforelse
            </div>
        </div>

        <!-- Pengunjung Terbaru Hari Ini -->
        <div
            class="{{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Pengunjung Terbaru Hari Ini</h3>

            <div class="space-y-4">
                @forelse($pengunjungTerbaru as $kunjungan)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span
                                    class="text-blue-600 text-sm font-semibold">{{ substr($kunjungan->pengunjung->nama_lengkap, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $kunjungan->pengunjung->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500">{{ $kunjungan->pengunjung->kelas_jabatan }} •
                                {{ $kunjungan->keperluan }}</p>
                        </div>
                        <div class="text-right">
                            <span
                                class="text-sm font-medium text-gray-900">{{ $kunjungan->waktu_masuk->setTimezone('Asia/Jakarta')->format('H:i') }}</span>
                            <p class="text-xs text-gray-500">WIB</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm py-8">Belum ada kunjungan hari ini</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Aksi cepat dipindah ke posisi atas -->
</div>
