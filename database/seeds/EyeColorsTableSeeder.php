<?php

use Illuminate\Database\Seeder;

class EyeColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('eye_colors')->insert([
          'name'               => 'Blue'
      ]);
      DB::table('eye_colors')->insert([
          'name'               => 'Green'
      ]);
      DB::table('eye_colors')->insert([
          'name'               => 'Brown'
      ]);
    }
}
