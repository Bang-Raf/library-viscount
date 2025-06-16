@props([
    'showSeconds' => true,
    'class' => '',
    'id' => 'rtc-clock-display-' . uniqid(),
    'style' => 'glass', // glass|minimal|digital
    'wireIgnore' => true,
])

@if ($style === 'glass')
    <div class="rtc-clock-widget-glass flex items-center justify-center select-none"
        @if ($wireIgnore) wire:ignore @endif>
        <div
            class="flex items-center gap-4 px-6 py-4 rounded-2xl shadow-lg bg-white/40 backdrop-blur-md border border-blue-100 relative overflow-hidden rtc-glass-card">
            <div class="flex-shrink-0">
                <svg class="w-10 h-10 text-blue-500 drop-shadow animate-spin-slow" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                </svg>
            </div>
            <div class="flex flex-col items-start">
                <span id="{{ $id }}-time"
                    class="font-mono text-2xl md:text-3xl font-bold text-blue-800 rtc-clock-active-glass">00:00:00</span>
                <span id="{{ $id }}-date"
                    class="text-xs md:text-sm text-blue-700 mt-1 rtc-date-active-glass animate-pulse">Memuat
                    tanggal...</span>
            </div>
        </div>
    </div>
@elseif($style === 'minimal')
    <div class="rtc-clock-widget-minimal flex flex-col items-center justify-center select-none border border-gray-200 rounded-xl bg-white/80 px-5 py-3"
        @if ($wireIgnore) wire:ignore @endif>
        <span id="{{ $id }}-time"
            class="font-mono text-3xl md:text-4xl font-bold text-gray-800 tracking-wide bg-transparent px-2">00:00:00</span>
        <span id="{{ $id }}-date"
            class="text-xs md:text-sm text-blue-600 mt-2 font-medium tracking-wide">Memuat tanggal...</span>
    </div>
@elseif($style === 'digital')
    <div class="rtc-clock-widget-digital flex flex-col items-center justify-center select-none"
        @if ($wireIgnore) wire:ignore @endif>
        <div
            class="flex flex-row items-center gap-3 px-6 py-4 rounded-2xl shadow-lg bg-gradient-to-br from-blue-200 via-cyan-100 to-white border border-cyan-200 rtc-digital-card">
            <svg class="w-8 h-8 text-cyan-500 drop-shadow" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="6" fill="#67e8f9" fill-opacity="0.12" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
            </svg>
            <div class="flex flex-col items-start justify-center ml-2">
                <span id="{{ $id }}-time"
                    class="font-mono text-3xl md:text-4xl font-extrabold text-cyan-700 rtc-clock-active-digital glow-digital">00:00:00</span>
                <span id="{{ $id }}-date"
                    class="text-xs md:text-sm text-slate-800 mt-2 rtc-date-active-digital"
                    style="text-shadow:0 1px 4px #fff,0 0.5px 0 #bae6fd;">Memuat tanggal...</span>
            </div>
        </div>
    </div>
@elseif($style === 'dark')
    <div class="rtc-clock-widget-dark flex flex-col items-center justify-center select-none"
        @if ($wireIgnore) wire:ignore @endif>
        <div
            class="flex flex-row items-center gap-3 px-6 py-4 rounded-2xl shadow-lg bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-900 border border-blue-900 rtc-dark-card">
            <svg class="w-8 h-8 text-cyan-300 drop-shadow" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="6" fill="#0ea5e9" fill-opacity="0.10" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
            </svg>
            <div class="flex flex-col items-start justify-center ml-2">
                <span id="{{ $id }}-time"
                    class="font-mono text-3xl md:text-4xl font-extrabold text-cyan-100 rtc-clock-active-dark glow-dark">00:00:00</span>
                <span id="{{ $id }}-date"
                    class="text-xs md:text-sm text-cyan-200 mt-2 rtc-date-active-dark animate-pulse">Memuat
                    tanggal...</span>
            </div>
        </div>
    </div>
@endif

<script>
    class RTCClockGlass {
        constructor(elementId, showSeconds = true) {
            this.timeEl = document.getElementById(elementId + '-time');
            this.dateEl = document.getElementById(elementId + '-date');
            this.showSeconds = showSeconds;
            this.timezone = 'Asia/Jakarta';
            this.intervalId = null;
            this.init();
        }
        init() {
            if (!this.timeEl || !this.dateEl) return;
            this.updateClock();
            this.intervalId = setInterval(() => {
                this.updateClock();
            }, 1000);
        }
        destroy() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
        }
        formatTime(date) {
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            let timeString = `${hours}:${minutes}`;
            if (this.showSeconds) {
                const seconds = date.getSeconds().toString().padStart(2, '0');
                timeString += `:${seconds}`;
            }
            return timeString;
        }
        formatDate(date) {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const dayName = days[date.getDay()];
            const day = date.getDate().toString().padStart(2, '0');
            const monthName = months[date.getMonth()];
            const year = date.getFullYear();
            return `${dayName}, ${day} ${monthName} ${year} WIB`;
        }
        updateClock() {
            try {
                if (!this.timeEl || !this.dateEl) return;
                const now = new Date();
                const indoTime = new Date(now.toLocaleString('en-US', {
                    timeZone: this.timezone
                }));
                this.timeEl.textContent = this.formatTime(indoTime);
                this.dateEl.textContent = this.formatDate(indoTime);
            } catch (error) {
                if (this.timeEl) this.timeEl.textContent = '--:--:--';
                if (this.dateEl) this.dateEl.textContent = 'Error loading date';
            }
        }
    }
    window.RTCClockGlassInstances = window.RTCClockGlassInstances || {};

    function initializeRTCClockGlass(elementId, showSeconds) {
        if (window.RTCClockGlassInstances[elementId]) {
            window.RTCClockGlassInstances[elementId].destroy();
            delete window.RTCClockGlassInstances[elementId];
        }
        const timeEl = document.getElementById(elementId + '-time');
        if (timeEl) {
            window.RTCClockGlassInstances[elementId] = new RTCClockGlass(elementId, showSeconds);
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        initializeRTCClockGlass('{{ $id }}', {{ $showSeconds ? 'true' : 'false' }});
    });
    document.addEventListener('livewire:navigated', function() {
        initializeRTCClockGlass('{{ $id }}', {{ $showSeconds ? 'true' : 'false' }});
    });
    document.addEventListener('livewire:load', function() {
        initializeRTCClockGlass('{{ $id }}', {{ $showSeconds ? 'true' : 'false' }});
    });
    window.addEventListener('beforeunload', function() {
        if (window.RTCClockGlassInstances['{{ $id }}']) {
            window.RTCClockGlassInstances['{{ $id }}'].destroy();
            delete window.RTCClockGlassInstances['{{ $id }}'];
        }
    });
</script>

<style>
    .rtc-clock-widget-glass {
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .rtc-glass-card {
        position: relative;
        box-shadow: 0 8px 32px 0 rgba(59, 130, 246, 0.18), 0 1.5px 6px 0 rgba(59, 130, 246, 0.10);
        border-radius: 1.25rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.55) 60%, rgba(186, 230, 253, 0.35) 100%);
        border: 3.5px solid rgba(59, 130, 246, 0.28);
        backdrop-filter: blur(16px) saturate(160%);
        -webkit-backdrop-filter: blur(16px) saturate(160%);
        transition: box-shadow 0.3s, transform 0.2s;
        overflow: hidden;
    }

    .rtc-glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: inherit;
        pointer-events: none;
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.35) 0%, rgba(186, 230, 253, 0.18) 100%);
        box-shadow: 0 1.5px 12px 0 rgba(59, 130, 246, 0.08) inset;
    }

    .rtc-glass-card::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 18px;
        width: 60px;
        height: 18px;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.45) 0%, rgba(255, 255, 255, 0.05) 100%);
        border-radius: 18px;
        opacity: 0.7;
        pointer-events: none;
        filter: blur(1px);
    }

    .rtc-glass-card:hover {
        box-shadow: 0 12px 48px 0 rgba(59, 130, 246, 0.22), 0 2px 12px 0 rgba(59, 130, 246, 0.14);
        transform: translateY(-2px) scale(1.03);
    }

    .rtc-clock-active-glass {
        font-family: 'Fira Mono', 'SF Mono', 'Monaco', 'Inconsolata', 'Fira Code', 'Droid Sans Mono', 'Courier New', monospace;
        letter-spacing: 0.04em;
        color: #0a2540;
        text-shadow: 0 1px 4px #fff, 0 0px 1px #60a5fa;
        transition: color 0.2s, text-shadow 0.2s;
    }

    .rtc-date-active-glass {
        letter-spacing: 0.01em;
        color: #2563eb;
        text-shadow: 0 1px 2px #fff;
    }

    .rtc-clock-widget-minimal {
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .rtc-clock-widget-digital {
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .rtc-digital-card {
        box-shadow: 0 4px 32px 0 rgba(14, 165, 233, 0.10), 0 1.5px 6px 0 rgba(14, 165, 233, 0.08);
        border-radius: 1.25rem;
        background: linear-gradient(120deg, #bae6fd 60%, #a7f3d0 100%, #fff 100%);
        border: 1.5px solid #67e8f9;
        transition: box-shadow 0.3s, transform 0.2s;
    }

    .rtc-digital-card:hover {
        box-shadow: 0 8px 40px 0 rgba(14, 165, 233, 0.18), 0 2px 8px 0 rgba(14, 165, 233, 0.12);
        transform: translateY(-2px) scale(1.03);
    }

    .rtc-clock-active-digital {
        font-family: 'Share Tech Mono', 'Fira Mono', 'SF Mono', 'Monaco', 'Inconsolata', 'Fira Code', 'Droid Sans Mono', 'Courier New', monospace;
        letter-spacing: 0.08em;
        color: #0e2233;
        text-shadow: 0 1px 4px #fff, 0 0px 1px #67e8f9;
        transition: color 0.2s, text-shadow 0.2s;
    }

    .rtc-date-active-digital {
        letter-spacing: 0.01em;
        color: #0e7490;
        text-shadow: 0 1px 2px #fff;
    }

    .glow-digital {
        animation: glow-digital 1.5s ease-in-out infinite alternate;
    }

    @keyframes glow-digital {
        0% {
            text-shadow: 0 0 2px #67e8f9, 0 0px 1px #0ea5e9;
        }

        100% {
            text-shadow: 0 0 5px #0ea5e9, 0 0px 2px #67e8f9;
        }
    }

    @media (max-width: 500px) {

        .rtc-glass-card,
        .rtc-digital-card {
            padding: 1rem 0.75rem;
        }

        .rtc-clock-active-glass,
        .rtc-clock-active-digital {
            font-size: 1.1rem;
        }

        .rtc-date-active-glass,
        .rtc-date-active-digital {
            font-size: 0.85rem;
        }
    }

    .animate-spin-slow {
        animation: spin 6s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .rtc-dark-card {
        box-shadow: 0 4px 32px 0 rgba(14, 165, 233, 0.10), 0 1.5px 6px 0 rgba(14, 165, 233, 0.08);
        border-radius: 1.25rem;
        background: linear-gradient(120deg, #0f172a 60%, #0e2233 100%, #0ea5e9 100%);
        border: 1.5px solid #0ea5e9;
        backdrop-filter: blur(12px) saturate(120%);
        -webkit-backdrop-filter: blur(12px) saturate(120%);
        transition: box-shadow 0.3s, transform 0.2s;
    }

    .rtc-dark-card:hover {
        box-shadow: 0 8px 40px 0 rgba(14, 165, 233, 0.18), 0 2px 8px 0 rgba(14, 165, 233, 0.12);
        transform: translateY(-2px) scale(1.03);
    }

    .rtc-clock-active-dark {
        font-family: 'Share Tech Mono', 'Fira Mono', 'SF Mono', 'Monaco', 'Inconsolata', 'Fira Code', 'Droid Sans Mono', 'Courier New', monospace;
        letter-spacing: 0.08em;
        color: #fff;
        text-shadow: 0 1px 6px #67e8f9, 0 0px 1px #0ea5e9;
        transition: color 0.2s, text-shadow 0.2s;
    }

    .rtc-date-active-dark {
        letter-spacing: 0.01em;
        color: #bae6fd;
        text-shadow: 0 1px 4px #67e8f9;
    }

    .glow-dark {
        animation: glow-dark 1.5s ease-in-out infinite alternate;
    }

    @keyframes glow-dark {
        0% {
            text-shadow: 0 0 2px #67e8f9, 0 0px 1px #0ea5e9;
        }

        100% {
            text-shadow: 0 0 8px #0ea5e9, 0 0px 2px #67e8f9;
        }
    }

    .rtc-clock-widget-minimal #{{ $id }}-time {
        color: #1e293b;
        font-weight: 700;
        font-family: 'Fira Mono', 'SF Mono', 'Monaco', 'Inconsolata', 'Fira Code', 'Droid Sans Mono', 'Courier New', monospace;
        letter-spacing: 0.04em;
        background: transparent;
        text-shadow: none;
    }

    .rtc-clock-widget-minimal #{{ $id }}-date {
        color: #2563eb;
        font-weight: 500;
        letter-spacing: 0.02em;
        background: transparent;
    }
</style>
