<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeadlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deadlines')->insert([
            'start' => '2019-03-02',
            'end' => '2019-05-12',
            'deadline_type_id' => '1'
        ]);

        DB::table('deadlines')->insert([
            'start' => '2020-05-02',
            'end' => '2020-05-19',
            'deadline_type_id' => '1'
        ]);

        DB::table('deadlines')->insert([
            'start' => '2020-05-02',
            'end' => '2020-05-25',
            'deadline_type_id' => '2'
        ]);
    }
}
