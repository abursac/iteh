<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerTournament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_tournament', function (Blueprint $table) {
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('time');
            $table->primary(['player_id', 'tournament_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_tournament');
    }
}
