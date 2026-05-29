<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuditService;
use App\Models\AuditResult;
use App\Models\DataMakam;
use App\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        $latestResult = AuditResult::latest()->first();

        $matchFull = collect();
        $tahunBeda = collect();
        $pusatTidakAda = collect();
        $cabangTidakAda = collect();

        if ($latestResult) {

            $matchFull = Audit::with('dataMakam')
                ->where('audit_result_id', $latestResult->id)
                ->where('status', 'match_full')
                ->get();

            $tahunBeda = Audit::with('dataMakam')
                ->where('audit_result_id', $latestResult->id)
                ->where('status', 'tahun_beda')
                ->get();

            $pusatTidakAda = Audit::with('dataMakam')
                ->where('audit_result_id', $latestResult->id)
                ->where('status', 'pusat_tidak_ada')
                ->get();

            $cabangTidakAda = Audit::with('dataMakam')
                ->where('audit_result_id', $latestResult->id)
                ->where('status', 'cabang_tidak_ada')
                ->get();
        }

        return view('audit.index', compact(
            'latestResult',
            'matchFull',
            'tahunBeda',
            'pusatTidakAda',
            'cabangTidakAda'
        ));
    }

    public function generate(Request $request, AuditService $auditService)
    {
        $tpuId = $request->input('tpu_id', 1); // 1 = Misalnya default untuk TPU Pandu

        // 1. CEK MASTER TPU: Pastikan TPU ada di database
        // (Abaikan jika kamu tidak membuat model Tpu, tapi disarankan ada)
        // $tpuExists = Tpu::where('id', $tpuId)->exists();
        // if (!$tpuExists) {
        //     return redirect('/upload')->with('error', 'TPU tidak ditemukan di database master.');
        // }

        // 2. CEK DATA MAKAM: Pastikan ada data yang bisa diaudit untuk TPU ini
        $hasDataPusat = DataMakam::where('tpu_id', $tpuId)->where('sumber', 'pusat')->exists();
        $hasDataCabang = DataMakam::where('tpu_id', $tpuId)->where('sumber', 'cabang')->exists();

        // Jika salah satu (atau dua-duanya) belum diunggah, arahkan ke form upload
        if (!$hasDataPusat || !$hasDataCabang) {
            return redirect('/upload')->with('error', 'Data makam belum lengkap! Pastikan Anda sudah mengunggah File Pusat (Dinas) dan File Cabang (TPU) sebelum melakukan sinkronisasi.');
        }

        // Jika data aman, jalankan service audit
        $result = $auditService->generate($tpuId);

        return redirect('/audit')->with([
            'success' => 'Sinkronisasi data makam Pusat dan TPU berhasil diselesaikan!',
            'result'  => $result
        ]);
    }
}
