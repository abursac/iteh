<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('players')->insert([
            'email' => 'nikola' . '@gmail.com',
            'name' => 'Nikola',
            'surname' => 'Babic',
            'gender' => 'Muski',
            'birth_date' => date("Y-m-d"),
            'rating' => '577',
            'password' => bcrypt('ja123'),
            'confirmed' => '1'
        ]);
        DB::table('players')->insert([
            'email' => 'dedpul' . '@gmail.com',
            'name' => 'Dedpul',
            'surname' => 'Cubrilo',
            'gender' => 'Muski',
            'birth_date' => date("Y-m-d"),
            'rating' => '300',
            'password' => bcrypt('ja123'),
            'confirmed' => '1'
        ]);
        DB::table('players')->insert([
            'email' => 'jovana' . '@gmail.com',
            'name' => 'Jovana',
            'surname' => 'Hinic',
            'gender' => 'Zenski',
            'birth_date' => date("Y-m-d"),
            'rating' => '500',
            'password' => bcrypt('ja123'),
            'confirmed' => '0'
        ]);
        DB::table('players')->insert([
            'email' => 'jelena' . '@gmail.com',
            'name' => 'Jelena',
            'surname' => 'Maric',
            'gender' => 'Zenski',
            'birth_date' => date("Y-m-d"),
            'rating' => '900',
            'password' => bcrypt('ja123'),
            'confirmed' => '1'
        ]);

        DB::table('players')->insert([
            'email' => 'david' . '@gmail.com',
            'name' => 'David',
            'surname' => 'Stanimirovic',
            'gender' => 'Muski',
            'birth_date' => date("Y-m-d"),
            'rating' => '1500',
            'password' => bcrypt('ja123'),
            'confirmed' => '1'
        ]);

        DB::table('players')->insert([
            'email' => 'momcilo' . '@gmail.com',
            'name' => 'Momcilo',
            'surname' => 'Peovic',
            'gender' => 'Muski',
            'birth_date' => date("Y-m-d"),
            'rating' => '1450',
            'password' => bcrypt('ja123'),
            'confirmed' => '1'
        ]);
    }
}
