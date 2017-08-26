<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessRestrictionsToAudioVisualItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('audio_visual_items', function (Blueprint $table) {
      $table->string('access_restrictions')->nullable()->after('recording_location');
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
      $table->dropColumn('access_restrictions');
    });
  }
}
