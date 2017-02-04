<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtToPmSpeedsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pm_speeds', function (Blueprint $table) {
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
    Schema::table('pm_speeds', function (Blueprint $table) {
      $table->dropColumn('deleted_at');
    });
  }
}
