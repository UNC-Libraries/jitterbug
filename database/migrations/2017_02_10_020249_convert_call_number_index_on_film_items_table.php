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
        Schema::table('film_items', function (Blueprint $table) {
            $table->dropUnique('call_number');
            $table->index('call_number', 'call_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('film_items', function (Blueprint $table) {
            $table->dropIndex('call_number');
            $table->unique('call_number', 'call_number');
        });
    }
};
