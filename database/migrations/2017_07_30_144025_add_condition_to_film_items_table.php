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
            $table->string('condition')->nullable()->after('shrinkage_percent');
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
            $table->dropColumn('condition');
        });
    }
};
