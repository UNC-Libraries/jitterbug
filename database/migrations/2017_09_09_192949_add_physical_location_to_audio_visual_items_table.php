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
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->string('physical_location')->nullable()->after('recording_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->dropColumn('physical_location');
        });
    }
};
