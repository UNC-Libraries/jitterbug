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
        Schema::create('revisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('revisionable_type', 255)->nullable()->index();
            $table->integer('revisionable_id')->nullable()->index();
            $table->string('ip_address')->nullable();
            $table->string('transaction_id', 255)->nullable()->index();
            $table->string('field')->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('audio_visual_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('call_number', 255);
            $table->text('title')->nullable();
            $table->string('recording_location', 255)->nullable();
            $table->string('item_year', 255)->nullable();
            $table->date('item_date')->nullable();
            $table->integer('collection_id')->nullable()->index();
            $table->text('container_note')->nullable();
            $table->text('condition_note')->nullable();
            $table->bigInteger('oclc')->nullable();
            $table->tinyInteger('format_id')->nullable()->index();
            $table->date('entry_date')->nullable();
            $table->string('speed', 255)->nullable();
            $table->string('subclass_type', 255)->nullable()->index();
            $table->integer('subclass_id')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('audio_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('call_number', 255);
            $table->boolean('listening_copy')->default(0)->nullable();
            $table->string('size', 255)->nullable();
            $table->string('track_configuration', 255)->nullable();
            $table->char('mono_stereo', 1)->nullable();
            $table->string('base', 255)->nullable();
            $table->text('content_description')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('video_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('call_number', 255);
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
            $table->increments('id');
            $table->string('call_number', 255);
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
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->string('prefix', 255);
            $table->string('legacy_prefix', 255)->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('collections', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('media_types', function (Blueprint $table) {
            $table->tinyInteger('id')->autoIncrement();
            $table->string('name', 255)->unique();
        });

        DB::table('media_types')->insert(['name' => 'Audio']);
        DB::table('media_types')->insert(['name' => 'Film']);
        DB::table('media_types')->insert(['name' => 'Video']);

        DB::statement('CREATE UNIQUE INDEX call_number ON audio_visual_items (call_number)');
        DB::statement('CREATE UNIQUE INDEX call_number ON audio_items (call_number)');
        DB::statement('CREATE UNIQUE INDEX call_number ON film_items (call_number)');
        DB::statement('CREATE UNIQUE INDEX call_number ON video_items (call_number)');
        DB::statement('CREATE UNIQUE INDEX name ON formats (name)');
        DB::statement('CREATE UNIQUE INDEX name ON collections (name)');
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
};
