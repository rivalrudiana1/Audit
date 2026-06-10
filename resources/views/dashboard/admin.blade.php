@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">

        Dashboard Admin

    </h1>

    <div class="grid grid-cols-4 gap-5">

        <div class="bg-white rounded-xl shadow-sm p-5">

            <h3>Total User</h3>

            <div class="text-3xl font-bold">

                {{ number_format($totalUser) }}

            </div>

        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">

            <h3>Total TPU</h3>

            <div class="text-3xl font-bold">

                {{ number_format($totalTpu) }}

            </div>

        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">

            <h3>Data Makam</h3>

            <div class="text-3xl font-bold">

                {{ number_format($totalMakam) }}

            </div>

        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">

            <h3>Audit</h3>

            <div class="text-3xl font-bold">

                {{ number_format($totalAudit) }}

            </div>

        </div>

    </div>

</div>

@endsection