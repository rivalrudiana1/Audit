@php

    $nilaiMakam = 475000;

    $potensiPusat = $audit->total_pusat_tidak_ada * $nilaiMakam;

    $potensiCabang = $audit->total_cabang_tidak_ada * $nilaiMakam;

@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div class="bg-white rounded-xl shadow-sm p-5">

        <h3 class="font-semibold mb-2">
            Potensi Selisih Pusat
        </h3>

        <p class="text-sm text-slate-500">
            Data tidak ditemukan di Pandu
        </p>

        <p class="text-2xl font-bold text-red-600">
            Rp {{ number_format($potensiPusat, 0, ',', '.') }}
        </p>

    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">

        <h3 class="font-semibold mb-2">
            Potensi Selisih Pandu
        </h3>

        <p class="text-sm text-slate-500">
            Data tidak ditemukan di pusat
        </p>

        <p class="text-2xl font-bold text-red-600">
            Rp {{ number_format($potensiCabang, 0, ',', '.') }}
        </p>

    </div>

</div>
