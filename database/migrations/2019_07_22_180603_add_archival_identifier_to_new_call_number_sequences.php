<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArchivalIdentifierToNewCallNumberSequences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
    public function down()
    {
      Schema::table('new_call_number_sequences', function (Blueprint $table) {
        $table->dropColumn('archival_identifier');
      });
    }
}
