<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignId('audit_result_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('data_makam_id')
                ->constrained('data_makams')
                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | MATCHING
            |--------------------------------------------------------------------------
            */

            // pasangan data
            $table->foreignId('matched_with')
                ->nullable()
                ->constrained('data_makams')
                ->onDelete('set null');

            /*
            |--------------------------------------------------------------------------
            | AUDIT STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'match_full',
                'tahun_beda',
                'fuzzy_match',
                'pusat_tidak_ada',
                'cabang_tidak_ada',
                'duplikat_pusat',
                'duplikat_cabang'
            ]);

            /*
            |--------------------------------------------------------------------------
            | NOTES
            |--------------------------------------------------------------------------
            */

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
