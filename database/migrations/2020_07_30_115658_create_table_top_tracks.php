<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTopTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top-tracks', function (Blueprint $table) {
            $table->primary('spotifyID');
            $table->string("spotifyID", 23);
            $table->string('name', 60);
            $table->string('artist', 60);
            $table->integer("counter")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top-tracks');
    }
}
