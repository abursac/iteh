<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clubs')->insert([
            'name' => 'Sampioni',
            'email' => 'sampioni' . '@gmail.com',
            'password' => bcrypt('klub123'),
            'founded' => date("1999-5-3"),
            'municipality' => 'Vracar',
            'address' => 'Ulica u Beograd 15',
            'phone' => '062047265',
            'confirmed' => '1'
        ]);
        DB::table('clubs')->insert([
            'name' => 'Veverice',
            'email' => 'veverice' . '@gmail.com',
            'password' => bcrypt('klub123'),
            'founded' => date("2001-4-15"),
            'municipality' => 'Dedinje',
            'address' => 'Ulica u Beograd 17',
            'phone' => '063440212',
            'confirmed' => '1'
        ]);
        DB::table('clubs')->insert([
            'name' => 'Bagra',
            'email' => 'bagra' . '@gmail.com',
            'password' => bcrypt('klub123'),
            'founded' => date("2004-4-12"),
            'municipality' => 'Novi Beograd',
            'address' => 'Ulica u Beograd 1',
            'phone' => '065608293'
        ]);
        DB::table('clubs')->insert([
            'name' => 'Majstori',
            'email' => 'majstori' . '@gmail.com',
            'password' => bcrypt('klub123'),
            'founded' => date("1998-6-30"),
            'municipality' => 'Zvezdara',
            'address' => 'Ulica u Beograd 25',
            'phone' => '061239485'
        ]);
        DB::table('clubs')->insert([
            'name' => 'Bubamara',
            'email' => 'bubamara' . '@gmail.com',
            'password' => bcrypt('klub123'),
            'founded' => date("2006-11-1"),
            'municipality' => 'Palilula',
            'address' => 'Ulica u Beograd 67',
            'phone' => '064902061',
            'confirmed' => '1'
        ]);
        DB::table('clubs')->insert([
            'name' => 'Drvored',
            'email' => 'drvored' . '@gmail.com',
            'password' => bcrypt('klub123'),
            'founded' => date("2010-5-5"),
            'municipality' => 'Zemun',
            'address' => 'Ulica u Beograd 45',
            'phone' => '060817356'
        ]);
    }
}
