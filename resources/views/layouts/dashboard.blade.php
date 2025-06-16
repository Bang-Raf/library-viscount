<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard - Lib-In MBS')</title>

    <!-- Fonts Lokal: Figtree -->
    <link rel="stylesheet" href="{{ asset('fonts/figtree/figtree.css') }}">

    <!-- Tailwind & App CSS Lokal -->
    @vite(['resources/css/app.css'])
    @livewireStyles
    @php
        use App\Helpers\ThemeHelper;
        $activeTheme = ThemeHelper::getActiveTheme();
    @endphp
</head>

<body class="theme-{{ $activeTheme }} font-sans antialiased bg-gray-100">
    <div class="flex flex-col min-h-screen">
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div
                class="w-64 flex flex-col min-h-full flex-shrink-0 {{ $activeTheme === 'glass' ? 'sidebar-glass sidebar' : 'bg-white shadow-lg' }}">
                <div class="flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex items-center justify-center h-16 bg-blue-600 text-white">
                        <h1 class="text-xl font-bold">Lib-In MBS Dashboard</h1>
                    </div>

                    <!-- User Info & Logout (pindah ke atas) -->
                    <div class="border-b border-gray-200 p-4 bg-gradient-to-r from-blue-50 to-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shadow">
                                    <span
                                        class="text-white text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-semibold text-gray-800 leading-tight">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-blue-600 capitalize font-medium">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('home') }}"
                                class="flex items-center px-3 py-2 text-xs bg-white text-blue-700 rounded-lg shadow hover:bg-blue-50 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Halaman Utama
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center px-3 py-2 text-xs bg-white text-red-600 rounded-lg shadow hover:bg-red-50 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 space-y-2">
                        <a href="{{ route('dashboard.index') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.index') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 5a2 2 0 012-2h4a2 2 0 012 2v0M8 5a2 2 0 012-2h4a2 2 0 012 2v0"></path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('dashboard.pengunjung') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.pengunjung') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.pengunjung') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Data Pengunjung
                        </a>

                        <a href="{{ route('dashboard.kunjungan') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.kunjungan') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.kunjungan') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            Riwayat Kunjungan
                        </a>

                        <a href="{{ route('dashboard.laporan') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.laporan') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.laporan') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Laporan
                        </a>

                        <a href="{{ route('dashboard.pengumuman') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.pengumuman') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.pengumuman') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                                </path>
                            </svg>
                            Pengumuman
                        </a>

                        <a href="{{ route('dashboard.peraturan') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.peraturan') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.peraturan') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16h8M8 12h8m-8-4h8M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Manajemen Peraturan
                        </a>

                        <a href="{{ route('dashboard.theme') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.theme') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.theme') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Manajemen Tema
                        </a>

                        @if (auth()->user() && auth()->user()->isAdmin())
                            <a href="{{ route('dashboard.users') }}"
                                class="flex items-center px-4 py-2 rounded-lg transition {{ $activeTheme === 'glass' && request()->routeIs('dashboard.users') ? 'sidebar-active' : ($activeTheme !== 'glass' && request()->routeIs('dashboard.users') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100') }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Manajemen User
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header
                    class="{{ $activeTheme === 'glass' ? 'navbar-glass' : 'bg-white shadow-sm border-b border-gray-200' }}">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1
                                    class="text-2xl font-semibold {{ $activeTheme === 'glass' ? 'text-blue-900' : 'text-gray-800' }}">
                                    @yield('page-title', 'Dashboard')</h1>
                                <p
                                    class="text-sm mt-1 {{ $activeTheme === 'glass' ? 'text-blue-700' : 'text-gray-600' }}">
                                    @yield('page-description', 'Selamat datang di dashboard Lib-In MBS')</p>
                            </div>

                            <div class="text-right">
                                {{-- jika berada di halaman theme, maka tidak perlu menampilkan jam --}}
                                @if (!request()->routeIs('dashboard.theme'))
                                    <x-rtc-clock :style="$activeTheme" :show-seconds="true" class="text-sm text-gray-600" />
                                @endif
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-6">
                    @yield('content')
                </main>
            </div>
        </div>
        @include('layouts.footer')
    </div>
    <!-- App JS Lokal -->
    @vite(['resources/js/app.js'])
    <!-- Livewire JS Lokal -->
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    @stack('scripts')
</body>

</html>
