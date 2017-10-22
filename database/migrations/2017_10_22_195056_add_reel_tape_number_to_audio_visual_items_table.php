<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReelTapeNumberToAudioVisualItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('audio_visual_items', function (Blueprint $table) {
      $table->string('reel_tape_number')->nullable()->after('format_id');
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
      $table->dropColumn('reel_tape_number');
    });
  }
}
