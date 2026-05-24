<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [

        'tpu_id',

        'sumber',

        'filename',

        'total_data',
    ];
    public function dataMakam()
    {
        return $this->hasMany(DataMakam::class);
    }
}
