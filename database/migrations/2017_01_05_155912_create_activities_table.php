<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->string('action');
            $table->tinyInteger('batch');
            $table->integer('batch_size')->nullable();
            $table->string('field')->nullable();
            $table->string('import_type')->nullable();
            $table->string('item_call_number')->nullable();
            $table->string('item_type')->nullable();
            $table->tinyInteger('num_fields')->nullable();
            $table->integer('num_affected');
            $table->text('object_types_to_ids');
            $table->timestamp('timestamp');
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('activities');
    }
};
