<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->string('legacy')->nullable()->after('accession_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->dropColumn('legacy');
        });
    }
};
