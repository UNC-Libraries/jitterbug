<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('prefixes', function (Blueprint $table) {
        $table->increments('id');
        $table->string('label');
        $table->boolean('legacy')->default(0);
        $table->integer('collection_type_id')->nullable()->unsigned()->index();
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('prefixes');
    }
}
