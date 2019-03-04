<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('playback_machines', function (Blueprint $table) {
        $table->smallIncrements('id')->primary();
        $table->string('name', 255);
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
      });

      Schema::create('cuts', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('call_number', 255);
        $table->smallInteger('cut_number')->nullable();
        $table->integer('transfer_id');
        $table->string('side', 255)->nullable();
        $table->string('performer_composer', 510)->nullable();
        $table->string('title', 255)->nullable();
        $table->string('pm_start_time', 255)->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
        $table->index(array('call_number', 'transfer_id'));
      });

      Schema::create('transfers', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->integer('preservation_master_id');
        $table->string('call_number', 255);
        $table->date('transfer_date')->nullable();
        $table->smallInteger('playback_machine_id')->nullable();
        $table->smallInteger('engineer_id')->nullable();
        $table->smallInteger('vendor_id')->nullable();
        $table->text('condition_note')->nullable();
        $table->text('transfer_note')->nullable();
        $table->string('subclass_type', 255)->nullable();
        $table->integer('subclass_id')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
        $table->index('call_number');
      });

      Schema::create('audio_transfers', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('stylus', 255)->nullable();
        $table->string('cartridge', 255)->nullable();
        $table->text('first_sound')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
        $table->index('call_number');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('playback_machines');
      Schema::drop('cuts');
      Schema::drop('transfers');
      Schema::drop('audio_transfers');
    }
}
