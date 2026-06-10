<?php

namespace App\Http\Controllers;

use App\Imports\DataMakamImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Import;
use Illuminate\Support\Facades\Auth;
use App\Models\Tpu;

class UploadController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $tpus = Tpu::all();
        } else {
            $user = Auth::user();
            $tpus = Tpu::where('id', $user->tpu_id)->get();
        }

return view(
    'upload.index',
    compact('tpus')
);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            $tpuId = $request->tpu_id;
        } else {
            $tpuId = $user->tpu_id;
        }

        /*
    |--------------------------------------------------------------------------
    | IMPORT PUSAT
    |--------------------------------------------------------------------------
    */

        $importPusat = Import::create([

            'tpu_id' => $tpuId,

            'sumber' => 'pusat',

            'filename' =>
            $request
                ->file('file_pusat')
                ->getClientOriginalName(),
        ]);

        Excel::import(

            new DataMakamImport(

                $tpuId,

                $importPusat->id,

                'pusat'
            ),

            $request->file('file_pusat')
        );

        /*
    |--------------------------------------------------------------------------
    | IMPORT CABANG
    |--------------------------------------------------------------------------
    */

        $importCabang = Import::create([

            'tpu_id' => $tpuId,

            'sumber' => 'cabang',

            'filename' =>
            $request
                ->file('file_cabang')
                ->getClientOriginalName(),
        ]);

        Excel::import(

            new DataMakamImport(

                $tpuId,

                $importCabang->id,

                'cabang'
            ),

            $request->file('file_cabang')
        );

        return redirect('/upload')
            ->with(
                'success',
                'File berhasil diupload dan audit berhasil dibuat.'
            );
    }
}
