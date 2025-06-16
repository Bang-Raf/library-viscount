@php
    $activeTheme =
        $activeTheme ??
        (function_exists('theme_active') ? theme_active() : \App\Helpers\ThemeHelper::getActiveTheme() ?? 'glass');
@endphp
<div class="flex flex-col md:flex-row gap-8">
    <!-- Kiri: Form Pilihan Tema -->
    <div
        class="w-full md:w-1/2 max-w-xl {{ $activeTheme === 'glass' ? 'glass-card' : 'bg-white border border-gray-200 shadow rounded-xl' }} p-6">
        <h2 class="text-2xl font-bold mb-2 text-blue-700">Manajemen Tema</h2>
        <p class="text-gray-600 mb-6">Pilih tema tampilan utama aplikasi. Perubahan tema akan diterapkan secara global.
        </p>
        @if (session()->has('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        <form wire:submit.prevent="updateTheme">
            <div class="space-y-4">
                @foreach ($themes as $theme)
                    <label
                        class="flex items-center p-3 rounded-lg border cursor-pointer transition {{ $activeTheme == $theme->name ? 'border-blue-600 bg-blue-50' : ($activeTheme === 'glass' ? 'border-blue-200/60 bg-white/40 backdrop-blur-md' : 'border-gray-200 hover:border-blue-400') }}">
                        <input type="radio" name="theme" wire:model="selectedTheme" value="{{ $theme->name }}"
                            class="form-radio text-blue-600 focus:ring-blue-500 mr-3"
                            onchange="window.history.replaceState(null, '', '?preview={{ $theme->name }}')" />
                        <div>
                            <div class="font-semibold text-blue-700">{{ $theme->label }}</div>
                            <div class="text-xs text-gray-500">{{ $theme->description }}</div>
                        </div>
                        @if ($activeTheme == $theme->name)
                            <span class="ml-auto text-xs px-2 py-1 bg-blue-600 text-white rounded">Aktif</span>
                        @endif
                    </label>
                @endforeach
            </div>
            <button type="submit"
                class="mt-6 w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">Simpan
                Tema</button>
        </form>
    </div>
    <!-- Kanan: Preview Tema -->
    <div class="w-full md:w-1/2 flex items-center justify-center">
        @php
            $previewTheme = request()->query('preview') ?? $selectedTheme;
        @endphp
        <div class="w-full max-w-xs" :key="$selectedTheme">
            @if ($previewTheme === 'minimal')
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow text-center mb-4">
                    <div class="text-lg font-bold text-blue-700 mb-2">Minimal / Light</div>
                    <div class="text-gray-600">Tampilan bersih, terang, dan simpel.</div>
                </div>
            @elseif ($previewTheme === 'dark')
                <div
                    class="rounded-xl border border-blue-900 bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-900 p-6 shadow text-center mb-4">
                    <div class="text-lg font-bold text-white mb-2">Dark</div>
                    <div class="text-blue-200">Tampilan gelap, nyaman di malam hari.</div>
                </div>
            @elseif ($previewTheme === 'glass')
                <div class="rounded-xl border border-blue-100 bg-white/40 backdrop-blur-md p-6 shadow text-center mb-4"
                    style="backdrop-filter: blur(12px);">
                    <div class="text-lg font-bold text-blue-800 mb-2">Glass</div>
                    <div class="text-blue-600">Efek transparan & glassmorphism modern.</div>
                </div>
            @elseif ($previewTheme === 'digital')
                <div
                    class="rounded-xl border border-cyan-200 bg-gradient-to-br from-blue-200 via-cyan-100 to-white p-6 shadow text-center mb-4">
                    <div class="text-lg font-bold text-cyan-700 mb-2">Digital</div>
                    <div class="text-cyan-700">Warna cerah, modern, dan kontras.</div>
                </div>
            @endif
            <div class="flex flex-col gap-4 items-center justify-center">
                <x-rtc-clock :style="$previewTheme" :key="$selectedTheme . '-clock'" :wireIgnore="false" class="w-full" />
                <x-calendar-widget :style="$previewTheme" :key="$selectedTheme . '-calendar'" :show-header="false" class="w-full" />
            </div>
        </div>
    </div>
</div>
