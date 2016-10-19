<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTransfersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('video_transfers', function (Blueprint $table) {
      $table->increments('id');
      $table->string('time_base_corrector', 255)->nullable();
      $table->string('ad_converter', 255)->nullable();
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
    Schema::drop('video_transfers');
  }
}
