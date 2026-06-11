<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between bg-slate-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-[#1A3A5C]/10 text-[#1A3A5C] flex items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
            </div>
            <div class="font-semibold text-slate-800 text-[13px] uppercase tracking-wide">
                Rincian Data Audit TPU #{{ $displayData->tpu_id }}
            </div>
        </div>
    </div>

    <div class="p-6 bg-slate-50/50">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

            {{-- 1. Cabang Tdk Ada (Merah) --}}
            <div class="bg-white border border-red-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-4 py-3 bg-red-50/80 border-b border-red-100 flex items-center justify-between shrink-0">
                    <span class="font-bold text-[12.5px] text-red-800">Cabang Tdk Ada</span>
                    <span class="text-[10px] font-bold bg-white text-red-600 border border-red-200 px-2 py-0.5 rounded-full shadow-sm">{{ number_format(count($cabangTidakAda), 0, ',', '.') }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse text-[12.5px]">
                        <tbody>
                            @forelse ($cabangTidakAda as $item)
                                <tr class="hover:bg-red-50/40 transition-colors">
                                    <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full" title="{{ $item->dataMakam->nama }}">{{ $item->dataMakam->nama }}</td>
                                </tr>
                            @empty
                                <tr><td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 2. Pusat Tidak Ada (Oranye) --}}
            <div class="bg-white border border-orange-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-4 py-3 bg-orange-50/80 border-b border-orange-100 flex items-center justify-between shrink-0">
                    <span class="font-bold text-[12.5px] text-orange-800">Pusat Tdk Ada</span>
                    <span class="text-[10px] font-bold bg-white text-orange-600 border border-orange-200 px-2 py-0.5 rounded-full shadow-sm">{{ number_format(count($pusatTidakAda), 0, ',', '.') }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse text-[12.5px]">
                        <tbody>
                            @forelse ($pusatTidakAda as $item)
                                <tr class="hover:bg-orange-50/40 transition-colors">
                                    <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full" title="{{ $item->dataMakam->nama }}">{{ $item->dataMakam->nama }}</td>
                                </tr>
                            @empty
                                <tr><td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 3. Tahun Beda (Amber) --}}
            <div class="bg-white border border-amber-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-4 py-3 bg-amber-50/80 border-b border-amber-100 flex items-center justify-between shrink-0">
                    <span class="font-bold text-[12.5px] text-amber-800">Tahun Beda</span>
                    <span class="text-[10px] font-bold bg-white text-amber-600 border border-amber-200 px-2 py-0.5 rounded-full shadow-sm">{{ number_format(count($tahunBeda), 0, ',', '.') }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse text-[12.5px]">
                        <tbody>
                            @forelse ($tahunBeda as $item)
                                <tr class="hover:bg-amber-50/40 transition-colors">
                                    <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full" title="{{ $item->dataMakam->nama }}">{{ $item->dataMakam->nama }}</td>
                                </tr>
                            @empty
                                <tr><td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 4. Fuzzy Match (Purple) --}}
            <div class="bg-white border border-purple-200 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-4 py-3 bg-purple-50/80 border-b border-purple-200 flex items-center justify-between shrink-0">
                    <span class="font-bold text-[12.5px] text-purple-800">Fuzzy Match</span>
                    <span class="text-[10px] font-bold bg-white text-purple-600 border border-purple-300 px-2 py-0.5 rounded-full shadow-sm">{{ number_format($fuzzyMatch->count(), 0, ',', '.') }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <div class="w-full text-left text-[12.5px]">
                        @forelse($fuzzyMatch as $item)
                            <div class="px-4 py-3 border-b border-slate-100 hover:bg-purple-50/40 transition-colors">
                                <div class="font-medium text-slate-800 truncate" title="{{ $item->dataMakam->nama }}">{{ $item->dataMakam->nama }}</div>
                                @if ($item->matchedData)
                                    <div class="text-[11px] text-purple-600 mt-0.5 truncate" title="Mirip: {{ $item->matchedData->nama }}">Mirip: {{ $item->matchedData->nama }}</div>
                                @endif
                            </div>
                        @empty
                            <div class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 5. Match Full (Hijau) --}}
            <div class="bg-white border border-green-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-4 py-3 bg-green-50/80 border-b border-green-100 flex items-center justify-between shrink-0">
                    <span class="font-bold text-[12.5px] text-green-800">Match Full</span>
                    <span class="text-[10px] font-bold bg-white text-green-600 border border-green-200 px-2 py-0.5 rounded-full shadow-sm">{{ number_format(count($matchFull), 0, ',', '.') }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse text-[12.5px]">
                        <tbody>
                            @forelse ($matchFull as $item)
                                <tr class="hover:bg-green-50/40 transition-colors">
                                    <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full" title="{{ $item->dataMakam->nama }}">{{ $item->dataMakam->nama }}</td>
                                </tr>
                            @empty
                                <tr><td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>