<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertCallNumberIndexOnFormatsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('formats', function (Blueprint $table) {
      $table->dropUnique('name');
      $table->index('name', 'name');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('formats', function (Blueprint $table) {
      $table->dropIndex('name');
      $table->unique('name', 'name');
    });
  }
}
