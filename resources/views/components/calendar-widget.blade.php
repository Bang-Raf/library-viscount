@props([
    'class' => '',
    'showHeader' => true,
    'highlightToday' => true,
    'style' => 'glass', // glass|minimal|digital
])

@php
    use Carbon\Carbon;

    $now = Carbon::now('Asia/Jakarta');
    $currentMonth = $now->month;
    $currentYear = $now->year;
    $today = $now->day;
    $widgetId = 'calendar-widget-' . uniqid();

    // Nama bulan dalam bahasa Indonesia
    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    // Nama hari dalam bahasa Indonesia, mulai dari Senin
    $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    // Mendapatkan hari pertama dalam bulan
    $firstDay = Carbon::create($currentYear, $currentMonth, 1);
    $startOfWeek = $firstDay->dayOfWeek;
    $startOffset = $startOfWeek === 0 ? 6 : $startOfWeek - 1;
    $daysInMonth = $firstDay->daysInMonth;
    $prevMonth = $firstDay->copy()->subMonth();
    $daysInPrevMonth = $prevMonth->daysInMonth;
    // Pilih class utama card sesuai style
    $cardClass = match ($style) {
        'glass' => 'calendar-glass-card bg-white rounded-xl shadow-lg p-6',
        'minimal' => 'calendar-minimal-card bg-white border border-gray-200 rounded-xl p-6',
        'digital'
            => 'calendar-digital-card bg-gradient-to-br from-blue-200 via-cyan-100 to-white border border-cyan-200 shadow-lg rounded-xl p-6',
        'dark'
            => 'calendar-dark-card bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-900 border border-blue-900 shadow-lg rounded-xl p-6',
        default => 'calendar-glass-card bg-white rounded-xl shadow-lg p-6',
    };

    // Konfigurasi warna bulatan dan label footer per style
    $footerInfo = [
        'glass' => [
            ['label' => 'Hari ini', 'dot' => 'bg-blue-600', 'labelClass' => 'calendar-footer-label-today'],
            [
                'label' => 'Sudah lewat',
                'dot' => 'calendar-footer-dot-past-glass',
                'labelClass' => 'calendar-footer-label-past-glass',
            ],
        ],
        'minimal' => [
            ['label' => 'Hari ini', 'dot' => 'bg-blue-600', 'labelClass' => 'calendar-footer-label-today'],
            [
                'label' => 'Sudah lewat',
                'dot' => 'calendar-footer-dot-past-minimal',
                'labelClass' => 'calendar-footer-label-past-minimal',
            ],
        ],
        'digital' => [
            ['label' => 'Hari ini', 'dot' => 'bg-blue-600', 'labelClass' => 'calendar-footer-label-today'],
            [
                'label' => 'Sudah lewat',
                'dot' => 'calendar-footer-dot-past-digital',
                'labelClass' => 'calendar-footer-label-past-digital',
            ],
        ],
        'dark' => [
            ['label' => 'Hari ini', 'dot' => 'bg-blue-600', 'labelClass' => 'calendar-footer-label-today'],
            [
                'label' => 'Sudah lewat',
                'dot' => 'calendar-footer-dot-past-dark',
                'labelClass' => 'calendar-footer-label-past-dark',
            ],
        ],
    ];
    $activeFooter = $footerInfo[$style] ?? $footerInfo['glass'];
@endphp

<!-- Kalender Card Wrapper -->
<div class="{{ $cardClass }} {{ $class }}" id="{{ $widgetId }}">
    <!-- HEADER KALENDER -->
    @if ($showHeader)
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold calendar-header-title flex items-center">
                <svg class="w-6 h-6 mr-2 calendar-header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Kalender
            </h3>
            <div class="text-right">
                <div class="text-lg font-bold calendar-header-month">{{ $monthNames[$currentMonth] }}</div>
                <div class="text-sm calendar-header-year">{{ $currentYear }}</div>
            </div>
        </div>
    @endif

    <!-- HEADER HARI -->
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach ($dayNames as $dayName)
            <div class="text-center text-xs font-semibold text-gray-600 py-2">
                {{ $dayName }}
            </div>
        @endforeach
    </div>

    <!-- GRID KALENDER -->
    <div class="grid grid-cols-7 gap-1">
        <!-- Padding hari dari bulan sebelumnya -->
        @for ($i = 0; $i < $startOffset; $i++)
            @php $prevDay = $daysInPrevMonth - $startOffset + $i + 1; @endphp
            <div
                class="aspect-square flex items-center justify-center text-xs text-gray-300 hover:bg-gray-50 rounded-lg transition-colors cursor-default">
                {{ $prevDay }}
            </div>
        @endfor
        <!-- Hari-hari dalam bulan -->
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $isToday = $highlightToday && $day === $today;
                $isPast = $day < $today;
            @endphp
            <div
                class="aspect-square flex items-center justify-center text-sm font-medium rounded-lg transition-all duration-200 cursor-pointer
                {{ $isToday ? 'bg-blue-600 text-white shadow-lg transform scale-110 z-10' : ($isPast ? 'text-gray-400 hover:bg-gray-100' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600') }}">
                {{ $day }}
            </div>
        @endfor
        <!-- Padding hari dari bulan berikutnya -->
        @php
            $totalCells = $startOffset + $daysInMonth;
            $remainingCells = 42 - $totalCells;
            if ($remainingCells >= 7) {
                $remainingCells -= 7;
            }
        @endphp
        @for ($day = 1; $day <= $remainingCells && $remainingCells < 7; $day++)
            <div
                class="aspect-square flex items-center justify-center text-xs text-gray-300 hover:bg-gray-50 rounded-lg transition-colors cursor-default">
                {{ $day }}
            </div>
        @endfor
    </div>

    <!-- FOOTER INFORMASI -->
    <div class="mt-6 pt-4 border-t border-gray-100 calendar-footer-info">
        <div class="flex items-center justify-between text-xs calendar-footer-text">
            <div class="flex items-center space-x-4">
                @foreach ($activeFooter as $info)
                    <div class="flex items-center">
                        <div class="w-3 h-3 {{ $info['dot'] }} rounded-full mr-2"></div>
                        <span class="{{ $info['labelClass'] }}">{{ $info['label'] }}</span>
                    </div>
                @endforeach
            </div>
            <div class="calendar-footer-days">{{ $daysInMonth }} hari</div>
        </div>
    </div>
</div>

<style>
    /* Animasi untuk highlight hari ini */
    @keyframes pulse-today {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(59, 130, 246, 0);
        }
    }

    .calendar-today-pulse {
        animation: pulse-today 2s infinite;
    }

    /* Hover effects untuk tanggal */
    #{{ $widgetId }} .aspect-square:hover {
        transform: scale(1.05);
    }

    /* Smooth transitions */
    #{{ $widgetId }} .aspect-square {
        transition: all 0.2s ease-in-out;
    }

    /* Today highlight dengan gradien */
    #{{ $widgetId }} .bg-blue-600 {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        position: relative;
    }

    #{{ $widgetId }} .bg-blue-600::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 0.5rem;
        z-index: -1;
        opacity: 0.3;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        #{{ $widgetId }} .aspect-square {
            font-size: 0.75rem;
        }

        #{{ $widgetId }} .text-xs {
            font-size: 0.625rem;
        }
    }

    /* Glassmorphism style untuk kalender */
    .calendar-glass-card {
        position: relative;
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.65) 60%, rgba(186, 230, 253, 0.45) 100%, rgba(59, 130, 246, 0.13) 100%);
        border: 2px solid rgba(59, 130, 246, 0.22);
        box-shadow: 0 8px 32px 0 rgba(59, 130, 246, 0.18), 0 1.5px 6px 0 rgba(59, 130, 246, 0.10);
        border-radius: 1.25rem;
        backdrop-filter: blur(22px) saturate(180%);
        -webkit-backdrop-filter: blur(22px) saturate(180%);
        overflow: hidden;
    }

    .calendar-glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: inherit;
        pointer-events: none;
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.38) 0%, rgba(186, 230, 253, 0.22) 100%);
        box-shadow: 0 2px 24px 0 rgba(59, 130, 246, 0.10) inset, 0 0 0 1.5px rgba(59, 130, 246, 0.10) inset;
        z-index: 0;
    }

    .calendar-glass-card::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 18px;
        width: 90px;
        height: 22px;
        background: linear-gradient(110deg, rgba(255, 255, 255, 0.55) 0%, rgba(255, 255, 255, 0.08) 100%);
        border-radius: 18px;
        opacity: 0.8;
        pointer-events: none;
        filter: blur(2px);
        z-index: 1;
    }

    .calendar-glass-card>* {
        position: relative;
        z-index: 2;
    }

    .calendar-glass-card .text-gray-800,
    .calendar-glass-card .text-blue-600,
    .calendar-glass-card .text-gray-500,
    .calendar-glass-card .aspect-square {
        color: #0a2540 !important;
        text-shadow: 0 1px 4px #fff;
    }

    .calendar-glass-card .bg-blue-600 {
        color: #fff !important;
        text-shadow: 0 1px 4px #2563eb;
    }

    /* Tanggal sudah lewat pada style glass */
    .calendar-glass-card .text-gray-400 {
        color: #64748b !important;
        font-weight: 400 !important;
        opacity: 0.95;
    }

    /* Minimal style */
    .calendar-minimal-card {
        background: #fff;
        border: 1.5px solid #e5e7eb;
        box-shadow: none;
        border-radius: 1.25rem;
    }

    .calendar-minimal-card .aspect-square {
        background: transparent;
        color: #1e293b;
        font-weight: 500;
        border-radius: 0.5rem;
        transition: background 0.2s, color 0.2s;
    }

    .calendar-minimal-card .aspect-square:hover {
        background: #f1f5f9;
        color: #2563eb;
    }

    .calendar-minimal-card .bg-blue-600 {
        background: #2563eb !important;
        color: #fff !important;
        box-shadow: 0 2px 8px 0 rgba(37, 99, 235, 0.10);
    }

    .calendar-minimal-card .text-gray-400 {
        color: #64748b !important;
    }

    .calendar-minimal-card .text-gray-300 {
        color: #e5e7eb !important;
    }

    .calendar-minimal-card .calendar-header-title,
    .calendar-minimal-card .calendar-header-icon,
    .calendar-minimal-card .calendar-footer-info,
    .calendar-minimal-card .calendar-footer-text,
    .calendar-minimal-card .calendar-footer-label-today,
    .calendar-minimal-card .calendar-footer-label-past,
    .calendar-minimal-card .calendar-footer-days {
        color: #1e293b;
    }

    .calendar-minimal-card .calendar-header-month {
        color: #2563eb;
    }

    .calendar-minimal-card .calendar-header-year {
        color: #64748b;
    }

    /* Digital style */
    .calendar-digital-card {
        background: linear-gradient(120deg, #bae6fd 60%, #a7f3d0 100%, #fff 100%);
        border: 1.5px solid #67e8f9;
        box-shadow: 0 8px 32px 0 rgba(14, 165, 233, 0.12), 0 1.5px 6px 0 rgba(14, 165, 233, 0.08);
        border-radius: 1.25rem;
    }

    .calendar-digital-card .aspect-square {
        background: transparent;
        color: #0e7490;
        font-weight: 700;
        border-radius: 0.5rem;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        box-shadow: 0 0 0 0 #67e8f9;
    }

    .calendar-digital-card .aspect-square:hover {
        background: #e0f2fe;
        color: #0ea5e9;
        box-shadow: 0 2px 8px 0 #67e8f9;
    }

    .calendar-digital-card .bg-blue-600 {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9) !important;
        color: #fff !important;
        box-shadow: 0 2px 12px 0 #67e8f9;
        border-radius: 0.5rem;
    }

    .calendar-digital-card .text-gray-400 {
        color: #38bdf8 !important;
        font-weight: 600;
    }

    .calendar-digital-card .text-gray-300 {
        color: #bae6fd !important;
    }

    .calendar-digital-card .calendar-header-title,
    .calendar-digital-card .calendar-header-icon,
    .calendar-digital-card .calendar-footer-info,
    .calendar-digital-card .calendar-footer-text,
    .calendar-digital-card .calendar-footer-label-today,
    .calendar-digital-card .calendar-footer-label-past,
    .calendar-digital-card .calendar-footer-days {
        color: #0e2233;
    }

    .calendar-digital-card .calendar-header-month {
        color: #0ea5e9;
    }

    .calendar-digital-card .calendar-header-year {
        color: #64748b;
    }

    .calendar-digital-card .calendar-footer-dot-past-digital {
        background: #38bdf8 !important;
        color: #0e2233 !important;
        z-index: 2;
    }

    .calendar-digital-card .calendar-footer-label-past-digital {
        color: #1e293b !important;
        font-weight: 400 !important;
        letter-spacing: 0.01em;
    }

    /* Warna tanggal bulan sebelumnya pada digital */
    .calendar-digital-card .text-gray-300 {
        color: #b6c2cf !important;
    }

    /* Dark style */
    .calendar-dark-card {
        position: relative;
        background: linear-gradient(120deg, #0f172a 60%, #0e2233 100%, #0ea5e9 100%);
        border: 2px solid #0ea5e9;
        box-shadow: 0 8px 32px 0 rgba(14, 165, 233, 0.12), 0 1.5px 6px 0 rgba(14, 165, 233, 0.08);
        border-radius: 1.25rem;
        backdrop-filter: blur(14px) saturate(120%);
        -webkit-backdrop-filter: blur(14px) saturate(120%);
        overflow: hidden;
    }

    .calendar-dark-card .aspect-square {
        background: transparent;
        color: #e0f2fe;
        font-weight: 700;
        border-radius: 0.5rem;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        box-shadow: 0 0 0 0 #67e8f9;
    }

    .calendar-dark-card .aspect-square:hover {
        background: #164e63;
        color: #67e8f9;
        box-shadow: 0 2px 8px 0 #0ea5e9;
    }

    .calendar-dark-card .bg-blue-600 {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9) !important;
        color: #fff !important;
        box-shadow: 0 2px 12px 0 #67e8f9;
        border-radius: 0.5rem;
    }

    .calendar-dark-card .text-gray-400 {
        color: #7dd3fc !important;
    }

    .calendar-dark-card .text-gray-300 {
        color: #bae6fd !important;
    }

    .calendar-dark-card .calendar-header-title,
    .calendar-dark-card .calendar-header-icon,
    .calendar-dark-card .calendar-footer-info,
    .calendar-dark-card .calendar-footer-text,
    .calendar-dark-card .calendar-footer-label-today,
    .calendar-dark-card .calendar-footer-label-past,
    .calendar-dark-card .calendar-footer-days {
        color: #fff;
    }

    .calendar-dark-card .calendar-header-month {
        color: #67e8f9;
    }

    .calendar-dark-card .calendar-header-year {
        color: #bae6fd;
    }

    .calendar-dark-card .calendar-footer-label-today,
    .calendar-dark-card .calendar-footer-label-past {
        color: #67e8f9;
    }

    .calendar-dark-card .calendar-footer-dot-past {
        background: #67e8f9;
    }

    /* Dot keterangan sudah lewat sesuai konfigurasi $footerInfo */
    .calendar-footer-dot-past-glass {
        background: #64748b !important;
    }

    .calendar-footer-dot-past-minimal {
        background: #64748b !important;
    }

    .calendar-footer-dot-past-digital {
        background: #38bdf8 !important;
    }

    .calendar-footer-dot-past-dark {
        background: #67e8f9 !important;
    }

    /* Header dan Footer Kalender Responsive Style */
    .calendar-header-title,
    .calendar-header-icon {
        color: #0a2540;
    }

    .calendar-header-month {
        color: #2563eb;
    }

    .calendar-header-year {
        color: #64748b;
    }

    .calendar-footer-info,
    .calendar-footer-text,
    .calendar-footer-label-today,
    .calendar-footer-label-past,
    .calendar-footer-days {
        color: #0a2540;
    }

    /* DIGITAL */
    .calendar-digital-card .calendar-header-title,
    .calendar-digital-card .calendar-header-icon,
    .calendar-digital-card .calendar-footer-info,
    .calendar-digital-card .calendar-footer-text,
    .calendar-digital-card .calendar-footer-label-today,
    .calendar-digital-card .calendar-footer-label-past,
    .calendar-digital-card .calendar-footer-days {
        color: #0e2233;
    }

    .calendar-digital-card .calendar-header-month {
        color: #0ea5e9;
    }

    .calendar-digital-card .calendar-header-year {
        color: #64748b;
    }

    /* MINIMAL */
    .calendar-minimal-card .calendar-header-title,
    .calendar-minimal-card .calendar-header-icon,
    .calendar-minimal-card .calendar-footer-info,
    .calendar-minimal-card .calendar-footer-text,
    .calendar-minimal-card .calendar-footer-label-today,
    .calendar-minimal-card .calendar-footer-label-past,
    .calendar-minimal-card .calendar-footer-days {
        color: #1e293b;
    }

    .calendar-minimal-card .calendar-header-month {
        color: #2563eb;
    }

    .calendar-minimal-card .calendar-header-year {
        color: #64748b;
    }

    /* DARK */
    .calendar-dark-card .calendar-header-title,
    .calendar-dark-card .calendar-header-icon,
    .calendar-dark-card .calendar-footer-info,
    .calendar-dark-card .calendar-footer-text,
    .calendar-dark-card .calendar-footer-label-today,
    .calendar-dark-card .calendar-footer-label-past,
    .calendar-dark-card .calendar-footer-days {
        color: #fff;
    }

    .calendar-dark-card .calendar-header-month {
        color: #67e8f9;
    }

    .calendar-dark-card .calendar-header-year {
        color: #bae6fd;
    }

    .calendar-dark-card .calendar-footer-label-today,
    .calendar-dark-card .calendar-footer-label-past {
        color: #67e8f9;
    }

    /* Keterangan sudah lewat khusus digital, tanpa bg-blue-600 */
    .calendar-footer-dot-past-digital-only {
        background: #bae6fd !important;
        display: inline-block;
        z-index: 2;
    }

    .calendar-footer-label-past-digital {
        color: #38bdf8 !important;
        font-weight: 600 !important;
        letter-spacing: 0.01em;
    }

    /* Label keterangan sudah lewat sesuai konfigurasi $footerInfo */
    .calendar-footer-label-past-glass {
        color: #64748b !important;
    }

    .calendar-footer-label-past-minimal {
        color: #64748b !important;
    }

    /* Hover tanggal pada style glass (selain hari ini) */
    .calendar-glass-card .aspect-square:not(.bg-blue-600):hover {
        background: #e0e7ef !important;
        color: #2563eb !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan animasi pulse untuk hari ini
        const todayElements = document.querySelectorAll('#{{ $widgetId }} .bg-blue-600');
        todayElements.forEach(element => {
            element.classList.add('calendar-today-pulse');
        });

        // Tambahkan tooltip untuk tanggal
        const calendarDays = document.querySelectorAll('#{{ $widgetId }} .aspect-square');
        calendarDays.forEach((day, index) => {
            if (day.textContent.trim() && !day.classList.contains('text-gray-300')) {
                day.title =
                    `{{ $monthNames[$currentMonth] }} ${day.textContent.trim()}, {{ $currentYear }}`;
            }
        });
    });
</script>
