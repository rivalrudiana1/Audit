<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tpu;
use App\Models\DataMakam;
use App\Models\AuditResult;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->guard()->user()->role;

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($role == 'admin') {

            return view(
                'dashboard.admin',
                [
                    'totalUser' =>
                        User::count(),

                    'totalTpu' =>
                        Tpu::count(),

                    'totalMakam' =>
                        DataMakam::count(),

                    'totalAudit' =>
                        AuditResult::count(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KEPALA TPU
        |--------------------------------------------------------------------------
        */

        if ($role == 'kepala_tpu')
        {
            $tpuId = auth()->guard()->user()->tpu_id;

            $totalMakam = DataMakam::where(
                'tpu_id',
                $tpuId
            )->count();

            return view(
                'dashboard.kepala_tpu',
                compact(
                    'totalMakam'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KEPALA UPTD
        |--------------------------------------------------------------------------
        */

        if ($role == 'kepala_uptd') {
            $tpus = Tpu::withCount([
                'dataMakam'
            ])
            ->with([
                'auditResults' => function ($query) {
                    $query->latest();
                }
            ])
            ->get();

            return view('dashboard.kepala_uptd', compact('tpus'));
        }
    }
}