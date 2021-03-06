<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertCallNumberIndexOnFilmItemsTable extends Migration
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
}
