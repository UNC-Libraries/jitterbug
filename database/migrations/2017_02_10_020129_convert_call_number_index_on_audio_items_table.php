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
        Schema::table('audio_items', function (Blueprint $table) {
            $table->dropUnique('call_number');
            $table->index('call_number', 'call_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audio_items', function (Blueprint $table) {
            $table->dropIndex('call_number');
            $table->unique('call_number', 'call_number');
        });
    }
};
