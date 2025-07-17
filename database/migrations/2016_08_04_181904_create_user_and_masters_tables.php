<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preservation_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('call_number', 255)->nullable()->index();
            $table->string('checksum', 255)->nullable();
            $table->integer('project_id')->nullable();
            $table->smallInteger('reproduction_machine_id')->nullable();
            $table->smallInteger('department_id')->nullable();
            $table->integer('duration_in_seconds')->nullable();
            $table->string('file_name', 255)->nullable()->index();
            $table->string('file_location', 255)->nullable();
            $table->bigInteger('file_size_in_bytes')->nullable();
            $table->string('file_format', 255)->nullable();
            $table->string('file_codec', 255)->nullable();
            $table->string('access_file_location', 255)->nullable();
            $table->string('subclass_type', 255)->nullable();
            $table->integer('subclass_id')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('audio_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('tape_brand_id')->nullable();
            $table->smallInteger('pm_speed_id')->nullable();
            $table->smallInteger('sampling_rate_id')->nullable();
            $table->string('test_tones', 255)->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('username', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->boolean('admin')->default(0)->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->string('legacy_initials', 255)->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('reproduction_machines', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('tape_brands', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('pm_speeds', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sampling_rates', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('preservation_masters');
        Schema::drop('audio_masters');
        Schema::drop('projects');
        Schema::drop('users');
        Schema::drop('reproduction_machines');
        Schema::drop('tape_brands');
        Schema::drop('pm_speeds');
        Schema::drop('departments');
        Schema::drop('sampling_rates');
    }
};
