<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'kepala_tpu',
                'kepala_uptd'
            ) NOT NULL DEFAULT 'kepala_tpu'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'user'
            ) NOT NULL DEFAULT 'user'
        ");
    }
};