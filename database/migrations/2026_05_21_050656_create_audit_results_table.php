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
        Schema::create('audit_results', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignId('tpu_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('import_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            /*
            |--------------------------------------------------------------------------
            | SUMMARY
            |--------------------------------------------------------------------------
            */
            $table->integer('total_match')
                ->default(0);
            $table->integer('total_tahun_beda')
                ->default(0);
            $table->integer('total_pusat_tidak_ada')
                ->default(0);
            $table->integer('total_cabang_tidak_ada')
                ->default(0);
            $table->integer('total_duplikat_pusat')
                ->default(0);
            $table->integer('total_duplikat_cabang')
                ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_results');
    }
};
