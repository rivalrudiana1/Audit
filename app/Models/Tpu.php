<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tpu extends Model
{
    protected $fillable = [
        'nama',
        'kode',
    ];

    public function dataMakam()
    {
        return $this->hasMany(DataMakam::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function auditResults()
    {
        return $this->hasMany(
            AuditResult::class
        );
    }
}