@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="p-6">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-800">
            Edit User
        </h1>

        <p class="text-slate-500 text-sm">
            Perbarui data pengguna
        </p>

    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-3xl">

        <form method="POST"
              action="{{ route('users.update', $user->id) }}">

            @csrf
            @method('PUT')

            <div class="grid gap-5">

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full border rounded-lg px-4 py-2">

                    <small class="text-slate-500">
                        Kosongkan jika tidak ingin mengubah password
                    </small>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Role
                    </label>

                    <select
                        name="role"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="admin"
                            {{ $user->role == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="kepala_tpu"
                            {{ $user->role == 'kepala_tpu' ? 'selected' : '' }}>
                            Kepala TPU
                        </option>

                        <option value="kepala_uptd"
                            {{ $user->role == 'kepala_uptd' ? 'selected' : '' }}>
                            Kepala UPTD
                        </option>

                    </select>
                </div>

                <div>

                    <label class="block mb-2 text-sm font-medium">
                        TPU
                    </label>

                    <select
                        name="tpu_id"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">
                            Pilih TPU
                        </option>

                        @foreach($tpus as $tpu)

                            <option
                                value="{{ $tpu->id }}"
                                {{ $user->tpu_id == $tpu->id ? 'selected' : '' }}>

                                {{ $tpu->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('users.index') }}"
                        class="px-5 py-2 border rounded-lg">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="bg-[#1A3A5C] text-white px-5 py-2 rounded-lg">

                        Update User

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection