<?php

namespace App\Services;

class CleaningService
{
    public function cleanName($name)
    {
        return strtoupper(trim($name));
    }
}