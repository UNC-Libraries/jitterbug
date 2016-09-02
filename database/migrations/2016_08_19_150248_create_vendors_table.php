<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('vendors', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 255);
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
    Schema::drop('vendors');
  }
}