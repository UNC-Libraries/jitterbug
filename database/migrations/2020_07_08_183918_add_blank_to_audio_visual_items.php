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
    public function up()
    {
        Schema::table('audio_visual_items', function (Blueprint $table) {
            $table->boolean('blank')->default(0)->after('subclass_id');
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
            $table->dropColumn('blank');
        });
    }
};
