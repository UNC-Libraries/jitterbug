<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeletedAtToSamplingRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sampling_rates', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sampling_rates', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
