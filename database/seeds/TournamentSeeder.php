<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournaments')->insert([
            'name' => 'turnir',
            'email' => 'momcilo' . '@gmail.com',
            'phone' => '12345678',
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'time' => date("H:i:s"),
            'place' => 'beograd',
            'rounds' => 5,
            'type' => 'player'
        ]);

        DB::table('tournaments')->insert([
            'name' => 'turnir2',
            'email' => 'momcilo' . '@gmail.com',
            'phone' => '12345678',
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'time' => date("H:i:s"),
            'place' => 'nis',
            'rounds' => 7,
            'type' => 'club',
            'playersPerClub' => 4
        ]);


        DB::table('tournaments')->insert([
            'name' => 'turnir3',
            'email' => 'david' . '@gmail.com',
            'phone' => '12345678',
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'time' => date("H:i:s"),
            'place' => 'subotica',
            'rounds' => 7,
            'type' => 'player'
        ]);


        DB::table('tournaments')->insert([
            'name' => 'turnir4',
            'email' => 'dedpul' . '@gmail.com',
            'phone' => '12345678',
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'time' => date("H:i:s"),
            'place' => 'beograd',
            'rounds' => 4,
            'type' => 'club',
            'playersPerClub' => 4
        ]);
    }
}
