<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmMastersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('film_masters', function (Blueprint $table) {
      $table->increments('id');
      $table->string('file_format', 255)->nullable();
      $table->string('file_codec', 255)->nullable();
      $table->string('frame_size', 255)->nullable();
      $table->string('aspect_ratio', 255)->nullable();
      $table->timestamp('updated_at');
      $table->timestamp('created_at')->nullable();
    });
  }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('film_masters');
  }
}
