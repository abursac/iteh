<?php

use App\PlayerRank;
use Illuminate\Database\Seeder;

class PlayerRanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlayerRank::insert(['name' => 'IV']);
        PlayerRank::insert(['name' => 'III']);
        PlayerRank::insert(['name' => 'II']);
        PlayerRank::insert(['name' => 'I']);
        PlayerRank::insert(['name' => 'MK']);
        PlayerRank::insert(['name' => 'FM']);
        PlayerRank::insert(['name' => 'IM']);
        PlayerRank::insert(['name' => 'GM']);
    }
}
