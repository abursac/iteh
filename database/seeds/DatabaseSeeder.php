<?php

use App\Tournament;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArbiterRanksSeeder::class);
        $this->call(PlayerRanksSeeder::class);
        $this->call(TournamentSeeder::class);
        $this->call(PlayerSeeder::class);
        $this->call(ClubSeeder::class);
        $this->call(PlayerClubRequestSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(DeadlineTypesSeeder::class);
        $this->call(DeadlineSeeder::class);
    }
}
