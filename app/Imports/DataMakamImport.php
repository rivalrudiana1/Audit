<?php

namespace App\Imports;

use App\Models\DataMakam;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use PhpOffice\PhpSpreadsheet\Shared\Date;

class DataMakamImport implements
    ToModel,
    WithChunkReading,
    WithBatchInserts,
    WithHeadingRow
{
    protected $tpuId;

    protected $importId;

    protected $sumber;

    public function __construct(
        $tpuId,
        $importId,
        $sumber
    ) {
        $this->tpuId = $tpuId;

        $this->importId = $importId;

        $this->sumber = $sumber;
    }

    public function model(array $row)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA BERDASARKAN SUMBER
        |--------------------------------------------------------------------------
        */
        $nama =
        $row['nama']
        ?? $row['almarhum']
        ?? null;
        
        $tanggal =
        $row['tanggal_pemakaman']
        ?? $row['dimakamkan_tanggal']
        ?? null;
        /*
        |--------------------------------------------------------------------------
        | SKIP BARIS KOSONG
        |--------------------------------------------------------------------------
        */

        if (
            !$nama
            ||
            trim($nama) == ''
        ) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | CLEANING NAMA
        |--------------------------------------------------------------------------
        */

        $namaClean = strtoupper($nama);

        $namaClean = preg_replace(
            '/[^A-Z0-9 ]/',
            '',
            $namaClean
        );

        $namaClean = preg_replace(
            '/\s+/',
            ' ',
            $namaClean
        );

        $namaClean = trim($namaClean);

        if ($namaClean == '') {
            return null;
        }

        return new DataMakam([

            'tpu_id' =>
            $this->tpuId,

            'import_id' =>
            $this->importId,

            'sumber' =>
            $this->sumber,

            'nama' =>
            $nama,

            'tanggal_raw' =>
            $tanggal,

            'nama_clean' =>
            $namaClean,

            'id_match' =>
            $this->generateIdMatch(
                $namaClean,
                $tanggal
            ),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE ID MATCH
    |--------------------------------------------------------------------------
    */

    private function generateIdMatch(
        $nama,
        $tanggal
    ) {
        $year =
            $this->extractYear($tanggal);

        return $nama . '-' . $year;
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRACT YEAR
    |--------------------------------------------------------------------------
    */

    private function extractYear($tanggal)
    {
        /*
        |--------------------------------------------------------------------------
        | NULL / EMPTY
        |--------------------------------------------------------------------------
        */

        if (
            !$tanggal
            ||
            trim((string) $tanggal) == ''
        ) {
            return '0000';
        }

        /*
        |--------------------------------------------------------------------------
        | EXCEL SERIAL NUMBER
        |--------------------------------------------------------------------------
        */

        if (is_numeric($tanggal)) {
            try {
                return Date::excelToDateTimeObject(
                    $tanggal
                )->format('Y');
            } catch (\Exception $e) {
                return '0000';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CARI FORMAT 19xx / 20xx
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/(19|20)\d{2}/',
            $tanggal,
            $match
        );

        if (isset($match[0])) {
            return $match[0];
        }

        /*
        |--------------------------------------------------------------------------
        | CARI FORMAT '89 / '07
        |--------------------------------------------------------------------------
        */

        preg_match(
            "/'(\d{2})/",
            $tanggal,
            $shortYear
        );

        if (isset($shortYear[1])) {
            $year =
                (int) $shortYear[1];

            if ($year <= 30) {
                return '20' .
                    $shortYear[1];
            }

            return '19' .
                $shortYear[1];
        }

        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        return '0000';
    }

    /*
    |--------------------------------------------------------------------------
    | CHUNK
    |--------------------------------------------------------------------------
    */

    public function chunkSize(): int
    {
        return 1000;
    }

    /*
    |--------------------------------------------------------------------------
    | BATCH INSERT
    |--------------------------------------------------------------------------
    */

    public function batchSize(): int
    {
        return 1000;
    }
}
