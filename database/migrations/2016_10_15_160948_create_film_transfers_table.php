<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmTransfersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('film_transfers', function (Blueprint $table) {
      $table->increments('id');
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
    Schema::drop('film_transfers');
  }
}
