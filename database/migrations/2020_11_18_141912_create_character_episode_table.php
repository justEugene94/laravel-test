<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_episode', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('character_id');
            $table->unsignedInteger('episode_id');

            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('episode_id')->references('id')->on('episodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_episode');
    }
}
