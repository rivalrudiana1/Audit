@extends('layouts.app')

@section('title', 'Dashboard TPU')

@section('content')

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">

        Dashboard Kepala TPU

    </h1>

    <div class="bg-white rounded-xl shadow-sm p-6">

        <div class="text-slate-500 text-sm">

            TPU

        </div>

        <div class="text-xl font-semibold">

            {{ auth()->user()->tpu->nama ?? '-' }}

        </div>

        <div class="mt-5">

            Total Data Makam

        </div>

        <div class="text-3xl font-bold text-blue-700">

            {{ number_format($totalMakam) }}

        </div>

    </div>

</div>

@endsection