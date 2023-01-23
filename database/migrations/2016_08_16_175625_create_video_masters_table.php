<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('frame_size', 255)->nullable();
            $table->string('aspect_ratio', 255)->nullable();
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
        Schema::drop('video_masters');
    }
};
