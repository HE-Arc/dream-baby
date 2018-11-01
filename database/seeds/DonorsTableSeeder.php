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
            'eye_color'             => 0,
            'hair_color'            => 0,
            'skin_color'            => 0,
            'family_antecedents'    => 'psycho brother',
            'medical_antecedents'   => 'depression, anger issues, memory loss',
            'photo_uri'             => 'https://cdn.pixabay.com/photo/2017/06/15/11/39/male-2405126_960_720.jpg',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        
        DB::table('donors')->insert([
            'user_id'               => 2,
            'sex'                   => 0,
            'eye_color'             => 1,
            'hair_color'            => 2,
            'skin_color'            => 1,
            'family_antecedents'    => 'All good',
            'medical_antecedents'   => 'Gluten intolerent',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('donors')->insert([
            'user_id'               => 5,
            'sex'                   => 1,
            'eye_color'             => 1,
            'hair_color'            => 2,
            'skin_color'            => 0,
            'family_antecedents'    => 'A badass genetics. My eggs are the best!',
            'medical_antecedents'   => 'All good',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
