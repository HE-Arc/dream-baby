<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DonorsTableSeeder extends Seeder
{
    /**
     * Seeds the donor table
     *
     * @return void
     */
    public function run()
    {
        DB::table('donors')->insert([
            'user_id'               => 1,
            'sex'                   => 0,
            'birth_date'            => "1985-04-19",
            'eye_color'             => 1,
            'hair_color'            => 1,
            'ethnicity'             => 1,
            'family_antecedents'    => 'psycho brother',
            'medical_antecedents'   => 'depression, anger issues, memory loss',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('donors')->insert([
            'user_id'               => 2,
            'sex'                   => 0,
            'birth_date'            => "1976-03-28",
            'eye_color'             => 1,
            'hair_color'            => 2,
            'ethnicity'             => 1,
            'family_antecedents'    => 'All good',
            'medical_antecedents'   => 'Gluten intolerent',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('donors')->insert([
            'user_id'               => 5,
            'sex'                   => 1,
            'birth_date'            => "1990-12-24",
            'eye_color'             => 1,
            'hair_color'            => 2,
            'ethnicity'             => 1,
            'family_antecedents'    => 'A badass genetics. My eggs are the best!',
            'medical_antecedents'   => 'All good',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
