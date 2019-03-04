<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallNumberSequenceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('new_call_number_sequences', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('prefix', 255)->nullable();
        $table->integer('collection_id')->nullable();
        $table->integer('next')->nullable();
        $table->string('reserved')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->index(array('prefix', 'collection_id'));
      });

      Schema::create('legacy_number_sequences', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('prefix', 255)->nullable();
        $table->integer('next')->nullable();
        $table->string('reserved')->nullable();
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
      Schema::drop('new_call_number_sequences');
      Schema::drop('legacy_call_number_sequences');
    }
}
