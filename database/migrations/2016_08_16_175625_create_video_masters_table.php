<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoMastersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('video_masters', function (Blueprint $table) {
      $table->increments('id');
      $table->string('frame_size', 255)->nullable();
      $table->string('aspect_ratio', 255)->nullable();
      $table->timestamp('updated_at');
      $table->timestamp('created_at')->nullable();
      $table->timestamp('deleted_at')->nullable();
    });
  }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('video_masters');
  }
}
