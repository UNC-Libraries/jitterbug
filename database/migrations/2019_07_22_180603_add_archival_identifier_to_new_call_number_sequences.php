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
        Schema::table('new_call_number_sequences', function (Blueprint $table) {
            $table->string('archival_identifier')->after('collection_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('new_call_number_sequences', function (Blueprint $table) {
            $table->dropColumn('archival_identifier');
        });
    }
};
