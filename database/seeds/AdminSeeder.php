<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'email' => 'admin1' . '@gmail.com',
            'password' => bcrypt('ja123')
        ]);

        DB::table('admins')->insert([
            'email' => 'admin2' . '@gmail.com',
            'password' => bcrypt('ja123')
        ]);
    }
}
