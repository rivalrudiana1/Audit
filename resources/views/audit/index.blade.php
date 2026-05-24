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
