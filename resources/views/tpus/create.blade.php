@extends('layouts.app')

@section('title', 'Tambah TPU')

@section('content')

<div class="p-6">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-800">
            Tambah TPU
        </h1>

        <p class="text-slate-500 text-sm">
            Tambahkan TPU baru ke sistem
        </p>

    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">

        <form method="POST"
              action="{{ route('tpus.store') }}">

            @csrf

            <div class="grid gap-5">

                <div>

                    <label class="block mb-2 text-sm font-medium">
                        Nama TPU
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                </div>

                <div>

                    <label class="block mb-2 text-sm font-medium">
                        Kode TPU
                    </label>

                    <input
                        type="text"
                        name="kode"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('tpus.index') }}"
                        class="px-5 py-2 border rounded-lg">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="bg-[#1A3A5C] hover:bg-[#234a73] text-white px-5 py-2 rounded-lg">

                        Simpan TPU

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection