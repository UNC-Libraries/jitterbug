<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConditionToFilmItemsTable extends Migration
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
}
