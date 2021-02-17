<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerClubRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_club_request', function (Blueprint $table) {
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('club')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('status',['sent', 'accepted','declined'])->default('sent');
            $table->primary(['player_id', 'club_id','club','status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_club_request');
    }
}
