<?php

namespace App\Services;

use App\Models\DataMakam;
use App\Models\Audit;
use App\Models\AuditResult;

class AuditService
{
    public function generate($tpuId)
    {
        /*
        |--------------------------------------------------------------------------
        | RESET AUDIT
        |--------------------------------------------------------------------------
        */
        Audit::query()->delete();
        AuditResult::query()->delete();

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */
        $pusat = DataMakam::where('tpu_id', $tpuId)->where('sumber', 'pusat')->get();
        $cabang = DataMakam::where('tpu_id', $tpuId)->where('sumber', 'cabang')->get();

        /*
        |--------------------------------------------------------------------------
        | HELPER: NORMALISASI TEKS (Seperti fitur di Excel)
        |--------------------------------------------------------------------------
        | Mengubah teks jadi huruf besar semua & menghapus spasi gaib di ujung kata
        */
        $normalize = function ($str) {
            return strtoupper(trim((string)$str));
        };

        /*
        |--------------------------------------------------------------------------
        | TAHAP 1: HITUNG FREKUENSI (MENDETEKSI DUPLIKAT SEPERTI COUNTIF EXCEL)
        |--------------------------------------------------------------------------
        */
        $freqPusat = [];
        foreach ($pusat as $p) {
            $idM = $normalize($p->id_match);
            if (!isset($freqPusat[$idM])) $freqPusat[$idM] = 0;
            $freqPusat[$idM]++;
        }

        $freqCabang = [];
        foreach ($cabang as $c) {
            $idM = $normalize($c->id_match);
            if (!isset($freqCabang[$idM])) $freqCabang[$idM] = 0;
            $freqCabang[$idM]++;
        }

        /*
        |--------------------------------------------------------------------------
        | TAHAP 2: PISAHKAN DUPLIKAT & BUAT KAMUS DATA (VLOOKUP PREPARATION)
        |--------------------------------------------------------------------------
        */
        $pusatUnik = [];
        $cabangUnik = [];
        $cabangDictById = [];
        $cabangDictByNama = [];

        $totalDuplikatPusat = 0;
        $totalDuplikatCabang = 0;

        $auditRows = [];
        $now = now();

        // Menyaring Data Pusat
        foreach ($pusat as $p) {
            $idM = $normalize($p->id_match);
            if ($freqPusat[$idM] > 1) {

                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $p->id,
                    'status'          => 'duplikat_pusat',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];

                $totalDuplikatPusat++;
            }

            /*
|--------------------------------------------------------------------------
| TETAP MASUK KE PROSES MATCHING
|--------------------------------------------------------------------------
*/

            $pusatUnik[] = $p;
        }

        // Menyaring Data Cabang (Pandu)
        foreach ($cabang as $c) {

            $idM = $normalize($c->id_match);
            $nama = $normalize($c->nama_clean);

            if ($freqCabang[$idM] > 1) {

                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $c->id,
                    'status'          => 'duplikat_cabang',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];

                $totalDuplikatCabang++;
            }

            /*
    |--------------------------------------------------------------------------
    | TETAP MASUK KE PROSES MATCHING
    |--------------------------------------------------------------------------
    */

            $cabangUnik[] = $c;

            // Dictionary berdasarkan ID MATCH
            if (!isset($cabangDictById[$idM])) {
                $cabangDictById[$idM] = [];
            }

            $cabangDictById[$idM][] = $c;

            // Dictionary berdasarkan NAMA
            if (!isset($cabangDictByNama[$nama])) {
                $cabangDictByNama[$nama] = [];
            }

            $cabangDictByNama[$nama][] = $c;
        }

        /*
        |--------------------------------------------------------------------------
        | TAHAP 3: REKONSILIASI PUSAT VS CABANG (PROSES MATCHING)
        |--------------------------------------------------------------------------
        */
        $totalMatch = 0;
        $totalTahunBeda = 0;
        $totalPusatTidakAda = 0;
        $totalCabangTidakAda = 0;

        $cabangUsedIds = []; // Mencatat data cabang mana saja yang sudah dapat pasangan

        foreach ($pusatUnik as $p) {
            $idM = $normalize($p->id_match);
            $nama = $normalize($p->nama_clean);

            // Cek 1: MATCH FULL (id_match sama persis)
            if (!empty($cabangDictById[$idM])) {

                $cMatch = array_shift(
                    $cabangDictById[$idM]
                );

                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $p->id,
                    'status'          => 'match_full',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];

                $totalMatch++;

                $cabangUsedIds[$cMatch->id] = true;

                // Hapus dari kamus nama agar tidak diklaim lagi oleh Tahun Beda
                if (isset($cabangDictByNama[$nama])) {

                    foreach ($cabangDictByNama[$nama] as $idx => $cItem) {

                        if ($cItem->id === $cMatch->id) {

                            unset($cabangDictByNama[$nama][$idx]);

                            break;
                        }
                    }
                }
            }
            // Cek 2: TAHUN BEDA (id_match beda, tapi nama_clean ada)
            elseif (!empty($cabangDictByNama[$nama])) {
                // Ambil satu data cabang yang namanya sama
                $cMatch = array_shift($cabangDictByNama[$nama]);

                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $p->id,
                    'status'          => 'tahun_beda',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
                $totalTahunBeda++;
                $cabangUsedIds[$cMatch->id] = true;
            }
            // Cek 3: PUSAT TIDAK ADA DI CABANG
            else {
                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $p->id,
                    'status'          => 'pusat_tidak_ada',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
                $totalPusatTidakAda++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | TAHAP 4: CABANG TIDAK ADA DI PUSAT
        |--------------------------------------------------------------------------
        | Sisa data cabang unik yang tidak pernah mendapat pasangan dari tahap 3
        */
        foreach ($cabangUnik as $c) {
            if (!isset($cabangUsedIds[$c->id])) {
                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $c->id,
                    'status'          => 'cabang_tidak_ada',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
                $totalCabangTidakAda++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE RESULT & BULK INSERT
        |--------------------------------------------------------------------------
        */
        $auditResult = AuditResult::create([
            'tpu_id'                 => $tpuId,
            'total_match'            => $totalMatch,
            'total_tahun_beda'       => $totalTahunBeda,
            'total_pusat_tidak_ada'  => $totalPusatTidakAda,
            'total_cabang_tidak_ada' => $totalCabangTidakAda,
            'total_duplikat_pusat'   => $totalDuplikatPusat,
            'total_duplikat_cabang'  => $totalDuplikatCabang,
        ]);

        // Sisipkan ID AuditResult ke dalam array sebelum di-insert
        foreach ($auditRows as &$row) {
            $row['audit_result_id'] = $auditResult->id;
        }

        // Bulk insert dengan chunk untuk mencegah kehabisan memory PHP
        foreach (array_chunk($auditRows, 1000) as $chunk) {
            Audit::insert($chunk);
        }

        return $auditResult;
    }
}
