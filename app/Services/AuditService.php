<?php

namespace App\Services;

use App\Models\DataMakam;
use App\Models\Audit;
use App\Models\AuditResult;

class AuditService
{
    public function generate(int $tpuId)
    {
        /*
        |--------------------------------------------------------------------------
        | RESET AUDIT
        |--------------------------------------------------------------------------
        */
        $oldResults = AuditResult::where(
            'tpu_id',
            $tpuId
        )->pluck('id');

        Audit::whereIn(
            'audit_result_id',
            $oldResults
        )->delete();

        AuditResult::where(
            'tpu_id',
            $tpuId
        )->delete();

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

        $fuzzySimilarity = function ($a, $b) {
            similar_text(
                strtoupper(trim($a)),
                strtoupper(trim($b)),
                $percent
            );
        
            return round($percent, 2);
        };
        
        $levenshteinDistance = function ($a, $b) {
            return levenshtein(
                strtoupper(trim($a)),
                strtoupper(trim($b))
            );
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
                    'matched_with' => null,
                    'similarity_score' => null,
                    'levenshtein_distance' => null,
                    'status'          => 'duplikat_pusat',
                    'keterangan' => null,
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
                    'matched_with' => null,
                    'similarity_score' => null,
                    'levenshtein_distance' => null,
                    'status'          => 'duplikat_cabang',
                    'keterangan' => null,
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
        $totalFuzzyMatch = 0;
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
                    'matched_with'    => $cMatch->id,
                    'similarity_score' => 100,
                    'levenshtein_distance' => 0,
                    'status'          => 'match_full',
                    'keterangan' => 'ID Match sama',
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
                    'matched_with'    => $cMatch->id,
                    'similarity_score' => 100,
                    'levenshtein_distance' => 0,
                    'status'          => 'tahun_beda',
                    'keterangan' => 'Nama sama, tahun berbeda',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
                $totalTahunBeda++;
                $cabangUsedIds[$cMatch->id] = true;
            }
            // Cek 3: PUSAT TIDAK ADA DI CABANG
            else {
                $bestMatch = null;
                $bestSimilarity = 0;
                $bestDistance = PHP_INT_MAX;
            
                foreach ($cabangUnik as $candidate) {
                    if (isset($cabangUsedIds[$candidate->id])) {
                        continue;
                    }
                    
                    $candidateName = $normalize(
                        $candidate->nama_clean
                    );
                    
                    $similarity = $fuzzySimilarity(
                        $nama,
                        $candidateName
                    );

                    $distance = $levenshteinDistance(
                        $nama,
                        $candidateName
                    );
                    
                    if ($similarity > $bestSimilarity) {
                        $bestSimilarity = $similarity;
                        $bestDistance = $distance;
                        $bestMatch = $candidate;
                    }
                }

        /*
        |--------------------------------------------------------------------------
        | FUZZY MATCH
        |--------------------------------------------------------------------------
        */
        
        if (
            $bestSimilarity >= 90
            && $bestDistance <= 3
        )   {
                $auditRows[] = [
                    'audit_result_id' => 0,
                    'data_makam_id'   => $p->id,
                    'matched_with'    => $bestMatch->id,
                    'similarity_score' => $bestSimilarity,
                    'levenshtein_distance' => $bestDistance,
                    'status'          => 'fuzzy_match',
                    'keterangan' => null,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
        
                $totalFuzzyMatch++;
            
                $cabangUsedIds[$bestMatch->id] = true;
                
                continue;
            }

        /*
        |--------------------------------------------------------------------------
        | TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        $auditRows[] = [
            'audit_result_id' => 0,
            'data_makam_id'   => $p->id,
            'matched_with'    => null,
            'similarity_score' => null,
            'levenshtein_distance' => null,
            'status'          => 'pusat_tidak_ada',
            'keterangan' => null,
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
                    'matched_with'    => null,
                    'similarity_score' => null,
                    'levenshtein_distance' => null,
                    'status'          => 'cabang_tidak_ada',
                    'keterangan' => null,
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
            'total_fuzzy_match'      => $totalFuzzyMatch,
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
