<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('white_id')->constrained('clubs')->onDelete('no action')->onUpdate('no action');
            $table->foreignId('black_id')->constrained('clubs')->onDelete('no action')->onUpdate('no action');
            $table->float('white_result');
            $table->float('black_result');
            $table->integer('table');
            $table->integer('round');
            $table->foreignId('arbiter_id')->constrained('players')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_results');
    }
}
