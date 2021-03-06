<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegacyToAudioVisualItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('audio_visual_items', function (Blueprint $table) {
      $table->string('legacy')->nullable()->after('accession_number');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('audio_visual_items', function (Blueprint $table) {
      $table->dropColumn('legacy');
    });
  }
}
