<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditResult extends Model
{
    protected $fillable = [
        'tpu_id',
        'import_id',
        
        // 6 Kategori yang sesuai dengan Excel dan AuditService
        'total_match',
        'total_tahun_beda',
        'total_fuzzy_match',
        'total_pusat_tidak_ada',
        'total_cabang_tidak_ada',
        'total_duplikat_pusat',
        'total_duplikat_cabang',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function tpu()
    {
        return $this->belongsTo(Tpu::class);
    }

    public function import()
    {
        return $this->belongsTo(Import::class);
    }

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }
}