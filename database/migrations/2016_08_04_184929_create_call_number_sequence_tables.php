<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_call_number_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix', 255)->nullable()->index();
            $table->integer('collection_id')->nullable()->index();
            $table->integer('next')->nullable();
            $table->string('reserved', 255)->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('legacy_call_number_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix', 255)->nullable();
            $table->integer('next')->nullable();
            $table->string('reserved', 255)->nullable();
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
};
