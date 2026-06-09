@extends('layouts.app')

@section('title', 'Dashboard')

@section('content') 

<form method="POST" action="{{ route('logout') }}">
    @csrf

    {{-- STATISTIC CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        {{-- Card 1 --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs text-slate-500 mb-1.5 flex items-center gap-1.5 font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                </svg>
                Total File
            </div>
            <div class="text-2xl font-bold text-slate-800">1,248</div>
            <div class="text-[11px] mt-1 font-medium text-green-600">↑ 12% vs bulan lalu</div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs text-slate-500 mb-1.5 flex items-center gap-1.5 font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Audit Selesai
            </div>
            <div class="text-2xl font-bold text-slate-800">984</div>
            <div class="text-[11px] mt-1 font-medium text-green-600">↑ 8% vs bulan lalu</div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs text-slate-500 mb-1.5 flex items-center gap-1.5 font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                Selisih Ditemukan
            </div>
            <div class="text-2xl font-bold text-slate-800">37</div>
            <div class="text-[11px] mt-1 font-medium text-red-500">↑ 3 dari bulan lalu</div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs text-slate-500 mb-1.5 flex items-center gap-1.5 font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                Menunggu Review
            </div>
            <div class="text-2xl font-bold text-slate-800">264</div>
            <div class="text-[11px] mt-1 font-medium text-amber-600">– tidak berubah</div>
        </div>
    </div>

    {{-- MIDDLE ROW: CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-5">

        {{-- Bar Chart Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <span class="font-semibold text-[13px] text-slate-800">Upload per TPU</span>
                <span class="text-[11px] px-2.5 py-0.5 rounded-full font-medium bg-blue-50 text-blue-700">Bulan ini</span>
            </div>
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3 text-xs">
                    <span class="w-16 text-slate-500 text-right shrink-0 text-[11px] font-medium">PANDU</span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-blue-600" style="width:88%"></div>
                    </div>
                    <span class="w-8 text-[11px] text-slate-500 text-right shrink-0 font-medium">88%</span>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="w-16 text-slate-500 text-right shrink-0 text-[11px] font-medium">SATRIA</span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-green-600" style="width:72%"></div>
                    </div>
                    <span class="w-8 text-[11px] text-slate-500 text-right shrink-0 font-medium">72%</span>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="w-16 text-slate-500 text-right shrink-0 text-[11px] font-medium">GARUDA</span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-amber-500" style="width:61%"></div>
                    </div>
                    <span class="w-8 text-[11px] text-slate-500 text-right shrink-0 font-medium">61%</span>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="w-16 text-slate-500 text-right shrink-0 text-[11px] font-medium">NUSANTARA</span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-red-600" style="width:44%"></div>
                    </div>
                    <span class="w-8 text-[11px] text-slate-500 text-right shrink-0 font-medium">44%</span>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="w-16 text-slate-500 text-right shrink-0 text-[11px] font-medium">CAKRA</span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-blue-600" style="width:55%"></div>
                    </div>
                    <span class="w-8 text-[11px] text-slate-500 text-right shrink-0 font-medium">55%</span>
                </div>
            </div>
        </div>

        {{-- Donut Chart Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <span class="font-semibold text-[13px] text-slate-800">Status audit</span>
                <span class="text-[11px] px-2.5 py-0.5 rounded-full font-medium bg-green-50 text-green-700">Live</span>
            </div>
            <div class="flex items-center gap-6 mt-2">
                <canvas id="donutCanvas" width="90" height="90" class="shrink-0"></canvas>
                <div class="flex flex-col gap-2.5 flex-1">
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600 shrink-0"></span><span>Selesai — 79%</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span><span>Review — 13%</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span><span>Selisih — 5%</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-200 shrink-0"></span><span>Pending — 3%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOTTOM ROW: TABLE --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <span class="font-semibold text-[13px] text-slate-800">Aktivitas audit terbaru</span>
            <span class="text-[11px] px-2.5 py-0.5 rounded-full font-medium bg-blue-50 text-blue-700">7 hari
                terakhir</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-[13px] whitespace-nowrap min-w-[600px]">
                <thead>
                    <tr>
                        <th class="text-slate-500 font-medium pb-3 border-b border-slate-200 w-28 text-xs">Tanggal</th>
                        <th class="text-slate-500 font-medium pb-3 border-b border-slate-200 w-24 text-xs">TPU</th>
                        <th class="text-slate-500 font-medium pb-3 border-b border-slate-200 text-xs">File</th>
                        <th class="text-slate-500 font-medium pb-3 border-b border-slate-200 w-24 text-xs">Status</th>
                        <th class="text-slate-500 font-medium pb-3 border-b border-slate-200 w-24 text-xs">Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3 border-b border-slate-100 text-slate-700">24 Mei 2026</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">PANDU</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">rekap_pusat_mei.xlsx</td>
                        <td class="py-3 border-b border-slate-100"><span
                                class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-green-50 text-green-700">Selesai</span>
                        </td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">Rp 0</td>
                    </tr>
                    <tr>
                        <td class="py-3 border-b border-slate-100 text-slate-700">24 Mei 2026</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">SATRIA</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">cabang_satria_q2.xlsx</td>
                        <td class="py-3 border-b border-slate-100"><span
                                class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700">Review</span>
                        </td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">Rp 1.2jt</td>
                    </tr>
                    <tr>
                        <td class="py-3 border-b border-slate-100 text-slate-700">23 Mei 2026</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">GARUDA</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">pusat_garuda_apr.csv</td>
                        <td class="py-3 border-b border-slate-100"><span
                                class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-red-50 text-red-700">Selisih</span>
                        </td>
                        <td class="py-3 border-b border-slate-100 text-slate-700 font-medium text-red-600">Rp 4.7jt</td>
                    </tr>
                    <tr>
                        <td class="py-3 border-b border-slate-100 text-slate-700">23 Mei 2026</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">NUSANTARA</td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">cabang_nusa_mei.xlsx</td>
                        <td class="py-3 border-b border-slate-100"><span
                                class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-green-50 text-green-700">Selesai</span>
                        </td>
                        <td class="py-3 border-b border-slate-100 text-slate-700">Rp 0</td>
                    </tr>
                    <tr>
                        <td class="py-3 text-slate-700">22 Mei 2026</td>
                        <td class="py-3 text-slate-700">CAKRA</td>
                        <td class="py-3 text-slate-700">rekap_cakra_mei.csv</td>
                        <td class="py-3"><span
                                class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700">Pending</span>
                        </td>
                        <td class="py-3 text-slate-500">—</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function drawDonut() {
            const c = document.getElementById('donutCanvas');
            if (!c) return;
            const ctx = c.getContext('2d');
            const cx = 45,
                cy = 45,
                r = 35,
                iR = 24,
                tw = Math.PI * 2;
            const slices = [{
                v: .79,
                col: '#2563EB'
            }, {
                v: .13,
                col: '#F59E0B' // Disesuaikan dengan warna amber tailwind
            }, {
                v: .05,
                col: '#DC2626' // Disesuaikan dengan warna red tailwind
            }, {
                v: .03,
                col: '#E2E8F0' // Disesuaikan dengan warna slate-200 tailwind
            }];
            let start = -Math.PI / 2;
            ctx.clearRect(0, 0, 90, 90);
            slices.forEach(s => {
                const end = start + s.v * tw;
                ctx.beginPath();
                ctx.moveTo(cx, cy);
                ctx.arc(cx, cy, r, start, end);
                ctx.closePath();
                ctx.fillStyle = s.col;
                ctx.fill();
                start = end;
            });
            ctx.beginPath();
            ctx.arc(cx, cy, iR, 0, tw);
            ctx.fillStyle = '#fff';
            ctx.fill();
            ctx.font = 'bold 12px system-ui';
            ctx.fillStyle = '#1e293b'; // slate-800
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('79%', cx, cy);
        }
        document.addEventListener('DOMContentLoaded', drawDonut);
    </script>
@endpush
