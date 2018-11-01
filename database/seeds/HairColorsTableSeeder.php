<?php

use Illuminate\Database\Seeder;

class HairColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('hair_colors')->insert([
          'name'               => 'Blond'
      ]);
      DB::table('hair_colors')->insert([
          'name'               => 'Brown'
      ]);
      DB::table('hair_colors')->insert([
          'name'               => 'Red'
      ]);
    }
}
