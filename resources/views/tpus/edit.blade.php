@extends('layouts.app')

@section('title', 'Edit TPU')

@section('content')

<div class="p-6">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-800">
            Edit TPU
        </h1>

    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">

        <form method="POST"
              action="{{ route('tpus.update', $tpu->id) }}">

            @csrf
            @method('PUT')

            <div class="grid gap-5">

                <div>

                    <label class="block mb-2 text-sm font-medium">
                        Nama TPU
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ $tpu->nama }}"
                        class="w-full border rounded-lg px-4 py-2">

                </div>

                <div>

                    <label class="block mb-2 text-sm font-medium">
                        Kode TPU
                    </label>

                    <input
                        type="text"
                        name="kode"
                        value="{{ $tpu->kode }}"
                        class="w-full border rounded-lg px-4 py-2">

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('tpus.index') }}"
                        class="px-5 py-2 border rounded-lg">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="bg-[#1A3A5C] text-white px-5 py-2 rounded-lg">

                        Update TPU

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection