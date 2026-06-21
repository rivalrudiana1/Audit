@extends('layouts.app')

@section('title', 'Monitoring TPU')

@section('content')

<div class="p-6">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-slate-800">
            Monitoring TPU
        </h1>

        <p class="text-slate-500 mt-1">
            Ringkasan hasil sinkronisasi seluruh TPU
        </p>

    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-5 py-3 text-left">
                        TPU
                    </th>

                    <th class="px-5 py-3 text-left">
                        Data Makam
                    </th>

                    <th class="px-5 py-3 text-left">
                        Match Full
                    </th>

                    <th class="px-5 py-3 text-left">
                        Tahun Beda
                    </th>

                    <th class="px-5 py-3 text-left">
                        Fuzzy Match
                    </th>

                    <th class="px-5 py-3 text-left">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($tpus as $tpu)

                    @php
                        $audit = $tpu->auditResults->first();
                    @endphp

                    <tr class="border-t hover:bg-slate-50">

                        <td class="px-5 py-4 font-medium">
                            {{ $tpu->nama }}
                        </td>

                        <td class="px-5 py-4">
                            {{ number_format($tpu->data_makam_count) }}
                        </td>

                        <td class="px-5 py-4 text-green-600 font-semibold">
                            {{ number_format($audit->total_match ?? 0) }}
                        </td>

                        <td class="px-5 py-4 text-yellow-600 font-semibold">
                            {{ number_format($audit->total_tahun_beda ?? 0) }}
                        </td>

                        <td class="px-5 py-4 text-purple-600 font-semibold">
                            {{ number_format($audit->total_fuzzy_match ?? 0) }}
                        </td>

                        <td class="px-5 py-4">

                            @if($audit)

                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">

                                    Sudah Audit

                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">

                                    Belum Audit

                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection