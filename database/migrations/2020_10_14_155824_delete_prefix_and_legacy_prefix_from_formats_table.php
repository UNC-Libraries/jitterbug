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
        Schema::table('formats', function (Blueprint $table) {
            $table->dropColumn(['prefix', 'legacy_prefix']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formats', function (Blueprint $table) {
            $table->string('prefix', 255);
            $table->string('legacy_prefix', 255)->nullable();
        });
    }
};
