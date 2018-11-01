<?php

use Illuminate\Database\Seeder;

class EthnicitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ethnicities')->insert([
          'name'               => 'Caucasian'
      ]);
      DB::table('ethnicities')->insert([
          'name'               => 'African'
      ]);
      DB::table('ethnicities')->insert([
          'name'               => 'Asian'
      ]);
    }
}
