<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatPrefixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('format_prefix', function (Blueprint $table) {
        $table->integer('format_id')->unsigned()->nullable();
        $table->foreign('format_id')->references('id')
          ->on('formats')->onDelete('cascade');

        $table->integer('prefix_id')->unsigned()->nullable();
        $table->foreign('prefix_id')->references('id')
          ->on('prefixes')->onDelete('cascade');
        $table->timestamps();
      });

      Schema::table()
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('format_prefix');
    }
}
