<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Tpu;

class TpuSeeder extends Seeder
{
    public function run(): void
    {
        Tpu::create([

            'nama' => 'PANDU',

            'kode' => 'PD'
        ]);

        Tpu::create([

            'nama' => 'CIKADUT',

            'kode' => 'CK'
        ]);

        Tpu::create([

            'nama' => 'NAGROG',

            'kode' => 'NG'
        ]);
    }
}