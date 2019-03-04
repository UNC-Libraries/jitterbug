<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('revisions', function (Blueprint $table) {
        $table->bigIncrements('id')->primary();
        $table->string('revisionable_type', 255)->nullable();
        $table->integer('revisionable_id')->nullable();
        $table->string('ip_address')->nullable();
        $table->string('transaction_id', 255)->nullable();
        $table->string('field')->nullable();
        $table->text('old_value')->nullable();
        $table->text('new_value')->nullable();
        $table->integer('user_id')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->index(array('revisionable_id', 'revisionable_type', 'transaction_id'));
      });

      Schema::create('audio_visual_items', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('call_number', 255)->unique();
        $table->text('title')->nullable();
        $table->string('recording_location', 255)->nullable();
        $table->string('item_year', 255)->nullable();
        $table->date('item_date')->nullable();
        $table->integer('collection_id')->nullable();
        $table->text('container_note')->nullable();
        $table->text('condition_note')->nullable();
        $table->bigInteger('oclc')->nullable();
        $table->tinyInteger('format_id')->nullable();
        $table->date('entry_date')->nullable();
        $table->string('speed', 255)->nullable();
        $table->string('subclass_type', 255)->nullable();
        $table->integer('subclass_id')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
        $table->index(array('collection_id', 'format_id', 'subclass_type'));
      });

      Schema::create('audio_items', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('call_number', 255)->unique();
        $table->tinyInteger('listening_copy')->default(0)->nullable();
        $table->string('size', 255)->nullable();
        $table->string('track_configuration', 255)->nullable();
        $table->char('mono_stereo'. 1)->nullable();
        $table->string('base', 255)->nullable();
        $table->text('content_description')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
      });

      Schema::create('video_items', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('call_number', 255)->unique();
        $table->char('mono_stereo', 1)->nullable();
        $table->string('element', 255)->nullable();
        $table->string('color', 255)->nullable();
        $table->string('recording_standard', 255)->nullable();
        $table->text('content_description')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
      });

      Schema::create('film_items', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->string('call_number', 255)->unique();
        $table->integer('can_number')->nullable();
        $table->integer('length_in_feet')->nullable();
        $table->string('film_stock', 255)->nullable();
        $table->string('element', 255)->nullable();
        $table->string('color', 255)->nullable();
        $table->string('base', 255)->nullable();
        $table->string('sound_type', 255)->nullable();
        $table->string('edge_code', 255)->nullable();
        $table->string('shrinkage_percent', 8)->nullable();
        $table->text('content_description')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('deleted_at')->nullable();
      });

      Schema::create('formats', function (Blueprint $table) {
        $table->smallIncrements('id')->primary();
        $table->string('name', 255)->unique();
        $table->string('prefix');
        $table->string('legacy_prefix')->nullable();
        $table->timestamp('updated_at');
        $table->timestamp('created_at')->nullable();
      });

      Schema::create('collections', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('name', 255)->unique();
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
      Schema::drop('revisions');
      Schema::drop('audio_visual_items');
      Schema::drop('audio_items');
      Schema::drop('video_items');
      Schema::drop('film_items');
      Schema::drop('formats');
      Schema::drop('collections');
    }
}
