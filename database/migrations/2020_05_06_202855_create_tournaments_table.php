<?php

use App\Tournament;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->date("start_date");
            $table->date("end_date");
            $table->time("time");
            $table->string("place", 100);
            $table->string("phone", 20);
            $table->string("email", 50);
            $table->unsignedSmallInteger("rounds");
            $table->string("type", 20);
            $table->integer("playersPerClub")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
