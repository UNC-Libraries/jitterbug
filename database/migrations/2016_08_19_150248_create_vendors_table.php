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
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->nullable();
        });

        \DB::table('vendors')->insert(
            [
                'name' => 'George Blood',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('vendors');
    }
};
