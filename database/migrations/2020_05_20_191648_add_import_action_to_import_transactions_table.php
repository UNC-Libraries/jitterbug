<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('import_transactions', function (Blueprint $table) {
            $table->string('import_action', 255)->default('create')->after('import_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('import_transactions', function (Blueprint $table) {
            $table->dropColumn('import_action');
        });
    }
};
