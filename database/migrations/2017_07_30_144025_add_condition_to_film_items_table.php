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
        Schema::table('film_items', function (Blueprint $table) {
            $table->string('condition')->nullable()->after('shrinkage_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('film_items', function (Blueprint $table) {
            $table->dropColumn('condition');
        });
    }
};
