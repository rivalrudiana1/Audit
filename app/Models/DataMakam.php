<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMakam extends Model
{

    protected $fillable = [

        'tpu_id',

        'import_id',

        'sumber',

        'nama',

        'tanggal_raw',

        'nama_clean',

        'tanggal_clean',

        'id_match',
    ];
    
    public function tpu()
    {
        return $this->belongsTo(Tpu::class);
    }

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
