<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoPreservationMastersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('video_preservation_masters', function (Blueprint $table) {
      $table->increments('id');
      $table->string('file_format', 255)->nullable();
      $table->string('file_codec', 255)->nullable();
      $table->string('frame_size', 255)->nullable();
      $table->string('aspect_ratio', 255)->nullable();
      $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
    });
  }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('video_preservation_masters');
  }
}
