<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArchivalIdentifierToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('collections', function (Blueprint $table) {
        $table->string('archival_identifier')->after('collection_type_id')->unique()->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('collections', function (Blueprint $table) {
        $table->dropColumn('archival_identifier');
      });
    }
}
