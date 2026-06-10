@extends('layouts.app')

@section('title', 'Kelola TPU')

@section('content')

<div class="p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Kelola TPU
            </h1>

            <p class="text-slate-500 text-sm">
                Daftar TPU yang terdaftar dalam sistem
            </p>
        </div>

        <a href="{{ route('tpus.create') }}"
            class="bg-[#1A3A5C] hover:bg-[#234a73] text-white px-4 py-2 rounded-lg">

            + Tambah TPU

        </a>

    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="text-left p-4">Nama TPU</th>

                    <th class="text-left p-4">Kode</th>

                    <th class="text-left p-4">Jumlah User</th>

                    <th class="text-left p-4">Data Makam</th>

                    <th class="text-center p-4">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($tpus as $tpu)

                    <tr class="border-t">

                        <td class="p-4">
                            {{ $tpu->nama }}
                        </td>

                        <td class="p-4">
                            {{ $tpu->kode }}
                        </td>

                        <td class="p-4">
                            {{ $tpu->users_count }}
                        </td>

                        <td class="p-4">
                            {{ number_format($tpu->data_makam_count) }}
                        </td>

                        <td class="p-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('tpus.edit', $tpu->id) }}"
                                    class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded">

                                    Edit

                                </a>

                                <form method="POST"
                                    action="{{ route('tpus.destroy', $tpu->id) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus TPU ini?')"
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-8 text-slate-500">

                            Belum ada data TPU

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">

        {{ $tpus->links() }}

    </div>

</div>

@endsection