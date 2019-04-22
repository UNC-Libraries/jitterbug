<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsPrefixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('formats_prefixes', function (Blueprint $table) {
        $table->smallInteger('format_id')->unsigned();
        $table->foreign('format_id')->references('id')->on('formats')->onDelete('cascade');

        $table->integer('prefix_id')->unsigned();
        $table->foreign('prefix_id')->references('id')->on('prefixes')->onDelete('cascade');
        $table->timestamps();
      });
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
