@extends('layouts.app')

@section('title', 'Monitoring TPU')

@section('content')

<div class="p-6">

    <div class="mb-6">

        <h1 class="text-2xl font-bold">
            Monitoring TPU
        </h1>

        <p class="text-slate-500">
            Ringkasan seluruh TPU
        </p>

    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="text-left px-4 py-3">
                        TPU
                    </th>

                    <th class="text-left px-4 py-3">
                        Data Makam
                    </th>

                    <th class="text-left px-4 py-3">
                        Match
                    </th>

                    <th class="text-left px-4 py-3">
                        Tahun Beda
                    </th>

                    <th class="text-left px-4 py-3">
                        Fuzzy
                    </th>

                    <th class="text-left px-4 py-3">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($tpus as $tpu)

                    @php

                        $audit =
                            $tpu->auditResults->first();

                    @endphp

                    <tr class="border-t">

                        <td class="px-4 py-3">
                            {{ $tpu->nama }}
                        </td>

                        <td class="px-4 py-3">
                            {{ number_format($tpu->data_makam_count) }}
                        </td>

                        <td class="px-4 py-3">
                            {{ number_format($audit->total_match ?? 0) }}
                        </td>

                        <td class="px-4 py-3">
                            {{ number_format($audit->total_tahun_beda ?? 0) }}
                        </td>

                        <td class="px-4 py-3">
                            {{ number_format($audit->total_fuzzy_match ?? 0) }}
                        </td>

                        <td class="px-4 py-3">

                            @if($audit)

                                <span class="text-green-600 font-medium">
                                    Sudah Audit
                                </span>

                            @else

                                <span class="text-red-600 font-medium">
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