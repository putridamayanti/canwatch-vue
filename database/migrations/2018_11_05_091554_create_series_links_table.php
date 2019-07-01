<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id');
            $table->string('link');
            $table->string('type')->default('link')->comment('link', 'playlist');
            $table->string('type_link')->default('dynamic')->comment('dynamic', 'absolute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_links');
    }
}
