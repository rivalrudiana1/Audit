<?php

namespace App\Http\Controllers;

use App\Imports\DataMakamImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Import;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload.index');
    }

    public function store(Request $request)
    {
        $tpuId = $request->tpu_id;

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
