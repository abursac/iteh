<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeadlineTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deadline_types')->insert(['tip' => 'Rok za uclanjivanje']);
        DB::table('deadline_types')->insert(['tip' => 'Rok za napustanje']);
    }
}
