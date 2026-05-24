<?php

namespace App\Services;

class MatchingService
{
    public function generateIdMatch($nama, $tanggal)
    {
        if (!$tanggal)
        {
            return $nama;
        }

        return $nama . '-' . date(
            'Y',
            strtotime($tanggal)
        );
    }
}