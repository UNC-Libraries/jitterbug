<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->integer('accession_number')->nullable()->after('collection_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->dropColumn('accession_number');
        });
    }
};
