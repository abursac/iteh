<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubTournament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_tournament', function (Blueprint $table) {
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('time');
            $table->primary(['club_id', 'tournament_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_tournament');
    }
}
