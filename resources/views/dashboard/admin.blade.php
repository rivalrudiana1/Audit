@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="p-6">

        <h1 class="text-3xl font-bold mb-6 text-slate-800">
            Dashboard Admin
        </h1>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
            {{-- Header Card Dashboard --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="font-semibold text-slate-700 text-sm">Ringkasan Sistem Keseluruhan</div>
                <div class="text-xs text-slate-500 font-medium">Real-time update</div>
            </div>

            {{-- Grid Pertama (4 Kolom) --}}
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card: Total User --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-blue-100 bg-blue-50/50">
                    <div class="flex items-center gap-2 text-blue-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Total User</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalUser, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Pengguna terdaftar</div>
                </div>

                {{-- Card: Total TPU --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-green-100 bg-green-50/50">
                    <div class="flex items-center gap-2 text-green-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Total TPU</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalTpu, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Tempat Pemakaman Umum</div>
                </div>

                {{-- Card: Data Makam --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-amber-100 bg-amber-50/50">
                    <div class="flex items-center gap-2 text-amber-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Data Makam</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalMakam, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Keseluruhan entri makam</div>
                </div>

                {{-- Card: Total Audit --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-purple-100 bg-purple-50/50">
                    <div class="flex items-center gap-2 text-purple-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Total Audit</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalAudit, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Audit data selesai / berjalan</div>
                </div>

            </div>

            {{-- Grid Kedua (3 Kolom) --}}
            <div class="px-6 pb-6 grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Card: Data Pusat --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-cyan-100 bg-cyan-50/50">
                    <div class="flex items-center gap-2 text-cyan-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                            <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                            <line x1="6" y1="6" x2="6.01" y2="6"></line>
                            <line x1="6" y1="18" x2="6.01" y2="18"></line>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Data Pusat</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalPusat, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Arsip tersimpan di pusat</div>
                </div>

                {{-- Card: Data Cabang --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-indigo-100 bg-indigo-50/50">
                    <div class="flex items-center gap-2 text-indigo-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Data Cabang</span>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalCabang, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Arsip tersebar di cabang</div>
                </div>

                {{-- Card: Audit Terakhir --}}
                <div class="flex flex-col gap-2 p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Audit Terakhir</span>
                    </div>

                    @if ($auditTerakhir)
                        <div class="text-2xl font-extrabold text-slate-800 mt-1">
                            {{ $auditTerakhir->created_at->format('d M Y') }}
                        </div>
                        <div class="text-[11px] text-slate-500 font-medium">
                            Pukul {{ $auditTerakhir->created_at->format('H:i') }} WIB
                        </div>
                    @else
                        <div class="text-2xl font-extrabold text-slate-400 mt-1 italic">
                            Belum Ada
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">
                            Sistem belum memproses audit
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>

@endsection