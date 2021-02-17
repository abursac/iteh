<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArbiterTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbiter_tournament', function (Blueprint $table) {
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('arbiter_id')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['tournament_id', 'arbiter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arbiter_tournament');
    }
}
