<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Lib-In MBS - Sistem Informasi Kunjungan Perpustakaan MBS Pleret')</title>

    <!-- Fonts Lokal: Figtree -->
    <link rel="stylesheet" href="{{ asset('fonts/figtree/figtree.css') }}">

    <!-- Tailwind & App CSS Lokal -->
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body class="theme-{{ $activeTheme }} font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @yield('content')
    </div>

    <!-- App JS Lokal -->
    @vite(['resources/js/app.js'])
    <!-- Livewire JS Lokal -->
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    @stack('scripts')
</body>

</html>
