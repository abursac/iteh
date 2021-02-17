<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string("name", 30);
            $table->string("surname", 30);
            $table->string("gender", 6);
            $table->unsignedSmallInteger('confirmed')->default(0);
            $table->date("birth_date");
            $table->unsignedSmallInteger("rating")->nullable();
            $table->binary('image')->nullable();
            $table->foreignId('arbiter_rank_id')->nullable()->constrained('arbiter_ranks')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('player_rank_id')->nullable()->constrained('player_ranks')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('players');
    }
}
