<?php

use App\ArbiterRank;
use Illuminate\Database\Seeder;

class ArbiterRanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArbiterRank::insert(['name' => 'Klupski sudija']);
        ArbiterRank::insert(['name' => 'Regionalni sudija']);
        ArbiterRank::insert(['name' => 'Drzavni sudija']);
        ArbiterRank::insert(['name' => 'Medjunarodni sudija']);
    }
}
