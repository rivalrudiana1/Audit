<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [

        'audit_result_id',

        'data_makam_id',

        'matched_with',

        'similarity_score',

        'levenshtein_distance',

        'status',

        'keterangan',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function auditResult()
    {
        return $this->belongsTo(AuditResult::class);
    }

    public function dataMakam()
    {
        return $this->belongsTo(DataMakam::class);
    }

    public function matchedData()
    {
        return $this->belongsTo(
            DataMakam::class,
            'matched_with'
        );
    }
}