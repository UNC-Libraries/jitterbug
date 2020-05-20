<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImportActionToImportTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
    public function down()
    {
        Schema::table('import_transactions', function (Blueprint $table) {
          $table->dropColumn('import_action');
        });
    }
}
