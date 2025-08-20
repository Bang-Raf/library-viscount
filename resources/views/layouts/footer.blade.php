@php
    use App\Helpers\ThemeHelper;
    $activeTheme = ThemeHelper::getActiveTheme();
@endphp
{{-- Footer --}}
<footer
    class="w-full text-center py-4 text-sm transition footer-bar
    {{ $activeTheme === 'glass'
        ? 'glass-footer text-blue-900 bg-white/60 border-t border-blue-100/60 rounded-br-[1.25rem] shadow-sm backdrop-blur-md'
        : 'text-blue-800 bg-blue-50/60' }}"
    style="box-shadow: 0 -2px 8px 0 rgba(0,0,0,0.03);">
    © 2025 <span class="font-semibold">Alfalimbany Tech</span>. Copyright All Rights Reserved.
    <span class="mx-2">|</span>
    <a href="{{ url('/tentang-developer') }}" class="text-blue-500 transition">About
        Developer</a>
</footer>
{{-- End Footer --}}
