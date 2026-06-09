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
        Schema::table('audits', function (Blueprint $table) {

    $table->decimal('similarity_score', 5, 2)
            ->nullable()
            ->after('matched_with');

    $table->integer('levenshtein_distance')
            ->nullable()
            ->after('similarity_score');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn(['similarity_score', 'levenshtein_distance']);
        });
    }
};
