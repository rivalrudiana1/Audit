@extends('layouts.app')

@section('title', 'Hasil Audit')

@section('content')

    {{-- Alert Sukses --}}
    @if (session('success'))
        <div
            class="mb-5 flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
            <div class="flex items-center gap-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Laporan Sinkronisasi Data</h2>
            <p class="text-sm text-slate-500 mt-1">Hasil perbandingan data makam Pusat dan Cabang.</p>
        </div>

        {{-- Tombol testing untuk menjalankan audit manual --}}
        <form action="{{ url('/audit/generate') }}" method="POST">
            @csrf
            <input type="hidden" name="tpu_id" value="1">
            <button id="audit-btn" type="submit"
                class="h-10 px-4 bg-[#1A3A5C] hover:bg-[#162F4A] text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition shadow-sm">

                {{-- ICON NORMAL --}}
                <svg id="audit-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                    <polyline points="23 4 23 10 17 10" />
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />

                </svg>

                {{-- ICON LOADING --}}
                <svg id="loading-icon" class="hidden animate-spin" width="16" height="16" viewBox="0 0 24 24"
                    fill="none">

                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>

                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                    </path>

                </svg>
                <span id="audit-text">
                    Jalankan Audit Ulang
                </span>
            </button>
        </form>
    </div>

    {{-- Logika Penentuan Data (Dari Session Generate atau Data Terakhir) --}}
    @php
        $displayData = $latestResult;
    @endphp

    @if ($displayData)
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="font-semibold text-slate-700 text-sm">Ringkasan Audit: TPU ID #{{ $displayData->tpu_id }}</div>
                <div class="text-xs text-slate-500 font-medium">Terakhir diupdate:
                    {{ date('d M Y, H:i', strtotime($displayData->updated_at)) }}</div>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card: Match Full --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-green-100 bg-green-50/50">
                    <div class="flex items-center gap-2 text-green-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Match Full</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($displayData->total_match, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-500 font-medium">Data sama persis</div>
                </div>

                {{-- Card: Tahun Beda --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-amber-100 bg-amber-50/50">
                    <div class="flex items-center gap-2 text-amber-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Tahun Beda</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($displayData->total_tahun_beda, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-500 font-medium">Nama sama, tahun berbeda</div>
                </div>

                {{-- Card: Pusat Tidak Ada di Pandu --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-red-100 bg-red-50/50">
                    <div class="flex items-center gap-2 text-red-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">

                            <circle cx="12" cy="12" r="10"></circle>

                            <line x1="15" y1="9" x2="9" y2="15"></line>

                            <line x1="9" y1="9" x2="15" y2="15"></line>

                        </svg>

                        <span class="text-xs font-bold uppercase tracking-wider">
                            Pusat Tidak Ada di Pandu
                        </span>
                    </div>

                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($displayData->total_pusat_tidak_ada ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="text-[11px] text-slate-500 font-medium">
                        Data pusat tidak ditemukan di cabang
                    </div>
                </div>

                {{-- Card: Pandu Tidak Ada di Pusat --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-rose-100 bg-rose-50/50">
                    <div class="flex items-center gap-2 text-rose-700">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">

                            <circle cx="12" cy="12" r="10"></circle>

                            <line x1="15" y1="9" x2="9" y2="15"></line>

                            <line x1="9" y1="9" x2="15" y2="15"></line>

                        </svg>

                        <span class="text-xs font-bold uppercase tracking-wider">
                            Pandu Tidak Ada di Pusat
                        </span>
                    </div>

                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($displayData->total_cabang_tidak_ada ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="text-[11px] text-slate-500 font-medium">
                        Data cabang tidak ditemukan di pusat
                    </div>
                </div>

                {{-- Card: Duplikat Pusat --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-blue-100 bg-blue-50/50">
                    <div class="flex items-center gap-2 text-blue-700">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">

                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>

                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>

                        </svg>

                        <span class="text-xs font-bold uppercase tracking-wider">
                            Duplikat Pusat
                        </span>
                    </div>

                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($displayData->total_duplikat_pusat ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="text-[11px] text-slate-500 font-medium">
                        Data ganda di pusat
                    </div>
                </div>

                {{-- Card: Duplikat Pandu --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-cyan-100 bg-cyan-50/50">
                    <div class="flex items-center gap-2 text-cyan-700">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">

                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>

                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>

                        </svg>

                        <span class="text-xs font-bold uppercase tracking-wider">
                            Duplikat Pandu
                        </span>
                    </div>

                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($displayData->total_duplikat_cabang ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="text-[11px] text-slate-500 font-medium">
                        Data ganda di cabang
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
            {{-- Header Utama Container --}}
            <div
                class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between bg-slate-50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#1A3A5C]/10 text-[#1A3A5C] flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                <div
                    class="text-[11px] text-slate-500 font-medium bg-white px-3 py-1.5 rounded-full border border-slate-200 shadow-sm mt-3 sm:mt-0">
                    Terakhir diupdate: <span
                        class="text-slate-700">{{ date('d M Y, H:i', strtotime($displayData->updated_at)) }}</span>
                </div>
            </div>

            {{-- Grid 4 Tabel --}}
            <div class="p-6 bg-slate-50/50">
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-6">

                    {{-- 1. Pandu Tidak Ada (Merah) --}}
                    <div
                        class="bg-white border border-red-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                        <div
                            class="px-4 py-3 bg-red-50/80 border-b border-red-100 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-1.5">
                                <svg class="text-red-500" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="15" y1="9" x2="9" y2="15" />
                                    <line x1="9" y1="9" x2="15" y2="15" />
                                </svg>
                                <span class="font-bold text-[12.5px] text-red-800">Pandu Tdk Ada</span>
                            </div>
                            <span
                                class="text-[10px] font-bold bg-white text-red-600 border border-red-200 px-2 py-0.5 rounded-full shadow-sm">
                                {{ number_format(count($cabangTidakAda), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse text-[12.5px]">
                                <tbody>
                                    @forelse ($cabangTidakAda as $item)
                                        <tr class="hover:bg-red-50/40 transition-colors">
                                            <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full"
                                                title="{{ $item->dataMakam->nama }}">
                                                {{ $item->dataMakam->nama }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- 2. Pusat Tidak Ada (Oranye) --}}
                    <div
                        class="bg-white border border-orange-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                        <div
                            class="px-4 py-3 bg-orange-50/80 border-b border-orange-100 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-1.5">
                                <svg class="text-orange-500" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                                <span class="font-bold text-[12.5px] text-orange-800">Pusat Tdk Ada</span>
                            </div>
                            <span
                                class="text-[10px] font-bold bg-white text-orange-600 border border-orange-200 px-2 py-0.5 rounded-full shadow-sm">
                                {{ number_format(count($pusatTidakAda), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse text-[12.5px]">
                                <tbody>
                                    @forelse ($pusatTidakAda as $item)
                                        <tr class="hover:bg-orange-50/40 transition-colors">
                                            <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full"
                                                title="{{ $item->dataMakam->nama }}">
                                                {{ $item->dataMakam->nama }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- 3. Tahun Beda (Kuning/Amber) --}}
                    <div
                        class="bg-white border border-amber-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                        <div
                            class="px-4 py-3 bg-amber-50/80 border-b border-amber-100 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-1.5">
                                <svg class="text-amber-500" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                <span class="font-bold text-[12.5px] text-amber-800">Tahun Beda</span>
                            </div>
                            <span
                                class="text-[10px] font-bold bg-white text-amber-600 border border-amber-200 px-2 py-0.5 rounded-full shadow-sm">
                                {{ number_format(count($tahunBeda), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse text-[12.5px]">
                                <tbody>
                                    @forelse ($tahunBeda as $item)
                                        <tr class="hover:bg-amber-50/40 transition-colors">
                                            <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full"
                                                title="{{ $item->dataMakam->nama }}">
                                                {{ $item->dataMakam->nama }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- 4. Match Full (Hijau) --}}
                    <div
                        class="bg-white border border-green-100 rounded-xl shadow-sm flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow">
                        <div
                            class="px-4 py-3 bg-green-50/80 border-b border-green-100 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-1.5">
                                <svg class="text-green-500" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span class="font-bold text-[12.5px] text-green-800">Match Full</span>
                            </div>
                            <span
                                class="text-[10px] font-bold bg-white text-green-600 border border-green-200 px-2 py-0.5 rounded-full shadow-sm">
                                {{ number_format(count($matchFull), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse text-[12.5px]">
                                <tbody>
                                    @forelse ($matchFull as $item)
                                        <tr class="hover:bg-green-50/40 transition-colors">
                                            <td class="px-4 py-3 border-b border-slate-100 text-slate-600 font-medium truncate max-w-[1px] w-full"
                                                title="{{ $item->dataMakam->nama }}">
                                                {{ $item->dataMakam->nama }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-10 text-center text-slate-400 text-xs">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- State jika belum ada data audit sama sekali di database --}}
        <div
            class="bg-white border border-slate-200 rounded-xl shadow-sm p-12 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-4">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-800">Belum ada data audit</h3>
            <p class="text-sm text-slate-500 mt-2 max-w-sm">Silakan lakukan proses unggah data pusat dan cabang
                pada menu
                Upload File untuk memulai audit.</p>
        </div>
        </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const form = document.querySelector('form');

            const auditBtn =
                document.getElementById('audit-btn');

            const auditText =
                document.getElementById('audit-text');

            const auditIcon =
                document.getElementById('audit-icon');

            const loadingIcon =
                document.getElementById('loading-icon');

            form.addEventListener('submit', () => {

                auditBtn.disabled = true;

                auditBtn.classList.add(
                    'opacity-80',
                    'cursor-not-allowed'
                );

                auditText.textContent =
                    'Sedang Generate Audit...';

                auditIcon.classList.add('hidden');

                loadingIcon.classList.remove('hidden');
            });
        });
    </script>
@endpush
