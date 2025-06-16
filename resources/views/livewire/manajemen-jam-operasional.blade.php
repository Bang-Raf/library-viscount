<div>
    <h2 class="text-2xl font-extrabold mb-6 text-blue-800 text-center">Manajemen Jam Operasional</h2>
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded text-center">
            {{ session('success') }}
        </div>
    @endif
    <form wire:submit.prevent="simpan" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari)
                <div class="p-6 rounded-2xl border bg-white/80 glass-card flex flex-col items-center shadow-sm">
                    <div class="font-bold capitalize mb-3 text-blue-700 text-lg tracking-wide">{{ ucfirst($hari) }}</div>
                    <div class="flex gap-2 items-center w-full justify-center">
                        <label class="text-sm">Buka</label>
                        <input type="time" wire:model.defer="jam.{{ $hari }}.buka"
                            class="border rounded px-2 py-1 w-30">
                        <span class="mx-1 text-gray-400">-</span>
                        <label class="text-sm">Tutup</label>
                        <input type="time" wire:model.defer="jam.{{ $hari }}.tutup"
                            class="border rounded px-2 py-1 w-30">
                    </div>
                    @if (empty($jam[$hari]['buka']) || empty($jam[$hari]['tutup']))
                        <div class="text-xs text-red-500 mt-2 font-semibold">Libur</div>
                    @else
                        <div class="text-xs text-gray-500 mt-2">{{ $jam[$hari]['buka'] }} - {{ $jam[$hari]['tutup'] }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="flex justify-center">
            <button type="submit"
                class="mt-6 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-lg shadow-lg transition">Simpan
                Jam Operasional</button>
        </div>
    </form>
</div>
