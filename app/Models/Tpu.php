<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tpu extends Model
{
    public function dataMakam()
    {
        return $this->hasMany(DataMakam::class);
    }
}
