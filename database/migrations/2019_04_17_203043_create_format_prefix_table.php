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
    public function up(): void
    {
        Schema::create('format_prefix', function (Blueprint $table) {
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
    public function down(): void
    {
        Schema::dropIfExists('format_prefix');
    }
};
